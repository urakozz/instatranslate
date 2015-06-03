<?php
/**
 * PHP Version 5
 *
 * @package
 * @author    "Yury Kozyrev" <urakozz@gmail.com>
 * @copyright 2015 "Yury Kozyrev"
 * @license   MIT
 * @link      https://github.com/urakozz/php-instagram-client
 */

namespace App\Components\Translator\TranslatorAdapter;


use App\Components\Translator\ITranslatable;
use Doctrine\Common\Collections\ArrayCollection;
use Psr\Http\Message\ResponseInterface;
use Kozz\Components\Emoji\EmojiParser;

abstract class AbstractTranslatorAdapter implements ITranslatorAdapter, ITranslatorTextCleaner
{
    /**
     * @var \SplObjectStorage|ArrayCollection[]
     */
    protected $hashTagStorage;

    /**
     * @var \SplObjectStorage|ArrayCollection[]
     */
    protected $emojiStorage;

    /**
     * @var \SplObjectStorage|string[]
     */
    protected $textStorage;

    public function __construct()
    {
        $this->hashTagStorage = new \SplObjectStorage();
        $this->emojiStorage   = new \SplObjectStorage();
        $this->textStorage    = new \SplObjectStorage();
    }

    public function getCleanedText(ITranslatable $item)
    {
        $text = $item->getText();

        $i       = 0;
        $matches = new ArrayCollection();
        $parser  = new EmojiParser();
        $parser->setPrepend("#(?:[\\w]|");
        $text = $parser->replaceCallback($text, function ($match) use (&$i, $matches) {
            $key = '{' . $i++ . '}';
            $matches->set($key, $match[0]);
            return $key;
        });

        unset($i);
        $this->hashTagStorage->attach($item, $matches);

        $i       = 0;
        $matches = new ArrayCollection();
        $parser  = new EmojiParser();
        $text    = $parser->replaceCallback($text, function ($match) use (&$i, $matches) {
            $key = '{{' . $i++ . '}}';
            $matches->set($key, $match[0]);
            return $key;
        });
        unset($i);
        $this->emojiStorage->attach($item, $matches);

        $this->textStorage->attach($item, $text);
        return $text;
    }

    public function applyTranslation(ResponseInterface $response, ITranslatable $item)
    {
        $translation = $this->getTranslation($response);

        if ($translation === $this->textStorage[$item]) {
            return;
        }

        $emoji = $this->emojiStorage[$item];
//        var_dump($emoji);
        $translation = str_replace($emoji->getKeys(), $emoji->getValues(), $translation);
        $hashTags    = $this->hashTagStorage[$item];
//        var_dump($hashTags);
        $translation = str_replace($hashTags->getKeys(), $hashTags->getValues(), $translation);
        $item->setTranslation($translation);
    }

    abstract protected function getTranslation(ResponseInterface $response);


}