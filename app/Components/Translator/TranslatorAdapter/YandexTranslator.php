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
use Psr\Http\Message\ResponseInterface;

class YandexTranslator extends AbstractTranslatorAdapter
{

    protected $url = 'https://translate.yandex.net/api/v1.5/tr.json/translate';

    public function getUrl()
    {
        return $this->url;
    }


    public function getTranslation(ResponseInterface $response)
    {
        $content = $response->getBody()->getContents();
        $content = json_decode($content);
        return reset($content->text);
    }

    public function getRequestAttributes(ITranslatable $item)
    {
        return [
            'key' => env('Y_API_KEY'),
            'lang' => 'ru',
            'options' => '1',
            'text' => $this->getCleanedText($item)
        ];
    }

    public function createRequest(ClientInterface $client, ITranslatable $item)
    {
        return $client->requestAsync("POST", $this->getUrl(), ['form_params'=>$this->getRequestAttributes($item)]);
    }
}