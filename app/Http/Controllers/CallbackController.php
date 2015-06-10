<?php
namespace App\Http\Controllers;

use App\Jobs\GetTranslations;
use App\Components\Storage\UserStorage;

class CallbackController extends Controller
{
    public function __construct()
    {
        $this->middleware("callback_users", ['only'=>['users', 'usersPost']]);
    }

    public function users()
    {
        \Log::info(json_encode($_GET));
        return \Input::get('hub_challenge');
    }

    public function usersPost()
    {
        $json = \Request::instance()->getContent();
        $response = json_decode($json);
        $first = reset($response);
        $userId = $first->object_id;
        $mediaId = $first->data->media_id;
        \Log::info($userId);
        \Log::info($mediaId);
        $storage = new UserStorage(\Redis::connection());
        $user = $storage->getByPk($userId);
        if(!$user){
            return;
        }
        \Log::info(json_encode($user));

        \Queue::push(new GetTranslations($user->getToken()));
        return \Input::get('hub_challenge');
    }

}
