<?php
namespace App\Http\Controllers;

use App\Components\Translator\Translator;
use App\Components\User\UserStorage;
use App\Response\Partials\Caption;
use App\Response\Partials\UserInfo;
use App\Response\Users\MediaFeed;
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

        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();

        /** @var MediaFeed $data */
        $data = $serializer->deserialize(json_encode($data), MediaFeed::class, 'json');

        $translator = new Translator();
        $translator->setItems($data);
        $translator->translate();

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
