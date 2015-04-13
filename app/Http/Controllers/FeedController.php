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
        \Session::set('next_max_id', null);
        try {
            $data = $this->getPosts();
        } catch (\Exception $e) {
            \Session::clear();
            return redirect("/logout");
        }
        return view('feed', ['data' => $data]);
    }

    public function next()
    {
        try {
            $data = $this->getPosts(true);
        } catch (\Exception $e) {
            return redirect("/logout");
        }
        return response()->json($data);
    }

    protected function getPosts($next = false)
    {
        $user  = \Auth::getUser();
        $query = ['access_token' => $user->getToken()];

        if($next && $next = \Session::get('next_max_id')){
            $query['next_max_id'] = $next;
        }

        $data = $this->call($query);
        \Session::set('next_max_id', $data['pagination']['next_max_id']);
        return $data['data'];
    }

    protected function call($query)
    {
        $client   = new Client();
        $response = $client->get('https://api.instagram.com/v1/users/self/feed', ['query' => $query]);
        $data     = $response->json();
        $code     = @$data['meta']['code'];
        if($code !== 200){
            throw new \DomainException("Invalid response");
        }
        return $data;
    }

}
