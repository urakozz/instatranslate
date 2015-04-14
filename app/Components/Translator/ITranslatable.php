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

namespace App\Components\Translator;


interface ITranslatable
{

    /**
     * Desc
     *
     * @return string
     */
    public function getId();

    /**
     * Desc
     *
     * @return string
     */
    public function getText();

//    public function setTranslated();
//    public function getTranslated();
}