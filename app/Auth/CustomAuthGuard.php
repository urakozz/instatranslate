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


use Illuminate\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;

class CustomAuthGuard extends Guard
{

    /**
     * Log a user into the application.
     *
     * @param  Authenticatable  $user
     * @param  bool  $remember
     * @return void
     */
    public function login(Authenticatable $user, $remember = false)
    {
        $this->session->set('user', serialize($user));
        parent::login($user, $remember);
    }
}