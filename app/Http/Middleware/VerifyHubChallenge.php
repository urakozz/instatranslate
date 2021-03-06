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

namespace App\Http\Middleware;


use Closure;
use Illuminate\Contracts\Routing\Middleware;

class VerifyHubChallenge implements Middleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(in_array(env("I_CALLBACK_USERS"), [$request->get("hub_challenge"), $request->header("X-Hub-Challenge")])){
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}