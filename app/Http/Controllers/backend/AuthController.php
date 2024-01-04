<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MongoDB\Driver\Session;

class AuthController extends Controller
{
    public function index(Request $request)
    {

        $data = [];
        if (Auth::user() && Auth::user()->user_group == 'üye') {
            $this->logout();
        }


        if ($request->method() == 'POST') {

             /*$user = new User();
             $user->firstname = 'Damla';
             $user->lastname = 'İnce';
             $user->username = 'damla';
             $user->email = 'damlaince@gmail.com';
             $user->telephone = '05538119019';
             $user->password = Hash::make('900990');
             $user->user_group = 'admin';
             $user->save();*/

            $validate = \Illuminate\Support\Facades\Validator::make($request->all(),
                [
                    'email' => 'required|min:3',
                    'password' => 'required|min:6'
                ],
                [
                    'email.required' => 'Email veya Kullanıcı adı girmek zorunludur.',
                    'password.required' => 'Şifrenizi girmeniz zorunludur.',
                    'password.min' => 'Şifreniz en az 6 karakter içermelidir.'
                ]
            );

            $email = $request->post('email');

            $isHave = User::where(function ($query) use ($email) {
                $query->orWhere('email', '=', $email);
                $query->orWhere('username', '=', $email);
                $query->where('user_group','=','admin');
            })->count();
            if ($isHave == 0) {
                $data['error'] = 'Kullanıcı bulunamadı!';
            } else {
                $fieldType = filter_var($request->post('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

                if ($validate->errors()->count()) {
                    $data['error'] = $validate->errors()->messages();
                } else {
                    $loginCheck = Auth::attempt([$fieldType => $request->post('email'), 'password' => $request->post('password'), 'user_group' => 'admin']);

                    if ($loginCheck) {
                        if (Auth::user()->user_group == 'admin') {
                            return redirect()->route('panel.dash');
                        }
                    } else {
                        $data['error'] = 'Kullanıcı bilgileri yanlış.';
                    }
                }
            }

        }


        return view('backend.auth.login', ['data' => $data]);
    }

    public function logout() {
        Auth::logout();
        return redirect()->back();
    }

}
