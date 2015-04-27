<?php
namespace App\Components\Translator\Adapters;

use App\Components\Translator\ITranslatableContainer;

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
abstract class AbstractTranslatableAdapter implements ITranslatableContainer
{

    public function getIterator()
    {
        return $this->getTranslatable();
    }
}