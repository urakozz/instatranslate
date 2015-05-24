<?php
namespace App\Http\Controllers;

use App\Components\Translator\Adapters\InstagramAdapter;
use App\Components\Translator\Repository\TranslationRepositoryCache;
use App\Components\Translator\Translator;
use App\Components\Translator\TranslatorAdapter\BingTranslator;
use Instagram\Client\Config\TokenConfig;
use Instagram\Client\InstagramClient;
use Instagram\Request\Users\SelfFeedRequest;
use Instagram\Response\Users\SelfFeed;
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
     * @throws \Exception
     *
     * @return \Response
     */
    public function index()
    {
        \Session::set('next_max_id', null);
        try {
            //$data = $this->getPosts();
        } catch (\Exception $e) {
//            \Session::clear();
//            return redirect("/logout");
            throw $e;
        }
        $feed = new SelfFeed();
        $feed->setData([]);
        return view('feed', ['data' => $feed]);
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
        $user = \Auth::getUser();

        $data = \Cache::get($user->getToken());

        if (!$data) {

            $client = new InstagramClient(new TokenConfig($user->getToken()));
            \Log::info('Instagram call start');
            $t    = microtime(true);
            $data = $client->call(new SelfFeedRequest());
            \Log::info(sprintf("Serializer call end, time is %.04F", microtime(true) - $t));

            \Cache::put($user->getToken(), $data, 1);
        }


        \Log::info('Translator call start');
        $t          = microtime(true);
        $translator = new Translator(Guzzle::getFacadeRoot(), new BingTranslator());
        $translator->setRepository(new TranslationRepositoryCache(new LaravelDoctrineCache()));
        $translator->translate(new InstagramAdapter($data));
        \Log::info(sprintf("Translator call end, time is %.04F", microtime(true) - $t));

        return $data;
    }

}
