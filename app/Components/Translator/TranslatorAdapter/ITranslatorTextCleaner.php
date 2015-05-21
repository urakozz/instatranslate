<?php
/**
 * PHP Version 5
 *
 * @package   
 * @author    "Yury Kozyrev" <urakozz@gmail.com>
 * @copyright 2015 "Yury Kozyrev" 
 * @license   MIT
 * @link      https://github.com/urakozz/php-instagram-client
 */

namespace App\Components\Translator\TranslatorAdapter;


use App\Components\Translator\ITranslatable;

interface ITranslatorTextCleaner
{
    public function getCleanedText(ITranslatable $item);
}