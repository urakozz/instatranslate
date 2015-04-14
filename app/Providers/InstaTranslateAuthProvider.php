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

namespace App\Providers;


use App\Auth\SessionBasedAuthGuard;
use App\Auth\SessionBasedUserProvider;
use Illuminate\Support\ServiceProvider;

class InstaTranslateAuthProvider extends ServiceProvider
{

    public function boot()
    {
        $this->app['auth']->extend('instagram', function ($app) {
            $userProvider = new SessionBasedUserProvider($app['hash']);
            return new SessionBasedAuthGuard($userProvider, $app['session.store']);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}