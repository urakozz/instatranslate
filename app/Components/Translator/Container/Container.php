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


use App\Components\Translator\ITranslatable;
use App\Components\Translator\ITranslatableContainer;

class Container extends \ArrayObject implements ITranslatableContainer
{
    public function offsetSet($id, $item)
    {
        if(!$item instanceof ITranslatable){
            throw new \DomainException("You shall not pass, ".get_class($item));
        }
        parent::offsetSet($id, $item);
    }

    public function getIterator()
    {
        return $this->getTranslatable();
    }

    /**
     * Desc
     *
     * @return ITranslatable[]
     */
    public function getTranslatable()
    {
        return parent::getIterator();
    }
}