<?php

function http_response( string $status = null, $data = null, $response ){

    return response()->json([

        'status' => $status, 
        'data' => $data,

    ], $response);
}

function get_user_token( $user, string $token_name = null ){
    return $user->createToken($token_name)->accessToken; 
}
