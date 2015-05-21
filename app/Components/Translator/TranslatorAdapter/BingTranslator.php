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

namespace App\Components\Translator\TranslatorAdapter;


use App\Components\Translator\ITranslatable;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\ResponseInterface;

class BingTranslator extends AbstractTranslatorAdapter
{

    public function getUrl()
    {
        # https://datamarket.azure.com/account/datasets
        return 'https://api.datamarket.azure.com/Bing/MicrosoftTranslator/v1/Translate';
    }

    protected function getTranslation(ResponseInterface $response)
    {
        $content = $response->getBody()->getContents();
        $content = json_decode($content);
        return reset($content->d->results)->Text;
    }

    public function getRequestAttributes(ITranslatable $item)
    {
        return [
            'Text'=>"'".$this->getCleanedText($item)."'",
            "To"=>"'ru'",
            '$format'=>'json'
        ];
    }

    public function getBasicAuth()
    {
        return [env('M_API_KEY'), env('M_API_KEY'), 'basic'];
    }

    public function createRequest(ClientInterface $client, ITranslatable $item)
    {
        return $client->createRequest("GET", $this->getUrl(), ['query'=>$this->getRequestAttributes($item), 'auth'=>$this->getBasicAuth()]);
    }
}