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



use Doctrine\Common\Cache\Cache;

class TranslationRepositoryCache implements ITranslationRepository
{
    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Desc
     *
     * @param int $id
     * @return string
     */
    public function getKey($id)
    {
       return "tr_".$id;
    }

    /**
     * Desc
     *
     * @param $id
     * @param $text
     * @return bool
     */
    public function save($id, $text)
    {
        $this->cache->save($this->getKey($id), $text);
        return true;
    }

    /**
     * Desc
     *
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->cache->fetch($this->getKey($id));
    }
}