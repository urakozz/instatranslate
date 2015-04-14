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

namespace App\Auth;


use App\Components\Storage\UserStorage;
use Illuminate\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Illuminate\Session\SessionInterface;

class SessionBasedAuthGuard extends Guard
{
    protected $userStorage;

    public function __construct(UserProvider $provider,
                                SessionInterface $session,
                                Request $request = null)
    {
        $this->userStorage = new UserStorage(\Redis::connection());
        parent::__construct($provider, $session, $request);
    }

    /**
     * Log a user into the application.
     *
     * @param  Authenticatable $user
     * @param  bool $remember
     * @return void
     */
    public function login(Authenticatable $user, $remember = false)
    {
        $this->userStorage->update($user);
        parent::login($user, $remember);
    }
}