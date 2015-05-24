<?php
namespace App\Http\Controllers;

use App\Commands\GetTranslations;

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
//        \Queue::push(new GetTranslations(json_decode(file_get_contents('php://input'))));
        return \Input::get('hub_challenge');
    }

}
