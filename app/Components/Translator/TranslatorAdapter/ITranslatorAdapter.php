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

interface ITranslatorAdapter
{
    public function getUrl();

    public function applyTranslation(ResponseInterface $response, ITranslatable $item);

    public function getRequestAttributes(ITranslatable $item);

    public function createRequest(ClientInterface $client, ITranslatable $item);
}