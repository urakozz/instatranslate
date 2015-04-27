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


use App\Components\Translator\TranslatorAdapter\ITranslatorAdapter;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Event\CompleteEvent;
use GuzzleHttp\Pool;

class Translator
{

    /**
     * @var ITranslatorAdapter
     */
    protected $translator;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var \SplObjectStorage
     */
    protected $requestsHash;

    /**
     * @param ClientInterface $guzzle
     * @param ITranslatorAdapter $translator
     */
    public function __construct(ClientInterface $guzzle, ITranslatorAdapter $translator)
    {
        $this->client        = $guzzle;
        $this->translator    = $translator;
        $this->sourcesMap    = new ArrayCollection();
        $this->translatedMap = new ArrayCollection();
        $this->requestsHash  = new \SplObjectStorage();
    }

    /**
     * Desc
     *
     * @param Cache $cache
     * @return void
     */
    public function setCache(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Desc
     *
     * @param ITranslatableContainer $container
     * @return void
     */
    public function translate(ITranslatableContainer $container)
    {
        $requests = $this->generateRequests($container);

        $options = [
            'complete' => function (CompleteEvent $event) {
                /** @var ITranslatable $translatable */
                $translatable = $this->requestsHash[$event->getRequest()];
                $translation  = $this->translator->getTranslation($event->getResponse());
                if ($this->cache) {
                    $this->cache->save($this->getKey($translatable), $translation);
                }
                //$redis = \Redis::getFacadeRoot();
                //var_dump($redis->keys("laravel:tr*"));
                //die;
                $translatable->setTranslation($translation);
            }];
        $pool    = new Pool($this->client, $requests, $options);
        $pool->wait();
    }

    /**
     * Desc
     *
     * @param ITranslatableContainer $container
     * @return \GuzzleHttp\Message\RequestInterface[]
     */
    protected function generateRequests(ITranslatableContainer $container)
    {
        $requests = [];
        $i = $j = 0;
        foreach ($container as $item) {
            if ($cachedTranslation = $this->getCachedTranslation($item)) {
                $item->setTranslation($cachedTranslation);
                $i++;
            } else {
                $request    = $this->createRequest($item);
                $requests[] = $request;
                $this->requestsHash->attach($request, $item);
                $j++;
            }
        }
        var_dump($i, $j);//die;

        return $requests;
    }

    protected function getCachedTranslation(ITranslatable $item)
    {
        return $this->cache ? $this->cache->fetch($this->getKey($item)) : null;
    }

    protected function getKey(ITranslatable $item)
    {
        $key = "tr_" ;//. crc32(get_class($this->translator) . ":" . get_class($item));
        $key .= "_" . $item->getId();
        return $key;
    }


    /**
     * Desc
     *
     * @param ITranslatable $item
     * @return \GuzzleHttp\Message\RequestInterface
     */
    protected function createRequest(ITranslatable $item)
    {
        return $this->client->createRequest(
            'POST',
            $this->translator->getUrl(),
            ['body' => $this->translator->getRequestAttributes($item)]
        );
    }


}