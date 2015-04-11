<?php
namespace App\Http\Controllers;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return \Response
	 */
	public function index()
	{
		if(\Session::get('user')){
			return redirect("/feed");
		}
		$link = sprintf("https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&response_type=code", env("I_CLIENT_ID"), \URL::to('/auth'));
		return view('index', ['link' => $link]);
	}

}
