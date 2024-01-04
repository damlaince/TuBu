<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index() {

        if (Auth::user()->user_group != 'admin') {
            Auth::logout();
            return redirect()->route('panel.login');
        }

       // User::where('username','damla')->update(['password' => Hash::make('900990')]);
        return view('backend.dashboard');
    }
}
