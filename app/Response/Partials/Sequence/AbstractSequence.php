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


use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class AbstractSequence
{

    /**
     * @var int
     * @Type("integer")
     */
    protected $count;

    /**
     * @var ArrayCollection
     */
    protected $data;

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return ArrayCollection
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param ArrayCollection $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}