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

class Meta
{
    /**
     * @var int
     * @Type("integer")
     */
    protected $code;

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
}