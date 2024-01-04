<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function test()
    {

        return false;
        // return phpinfo();
       //
        $user = new User();
        $user->name = 'damla';
        $user->save();
        return User::all();
        if ($user->name == 'damla') {
            return true;
        }
    }
}
