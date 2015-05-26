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

namespace App\Components\Translator\Repository;


interface ITranslationRepository
{

    public function getKey($id);

    public function save($id, $text);

    public function get($id);

    public function has($id);

}