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
use GuzzleHttp\Message\ResponseInterface;

class BingTranslator implements ITranslatorAdapter
{

    public function getUrl()
    {
        return 'https://api.datamarket.azure.com/Bing/MicrosoftTranslator/v1/Translate';
    }

    public function getTranslation(ResponseInterface $response)
    {

        $content = $response->getBody()->getContents();

    }

    public function getRequestAttributes(ITranslatable $item)
    {
        return [
            'Text'=>$item->getText(),
            "To"=>'ru',
            "appId"=>env('M_API_KEY')
        ];
    }

    public function getBasicAuth()
    {
        return [env('M_API_CLIENT'), env('M_API_KEY')];
    }
}