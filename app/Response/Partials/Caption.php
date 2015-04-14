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


use App\Components\Translator\ITranslatable;

class Caption implements ITranslatable
{

    public $id;
    public $text;
    public $created_time;
    public $from;


    public function __construct(array $data = null)
    {
        foreach ($data as $key => $item) {
            $this->$key = $item;
        }

    }

    public function getId()
    {
        return $this->id;
    }

    public function getText()
    {
        return $this->text;
    }
}