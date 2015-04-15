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

namespace App\Response\Partials\Sequence;


use App\Response\Partials\Caption;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

/**
 * PHP Version 5
 *
 * Class Comments
 *
 * @package App\Response\Partials\Sequence
 * @method Caption[] getData()
 */
class Comments extends AbstractSequence
{

    /**
     * @var ArrayCollection | Caption[]
     * @Type("ArrayCollection<App\Response\Partials\Caption>")
     */
    protected $data;

}