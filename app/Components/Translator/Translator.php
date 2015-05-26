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


use App\Components\Translator\Repository\ITranslationRepository;
use App\Components\Translator\TranslatorAdapter\ITranslatorAdapter;
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
     * @var ITranslationRepository
     */
    protected $repository;

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
     * @param ITranslationRepository $repository
     * @return void
     */
    public function setRepository(ITranslationRepository $repository)
    {
        $this->repository = $repository;
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
                $this->translator->applyTranslation($event->getResponse(), $translatable);
                if ($this->repository) {
                    $this->repository->save($translatable->getId(), $translatable->getTranslation());
                }
            }];
        $pool    = new Pool($this->client, $requests, $options);
        $pool->wait();
    }

    /**
     * Desc
     *
     * @param ITranslatableContainer|ITranslatable[] $container
     * @return \GuzzleHttp\Message\RequestInterface[]
     */
    protected function generateRequests(ITranslatableContainer $container)
    {
        $requests = [];
        $i        = $j = 0;
        foreach ($container as $item) {
            if ($this->hasCachedTranslation($item)) {
                $cachedTranslation = $this->getCachedTranslation($item);
                $item->setTranslation($cachedTranslation);
                $i++;
            } else {
                $request    = $this->createRequest($item);
                $requests[] = $request;
                $this->requestsHash->attach($request, $item);
                $j++;
            }
        }
        //var_dump($i, $j);//die;

        return $requests;
    }

    protected function getCachedTranslation(ITranslatable $item)
    {
        return $this->repository ? $this->repository->get($item->getId()) : null;
    }

    protected function hasCachedTranslation(ITranslatable $item)
    {
        return $this->repository ? $this->repository->has($item->getId()) : false;
    }

    /**
     * Desc
     *
     * @param ITranslatable $item
     * @return \GuzzleHttp\Message\RequestInterface
     */
    protected function createRequest(ITranslatable $item)
    {
        return $this->translator->createRequest($this->client, $item);
    }


}