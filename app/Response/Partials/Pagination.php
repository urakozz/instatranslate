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

namespace App\Response\Partials;


use JMS\Serializer\Annotation\Type;

class Pagination
{
    /**
     * @var string
     * @Type("string")
     */
    protected $nextUrl;

    /**
     * @var string
     * @Type("string")
     */
    protected $nextMaxId;

    /**
     * @return string
     */
    public function getNextUrl()
    {
        return $this->nextUrl;
    }

    /**
     * @param string $nextUrl
     */
    public function setNextUrl($nextUrl)
    {
        $this->nextUrl = $nextUrl;
    }

    /**
     * @return string
     */
    public function getNextMaxId()
    {
        return $this->nextMaxId;
    }

    /**
     * @param string $nextMaxId
     */
    public function setNextMaxId($nextMaxId)
    {
        $this->nextMaxId = $nextMaxId;
    }

}