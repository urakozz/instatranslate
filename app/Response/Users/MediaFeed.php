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

namespace App\Response\Users;


use App\Components\Translator\ITranslatable;
use App\Components\Translator\ITranslatableContainer;
use App\Response\InstagramResponse;
use App\Response\Partials\Media;
use JMS\Serializer\Annotation\Type;

class MediaFeed extends InstagramResponse
{
    /**
     * @var Media[]
     * @Type("ArrayCollection<App\Response\Partials\Media>")
     */
    protected $data;

}