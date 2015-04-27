<?php
namespace App\Http\Controllers;

use App\Components\Translator\Adapters\InstagramAdapter;
use App\Components\Translator\Translator;
use App\Components\Translator\TranslatorAdapter\YandexTranslator;
use App\Response\Users\MediaFeed;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Kozz\Laravel\Facades\Guzzle;
use Kozz\Laravel\LaravelDoctrineCache;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

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

        if ($data = \Cache::get($user->getToken())) {
            $data = unserialize($data);
        } else {
            \Log::info('Instagram call start');
            $t    = microtime(true);
            $data = $this->call($query);
            \Log::info(sprintf("Instagram call end, time is %.04F", microtime(true) - $t));


            $serializer = \JMS\Serializer\SerializerBuilder::create()
                ->setAnnotationReader(new CachedReader(new AnnotationReader(), new LaravelDoctrineCache()))
                ->build();

            \Log::info('Serializer call start');
            $t = microtime(true);
            /** @var MediaFeed $data */
            $data = $serializer->deserialize(json_encode($data), MediaFeed::class, 'json');
            \Log::info(sprintf("Serializer call end, time is %.04F", microtime(true) - $t));

            \Cache::put($user->getToken(), serialize($data), 1);
        }


        \Log::info('Translator call start');
        $t          = microtime(true);
        $translator = new Translator(Guzzle::getFacadeRoot(), new YandexTranslator());
        $translator->setCache(new LaravelDoctrineCache());
        $translator->translate(new InstagramAdapter($data));
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
