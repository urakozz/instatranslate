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

namespace App\Response;


use App\Response\Partials\Meta;
use App\Response\Partials\Pagination;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class InstagramResponse
{

    /**
     * @var ArrayCollection
     */
    protected $data;

    /**
     * @var Meta
     * @Type("App\Response\Partials\Meta")
     */
    protected $meta;

    /**
     * @var Pagination
     * @Type("App\Response\Partials\Pagination")
     */
    protected $pagination;

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

    /**
     * @return Meta
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param Meta $meta
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
    }

    /**
     * @return Pagination
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @param Pagination $pagination
     */
    public function setPagination($pagination)
    {
        $this->pagination = $pagination;
    }
}