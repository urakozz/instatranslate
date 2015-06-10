<?php namespace App\Jobs;

use App\Components\Translator\Adapters\InstagramAdapter;
use App\Components\Translator\Repository\TranslationRepositoryCache;
use App\Components\Translator\Translator;
use App\Components\Translator\TranslatorAdapter\BingTranslator;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Instagram\Client\Config\TokenConfig;
use Instagram\Client\InstagramClient;
use Instagram\Request\Users\SelfFeedRequest;
use Kozz\Laravel\Facades\Guzzle;
use Kozz\Laravel\LaravelDoctrineCache;

class GetTranslations extends Command implements SelfHandling, ShouldBeQueued
{

    use InteractsWithQueue, SerializesModels;

    protected $token;

    /**
     * Create a new command instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->attempts() > 1)
        {
            \Log::debug(json_encode(get_object_vars($this)));
            $this->delete();
        }
        $client = new InstagramClient(new TokenConfig($this->token));
        $data = $client->call(new SelfFeedRequest());
        if(!$data->isOk()){
            return "Token Expired: ".$this->token;
        }

        $translator = new Translator(Guzzle::getFacadeRoot(), new BingTranslator());
        $translator->setRepository(new TranslationRepositoryCache(new LaravelDoctrineCache()));
        $translator->translate(new InstagramAdapter($data));
    }

}
