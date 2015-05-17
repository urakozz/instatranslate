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


class TranslationRepositoryNone implements ITranslationRepository
{

    public function getKey($id)
    {
        return $id;
    }

    public function save($id, $text)
    {
        return true;
    }

    public function get($id)
    {
        return null;
    }
}