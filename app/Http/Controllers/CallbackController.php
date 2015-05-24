<?php
namespace App\Http\Controllers;

class CallbackController extends Controller
{
    public function users()
    {
        \Log::info(json_encode($_GET));
        return \Input::get('hub_challenge');
    }

}
