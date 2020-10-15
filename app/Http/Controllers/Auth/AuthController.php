<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller {
	/**
     * Get login page
     * @return \Illuminate\View\View
    */
    public function loginPage(){
    	return view('auth/login', [
    		'title' => 'Login'
    	]);
    }

    /**
     * Get registration page
     * @return \Illuminate\View\View
    */
    public function registerPage(){
    	return view('auth/register', [
    		'title' => 'Register'
    	]);
    }

    /**
     * Get forgot password page
     * @return \Illuminate\View\View
    */
    public function forgotPage(){
        return view('auth/forgot', [
            'title' => 'Recover Password'
        ]);
    }
}
