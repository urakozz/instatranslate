<?php
namespace App\Http\Controllers;

use App\Components\Translator\Translator;
use App\Components\User\UserStorage;
use App\Response\Partials\Caption;
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
//            \Session::clear();
//            return redirect("/logout");
            throw $e;
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

        if ($next && $next = \Session::get('next_max_id')) {
            $query['next_max_id'] = $next;
        }

        $data = $this->call($query);
        \Session::set('next_max_id', $data['pagination']['next_max_id']);
        $captions = new \SplDoublyLinkedList();
        foreach ($data['data'] as $post) {
            if (null === $post['caption']) continue;

            $captions[] = new Caption($post['caption']);
        }
        $translator = new Translator();
        $translator->setItems($captions);
        $translate = $translator->translate();

        $translations = [];
        foreach ($data['data'] as $post) {
            $translations[$post['caption']['id']] =
                isset($translate[$post['caption']['id']])
                    ? $translate[$post['caption']['id']]
                    : null;
        }
        $data['translations'] = $translations;
        return $data;
    }

    protected function call($query)
    {
        $client   = new Client();
        $response = $client->get('https://api.instagram.com/v1/users/self/feed', ['query' => $query]);
        $data     = $response->json();
        $code     = @$data['meta']['code'];
        if ($code !== 200) {
            throw new \DomainException("Invalid response");
        }
        return $data;
    }

}
