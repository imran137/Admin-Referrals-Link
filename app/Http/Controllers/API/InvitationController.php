<?php
namespace App\Http\Controllers\API;

use App\User; 
use Validator;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use File;

class InvitationController extends Controller
{
    CONST HTTP_OK = Response::HTTP_OK;
    CONST HTTP_CREATED = Response::HTTP_CREATED;
    CONST HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;

    public function invitation(Request $request){

        if(DB::table('users')->where(['id' => auth()->user()->id, 'role' => 1])->exists()){
            $this->validate($request, [
                'email' => 'required|email',
            ]);

            $details = [
                'id' => auth()->user()->id
            ];

            \Mail::to($request->email)->send(new \App\Mail\InvitationMail($details));
            $success = 'success';
            $response = self::HTTP_OK;
            return http_response( "success", $success, $response);

        } else {
            $error = "User has no admin role";
            $response = self::HTTP_UNAUTHORIZED;
            return http_response( "Error", $error, $response);
        }
    }

    public function register(Request $request, $refererID){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:5000|dimensions:max_width=256,max_height=256'
        ]);

        if ($validator->fails()){
          return response()->json([ 'error'=> $validator->errors() ]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->reference = $refererID;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 2;

        if ($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'_'.$image->getClientOriginalName();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);

            $user->image = $name;
        }

        $random_number = substr(time(), 4, 10);
        $details = [
            'random_number' => $random_number
        ];
        \Mail::to($request->email)->send(new \App\Mail\ActivateAccountMail($details));            

        $user->random_number = $random_number;
        $user->save();
        return response()->json(['success' => 'User created successfully & send email with six digit token to activate account', 'data' => $user]);
    }

    public function activate(Request $request){
        $user = User::where(['random_number' => $request->random_number])->first();
        if(!$user){
            return response()->json(['erroe' => 'Please add correct PIN']);

        } else {
            if(DB::table('users')->where(['random_number' => $request->random_number, 'status' => 1])->exists()){
                return response()->json(['error' => 'Already activated']);
    
            } else {
                $user->status = 1; 
                $user->save();
                return response()->json(['success' => 'Account successfully activated.', 'data' => $user]);
            }
        }
    }
}