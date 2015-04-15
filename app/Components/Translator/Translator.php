<?php
/**
 * PHP Version 5
 *
 * @category  H24
 * @package
 * @author    "Yury Kozyrev" <yury.kozyrev@home24.de>
 * @copyright 2015 Home24 GmbH
 * @license   Proprietary license.
 * @link      http://www.home24.de
 */

namespace App\Components\Translator;


use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\Event\CompleteEvent;
use GuzzleHttp\Pool;

class Translator
{

    protected $url = 'https://translate.yandex.net/api/v1.5/tr.json/translate';

    /**
     * @var ITranslatableContainer
     */
    protected $container;

    /**
     * @var ArrayCollection | ITranslatable[]
     */
    protected $sourcesMap;

    /**
     * @var ArrayCollection | ITranslatable[]
     */
    protected $translatedMap = [];

    public function __construct()
    {
        $this->sourcesMap    = new ArrayCollection();
        $this->translatedMap = new ArrayCollection();
    }

    public function setItems(ITranslatableContainer $container)
    {
        $this->container = $container;
        $this->collectHashMap($container);
    }

    public function translate()
    {
        $client   = new \GuzzleHttp\Client();
        $requests = [];
        $hash     = new \SplObjectStorage();
        foreach ($this->sourcesMap as $id => $item) {
            $request    = $client->createRequest('POST', $this->url, ['body' => $this->getRequestAttributes($item)]);
            $requests[] = $request;
            $hash->attach($request, $item);
        }
        $options = [
            'complete' => function (CompleteEvent $event) use ($hash) {
                /** @var ITranslatable $translatable */
                $translatable = $hash[$event->getRequest()];
                $content = $event->getResponse()->getBody()->getContents();
                $content = json_decode($content);
                $translatable->setTranslation(reset($content->text));
            }];
        $pool    = new Pool($client, $requests, $options);
        $pool->wait();
    }

    protected function collectHashMap(ITranslatableContainer $container)
    {
        foreach ($container->getTranslatable() as $translatable) {
            if (null === $translatable) continue;
            $this->sourcesMap[$translatable->getId()] = $translatable;
        }
    }

    protected function getRequestAttributes(ITranslatable $item)
    {
        return [
            'key' => env('Y_API_KEY'),
            'lang' => 'ru',
            'options' => '1',
            'text' => $item->getText()
        ];
    }
}