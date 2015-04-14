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

namespace App\Components\Storage;


use Illuminate\Contracts\Auth\Authenticatable;
use Predis\ClientInterface;

class UserStorage
{
    /**
     * @var ClientInterface
     */
    protected $redis;

    public function __construct(ClientInterface $redis)
    {
        $this->redis = $redis;
    }

    public function update(Authenticatable $user)
    {
        $this->redis->set($this->getKey($user->getAuthIdentifier()), serialize($user));
    }

    public function getByPk($id)
    {
        return @unserialize($this->redis->get($this->getKey($id))) ?: null;
    }

    public function getKey($id)
    {
        return sprintf("%s_%s", "user", $id);
    }

}