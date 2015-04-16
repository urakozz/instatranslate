<?php
namespace App\Http\Controllers;

use App\Components\Translator\Translator;
use App\Response\Users\MediaFeed;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Kozz\Laravel\Facades\Guzzle;
use Kozz\Laravel\LaravelDoctrineCache;

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

        \Log::info('Instagram call start');
        $t = microtime(true);
        $data = $this->call($query);
        \Log::info(sprintf("Instagram call end, time is %.04F", microtime(true) - $t));


        \Log::info('Serializer call start');
        $t = microtime(true);
        $serializer = \JMS\Serializer\SerializerBuilder::create()
            //->setAnnotationReader(new CachedReader(new AnnotationReader(), new LaravelDoctrineCache()))
            ->build();

        /** @var MediaFeed $data */
        $data = $serializer->deserialize(json_encode($data), MediaFeed::class, 'json');
        \Log::info(sprintf("Serializer call end, time is %.04F", microtime(true) - $t));

        \Log::info('Translator call start');
        $t = microtime(true);
        $translator = new Translator();
        $translator->setItems($data);
        $translator->translate();
        \Log::info(sprintf("Translator call end, time is %.04F", microtime(true) - $t));

        return $data;
    }

    protected function call($query)
    {
        $response = Guzzle::get('https://api.instagram.com/v1/users/self/feed', ['query' => $query]);
        $data     = $response->json();
        $code     = @$data['meta']['code'];
        if ($code !== 200) {
            throw new \DomainException("Invalid response");
        }
        return $data;
    }

}
