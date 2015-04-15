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


interface ITranslatableContainer
{

    /**
     * Desc
     *
     * @return ITranslatable[]
     */
    public function getTranslatable();
}