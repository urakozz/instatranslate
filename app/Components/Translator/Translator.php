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


use GuzzleHttp\Event\CompleteEvent;
use GuzzleHttp\Pool;

class Translator
{

    protected $url = 'https://translate.yandex.net/api/v1.5/tr.json/translate';

    /**
     * @var ITranslatable[]
     */
    protected $items;

    protected $res = [];

    public function setItems(\Iterator $array)
    {
        $this->items = $array;
    }

    public function translate()
    {
        $client = new \GuzzleHttp\Client();
        $requests = [];
        foreach ($this->items as $item) {
            $requests[] = $client->createRequest('POST', $this->url, ['body'=>$this->getAttributes("__".$item->getId()."__ ".$item->getText())]);
        }
        $options = [
            'complete' => function (CompleteEvent $event) {
                //$event->getRequest()->getBody();
                $content = $event->getResponse()->getBody()->getContents();
                $content = json_decode($content);
                $this->res[] = reset($content->text);
        }];
        $pool = new Pool($client, $requests, $options);
        $pool->wait();

        $proc = [];
        foreach($this->res as $res){
            $id = preg_replace("/^\_\_(\d+).*/iu", "$1", $res);
            $proc[$id] = str_replace("__{$id}__", "", $res);
        }
        return $proc;
    }

    protected function getAttributes($text)
    {
        return [
            'key' => env('Y_API_KEY'),
            'lang' =>'ru',
            'options'=>'1',
            'text' =>$text
        ];
    }
}