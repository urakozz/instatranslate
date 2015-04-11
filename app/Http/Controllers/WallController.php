<?php
namespace App\Http\Controllers;

class WallController extends Controller {

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
		try{
			$user = \Session::get('user');
			$user = @unserialize($user);
			if(!$user instanceof \App\User){
				throw new \DomainException("Unable unserialize");
			}
			\Auth::setUser($user);

		}catch (\Exception $e){
			\Session::clear();
			return redirect("/");
		}
		return view('wall',['user'=>$user]);
	}

}
