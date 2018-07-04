<?php

namespace HomeMoney\Http\Controllers\Auth;

use HomeMoney\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public $redirectTo = '/top';
/*
    public function showLoginForm($param = null)
    {
    	return view('auth.login', array('param' => $param));
    }
*/
    public function logout(Request $request)
    {
    	$this->guard()->logout();
    
    	$request->session()->invalidate();
    
    	return redirect()->route('login')->with('param', 'logout');
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
