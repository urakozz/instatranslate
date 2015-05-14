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

namespace App\Components\Translator\Proxy;


use App\Components\Translator\ITranslatable;
use Instagram\Response\Partials\Caption;

class InstagramTranslatableProxy implements ITranslatable
{

    /**
     * @var Caption
     */
    protected $original;

    public function __construct(Caption $caption)
    {
        $this->original = $caption;
    }

    /**
     * Desc
     *
     * @return string
     */
    public function getId()
    {
        return $this->original->getId();
    }

    /**
     * Desc
     *
     * @return string
     */
    public function getText()
    {
        return $this->original->getText();
    }

    public function setTranslation($string)
    {
        $this->original->setTranslation($string);
    }

    public function getTranslation()
    {
        return $this->original->getTranslation();
    }
}