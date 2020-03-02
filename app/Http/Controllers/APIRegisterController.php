<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class APIRegisterController extends Controller
{
    public function register(Request $request){
    	$validator = Validator::make($request->all(),[
    		'email' 	=> 'required|max:255|unique:users|string|email',
    		'name'		=> 'required|string',
    		'password'	=> 'required|min:6|confirmed|string'
    	]);

    	if ($validator->fails()) {
    		return response()->json($validator->errors()->toJson(), 400);
    	}

    	User::create([
    		'name'		=> $request->get('name'),
    		'email'		=> $request->get('email'),
    		'password'	=> bcrypt($request->get('password')),
    	]);
    	$user 	= User::first();
    	$token	= JWTAuth::fromUser($user);

    	return Response::json(compact('token'));
    }
}
