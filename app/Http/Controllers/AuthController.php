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

namespace App\Http\Controllers;


use GuzzleHttp\Exception\RequestException;
use Instagram\Client\Config\AuthConfig;
use Instagram\Client\InstagramAuth;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout']]);
    }

    /**
     * Resolve Instagram Auth response
     *
     * @return \Response
     */
    public function resolve()
    {
        try {
            if ($desc = \Input::get('error_description')) {
                throw new \DomainException($desc);
            }
            $code = \Input::get('code');
            if (!$code || !preg_match('/^[0-9a-f]{32}$/iu', $code)) {
                throw new \DomainException("Incorrect response code");
            }

            $client = new InstagramAuth(new AuthConfig(env("I_CLIENT_ID"), env("I_CLIENT_SECRET"), \URL::to('/auth')));
            $response = $client->retrieveOAuthToken($code);
            if(!$response->isOk()){
                throw new \DomainException("Incorrect response code");
            }

        } catch (\Exception $e) {
            return view('auth_reject', ['desc' => $e->getMessage()]);
        }

        $user = new \App\User();
        $user->setToken($response->getAccessToken());
        $user->setBio("");
        $user->setWebsite("");
        $user->setFullName($response->getUser()->getFullName());
        $user->setUserName($response->getUser()->getUsername());
        $user->setProfilePicture($response->getUser()->getProfilePicture());
        $user->setId($response->getUser()->getId());

        \Auth::login($user, true);
        return redirect(\URL::to('/'));
    }

    public function logout()
    {
        \Auth::logout();
        \Session::clear();
        return redirect("/");
    }
}