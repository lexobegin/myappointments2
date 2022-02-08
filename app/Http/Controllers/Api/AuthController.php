<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use JwtAuth;

class AuthController extends Controller
{
    public function login(Request $request){
    	
    	$credencials = $request->only('email','password');

    	
    	if (Auth::guard('api')->attempt($credencials)) {
    		$user = Auth::guard('api')->user();
    
    		$jwt = JwtAuth::generateToken($user);
    		$success = true;
    
    		// Return successfull sign in response with the generated jwt.
    		//$data = compact('user', 'jwt');
    		return compact('success', 'user', 'jwt');
		} else {
    		// Return response for failed attempt...
    		$success = false;
    		$message = 'Invalid credentials';
    		return compact('success', 'message');
		}
		
    }

    public function logout(){
    	Auth::guard('api')->logout();
    	$success = true;
    	return compact('success');
    }
}
