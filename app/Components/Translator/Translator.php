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
use GuzzleHttp\Pool;
use GuzzleHttp\Promise\EachPromise;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

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
     * @var ArrayCollection
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
        $this->requestsHash  = new ArrayCollection();
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

        $requests  = $this->generateRequests($container);
        $responses = new \ArrayObject();
        $rejected  = new \ArrayObject();

        $promise = new EachPromise($requests, [
            'fulfilled' => function (ResponseInterface $value, $idx, PromiseInterface $p) use ($responses) {
                $translatable = $this->requestsHash->get($idx);
                $this->translator->applyTranslation($value, $translatable);
                if ($this->repository) {
                    $this->repository->save($translatable->getId(), $translatable->getTranslation());
                }
            },
            'rejected' => function ($reason, $idx, PromiseInterface $aggregate) use ($rejected) {
                $rejected[$idx] = $reason;
            }
        ]);

        $res = $promise
            ->promise()
            ->then(function () use ($responses) {
                return $responses;
            })
            ->wait();
//        var_dump($responses);
//        echo "<br>---------------<br>";
//        var_dump($res);
//
//        echo "<br>---------------<br>";
//        var_dump(count($rejected));
//        die;

    }

    /**
     * Desc
     *
     * @param ITranslatableContainer|ITranslatable[] $container
     * @return PromiseInterface[]
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
                $request                  = $this->createRequest($item);
                $requests[$item->getId()] = $request;
                $this->requestsHash->set($item->getId(), $item);
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
     * @return PromiseInterface
     */
    protected function createRequest(ITranslatable $item)
    {
        return $this->translator->createRequest($this->client, $item);
    }


}