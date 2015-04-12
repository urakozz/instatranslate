<?php
namespace App\Http\Controllers;

use GuzzleHttp\Client;

class FeedController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return \Response
     */
    public function index()
    {
        try {
            $user = \Auth::getUser();
            $query = ['access_token' => $user->getToken()];

            $client   = new Client();
            $response = $client->get('https://api.instagram.com/v1/users/self/feed', ['query' => $query]);
            $data     = $response->json();

        } catch (\Exception $e) {
            \Session::clear();
            return redirect("/");
        }
        return view('feed', ['user' => $user, 'data' => $data]);
    }

}
