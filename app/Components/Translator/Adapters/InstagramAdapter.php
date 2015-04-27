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

namespace App\Components\Translator\Adapters;


use App\Components\Translator\ITranslatable;
use App\Components\Translator\Proxy\InstagramTranslatableProxy;
use App\Response\InstagramResponse;

class InstagramAdapter extends AbstractTranslatableAdapter
{

    /**
     * @var InstagramResponse
     */
    protected $source;

    public function __construct(InstagramResponse $source)
    {
        $this->source = $source;
    }

    /**
     * Desc
     *
     * @return ITranslatable[]
     */
    public function getTranslatable()
    {
        foreach ($this->getCaptions() as $caption) {
            if ($caption) {
                yield new InstagramTranslatableProxy($caption);
            }
        }
    }

    protected function getCaptions()
    {
        foreach ($this->source->getData() as $media) {
            yield $media->getCaption();
            foreach ($media->getComments()->getData() as $comment) {
                yield $comment;
            }
        }
    }

}