<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use Illuminate\Support\Fascades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class APILoginController extends Controller
{
	public function login(Request $req){
		$validator =  Validator::make($req->all(), [
			'email'		=> 'required|string|email|min:5',
			'password' 	=> 'required'
		]);

		if ($validator->fails()) {
			return response()->json($validator->errors());
		}

		$credentials = $req->only('email', 'password');
		$token = null;
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json(['error' => 'invalid_credentials'], 401); //401 is for toke invalids
			}
			return response()->json(['success' => true, 'token' => $token]);
		// try{
		// 	if (! $token = JWTAuth::attempt($credentials)) {
		// 		return response()->json(['error' => 'invalid_credentials'], 401); //401 is for toke invalids
		// 	}
		// } catch (JWTException $e) {
		// 	return response()->json(['error'=>'could_not_create_token'], 500); //500 is for server error
		// }

		// return response()->json(compact('token'));
	}

	public function logout(){
		if (JWTAuth::invalidate()) {
			return response()->json([
				'status' 	=> 'success',
				'message'	=> 'logged out successfully'
			], 200);
		}else{
			return response()->json(['message' => "Fail"], 401);
		}

	}

	// public function logout(Request $req){
	// 	// $this->validate($req, [
	// 	// 	'token' => 'required'
	// 	// ]);

	// 	// try{
	// 	// 	JWTAuth::invalidate($req->token);

	// 	// 	return response()->json([
	// 	// 		'success'	=> true,
	// 	// 		'message' 	=> "User Logged Out successfully"
	// 	// 	]);
	// 	// }catch(JWTException $ex){
	// 	// 	return response()->json([
	// 	// 		'success'	=> false,
	// 	// 		'message'	=> "Sorry, the user failed to log out"
	// 	// 	], 500);
	// 	// }

	// 	auth()->logout();
	// 	return response()->json(['message' => "successfully Logout"]);
	// }
}
