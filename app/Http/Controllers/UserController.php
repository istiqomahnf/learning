<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
// use Illuminate\Support\Fascades\Hash;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class UserController extends Controller
{
    public function login(Request $request){
    	$credentials 	= $request->only('email', 'password');

    	try{
    		if (! $token = JWTAuth::attempt($credentials)) {
    			return response()->json(['error'=>'invalid_credentials'], 400);
    		}
    	}catch(JWTException $e){
    		return response()->json(['error'=>'could_not_create_token'],500);
    	}
    	$request->session()->put('header',$token);
    	return response()->json(compact('token'));
    }

    public function register(Request $request){
    	$validator = Validator::make($request->all(),[
    		'email' 	=> 'required|max:255|unique:users|string|email',
    		'name'		=> 'required|string',
    		'password'	=> 'required|min:6|confirmed|string'
    	]);

    	if ($validator->fails()) {
    		return response()->json($validator->errors()->toJson(), 400);
    	}

    	$user = User::create([
    		'name'		=> $request->get('name'),
    		'email'		=> $request->get('email'),
    		'password'	=> bcrypt($request->get('password')),
    	]);

    	$token = JWTAuth::fromUser($user);
    	return response()->json(compact('user', 'token'), 201);
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        try{
            if (JWTAuth::invalidate(JWTAuth::getToken())) {
                 return response()->json([
                    'status'    => "Success",
                    'message'   => "Successfully Logged out"
                ]);
            }
        }catch(JWTException $e){
            return response()->json([
                'status'    => "error",
                'message'   => "Failed to log out"
            ], 500);
        }
    }

    public function refresh()
    {
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);
        return response()->json([
            'refresh_token' => $newToken], 201);
    }

    public function getAuthenticatedUser(){
    	try{
    		if (! $user = JWTAuth::parseToken()->authenticate()) {
    			return response()->json(['user_not_found'], 404);			
    		}
    	}catch(Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
    		return response()->json(['token_expired'], $e->getStatusCode());
    	}catch(Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
    		return response()->json(['token_invalid'], $e->getStatusCode());
    	}catch(Tymon\JWTAuth\Exceptions\JWTException $e){
    		return response()->json(['token_absent'], $e->getStatusCode());
    	}
    	return response()->json(compact('user'));
    	
    }

    public function getbearerToken(Request $request)
	{
	    // $header = $request->header('Authorization');
		$header = $request->bearerToken();
	    return response()->json(['token' => $header]);
	}
	public function gettoken(Request $request){
		$token = $request->session()->get('header');
		return response()->json(['token' => $token]);
	}
}
