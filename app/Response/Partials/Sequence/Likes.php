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


use App\Response\Partials\UserInfo;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class Likes extends AbstractSequence{

    /**
     * @var ArrayCollection | UserInfo[]
     * @Type("ArrayCollection<App\Response\Partials\UserInfo>")
     */
    protected $data;

}