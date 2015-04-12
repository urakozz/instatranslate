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


use App\Auth\CustomAuthGuard;
use App\Auth\CustomUserProvider;
use Illuminate\Support\ServiceProvider;

class CustomAuthProvider extends ServiceProvider {

    public function boot()
    {
        $this->app['auth']->extend('instagram', function($app)
        {
            $model = $app['config']['auth.model'];
            $userProvider = new CustomUserProvider($app['hash'], new $model);
            return new CustomAuthGuard($userProvider, $app['session.store']);
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