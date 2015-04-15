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

namespace App\Response\Partials\Image;


use JMS\Serializer\Annotation\Type;

class Images
{

    /**
     * @var ImageDetails
     * @Type("App\Response\Partials\Image\ImageDetails")
     */
    protected $thumbnail;

    /**
     * @var ImageDetails
     * @Type("App\Response\Partials\Image\ImageDetails")
     */
    protected $lowResolution;

    /**
     * @var ImageDetails
     * @Type("App\Response\Partials\Image\ImageDetails")
     */
    protected $standardResolution;

    /**
     * @return ImageDetails
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param ImageDetails $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return ImageDetails
     */
    public function getLowResolution()
    {
        return $this->lowResolution;
    }

    /**
     * @param ImageDetails $lowResolution
     */
    public function setLowResolution($lowResolution)
    {
        $this->lowResolution = $lowResolution;
    }

    /**
     * @return ImageDetails
     */
    public function getStandardResolution()
    {
        return $this->standardResolution;
    }

    /**
     * @param ImageDetails $standardResolution
     */
    public function setStandardResolution($standardResolution)
    {
        $this->standardResolution = $standardResolution;
    }


}