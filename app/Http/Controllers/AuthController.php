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

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
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

            $request = [
                'client_id' => env('I_CLIENT_ID'),
                'client_secret' => env('I_CLIENT_SECRET'),
                'grant_type' => 'authorization_code',
                'redirect_uri' => \URL::to('/auth'),
                'code' => $code,
            ];
            $client  = new \GuzzleHttp\Client();
            try {
                $response = $client->post('https://api.instagram.com/oauth/access_token', ['body' => $request]);
            } catch (RequestException $e) {
                if ($e->getCode() === 400) {
                    throw new \DomainException("Incorrect response code");
                }
                throw $e;
            }
        }catch(\Exception $e){
            return view('auth_reject', ['desc' => $e->getMessage()]);
        }

        $json = $response->json();
        $user = new \App\User();
        $user->setToken($json['access_token']);
        $user->setBio($json['user']['bio']);
        $user->setWebsite($json['user']['website']);
        $user->setFullName($json['user']['full_name']);
        $user->setUserName($json['user']['username']);
        $user->setProfilePicture($json['user']["profile_picture"]);
        $user->setId($json['user']['id']);

        \Auth::login($user);
        return redirect(\URL::to('/'));
    }

    public function logout()
    {
        \Session::clear();
        return redirect("/");
    }
}