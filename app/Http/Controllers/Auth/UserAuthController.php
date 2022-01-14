<?php
namespace App\Http\Controllers\Auth;

use App\User; 
use Validator;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

class UserAuthController extends Controller
{
    CONST HTTP_OK = Response::HTTP_OK;
    CONST HTTP_CREATED = Response::HTTP_CREATED;
    CONST HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) { 

          return response()->json([ 'error'=> $validator->errors() ]);

        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $data['reference'] = 0;
        $data['role'] = 1;
        $data['status'] = 1;
        $user = User::create($data);

        $success['name'] =  $user->name;
        $response =  self::HTTP_CREATED;
        return http_response( "success", $success, $response);
    }

    public function login(Request $request){ 
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = [
            'email' => $request->email, 
            'password' => $request->password,
            'status' => 1,
        ];

        if(auth()->attempt($credentials)){ 
            $user = Auth::user();
            $token['token'] = get_user_token($user,"clientToken");
            $response = self::HTTP_OK;
            return http_response( "success", $token, $response );

        } else {
            $error = "Unauthorized Access";
            $response = self::HTTP_UNAUTHORIZED;
            return http_response( "Error", $error, $response);
        }

    }
    
    public function logout (Request $request) {
        if (Auth::check()) {
           Auth::user()->AauthAcessToken()->delete();
        }

        return response(['message' => 'You have been successfully logged out.'], 200);
    }
}