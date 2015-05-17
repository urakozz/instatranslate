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

namespace App\Components\Translator\Container;


class Item implements ITranslatable{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $translation;

    /**
     * @param string $id
     * @param string $text
     */
    public function __construct($id, $text)
    {
        $this->id   = $id;
        $this->text = $text;
    }

    /**
     * Desc
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Desc
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    public function setTranslation($string)
    {
        $this->translation = $string;
    }

    public function getTranslation()
    {
        return $this->translation;
    }
}