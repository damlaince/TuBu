<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class AuthController extends Controller
{
    public function index(Request $request)
    {

        $data = [];

        if (Auth::user() && Auth::user()->user_group == 'admin') {
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
            })->count();
            if ($isHave == 0) {
                $data['error'] = 'Kullanıcı bulunamadı!';
            } else {
                $fieldType = filter_var($request->post('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

                if ($validate->errors()->count()) {
                    $data['error'] = $validate->errors()->messages();
                } else {
                    $loginCheck = Auth::attempt([$fieldType => $request->post('email'), 'password' => $request->post('password'), 'user_group' => 'user']);

                    if ($loginCheck) {
                        if (Auth::user()->user_group == 'user') {
                            return redirect()->route('front.home');
                        }
                    } else {
                        $data['error'] = 'Kullanıcı bilgileri yanlış.';
                    }
                }
            }

        }


        return view('frontend.auth.login', ['data' => $data]);
    }

    public function register(Request $request)
    {

        $data = [];

        if ($request->method() == 'POST') {
            $validate = \Illuminate\Support\Facades\Validator::make($request->all(),
                [
                    'firstname' => 'required|min:2|max:250',
                    'lastname' => 'required|min:2|max:250',
                    'username' => 'required|min:2|max:250',
                    'email' => 'required|email|min:3',
                    'telephone' => 'required|numeric',
                    'password' => 'required|min:6'
                ],
                [
                    'firstname.required' => 'Adınızı girmeniz zorunludur.',
                    'firstname.min' => 'Adınız en az 2 karakter içermelidir.',
                    'firstname.max' => 'Adınız en fazla 250 karakter içerebilir.',
                    'lastname.required' => 'Soyadınızı girmeniz zorunludur.',
                    'lastname.min' => 'Soyadınız en az 2 karakter içermelidir.',
                    'lastname.max' => 'Soyadınız en fazla 250 karakter içerebilir.',
                    'username.required' => 'Kullanıcı adınızı girmeniz zorunludur.',
                    'username.min' => 'Kullanıcı adınız en az 2 karakter içermelidir.',
                    'username.max' => 'Kullanıcı adınız en fazla 250 karakter içerebilir.',
                    'email.required' => 'Email girmek zorunludur.',
                    'email.min' => 'Email minimum 3 karakter içermelidir.',
                    'email.email' => 'Email formatında giriniz.',
                    'telephone.required' => 'Telefonunuzu girmeniz zorunludur.',
                    'telephone.numeric' => 'Telefonunuzu sayı formatında belirtiniz.',
                    /* 'telephone.min' => 'Telefon 10 karakter içermelidir.',
                     'telephone.max' => 'Telefon 11 karakter içermelidir.',*/
                    'password.required' => 'Şifrenizi girmeniz zorunludur.',
                    'password.min' => 'Şifreniz en az 6 karakter içermelidir.'
                ]
            );

            $isHave = User::where(function ($query) use ($request) {
                $query->orWhere('email', '=', $request->post('email'));
                $query->orWhere('username', '=', $request->post('username'));
                $query->orWhere('telephone', '=', $request->post('telephone'));
            })->count();

            if ($isHave > 0) {
                $data['error'] = 'Bu kullanıcı sistemimizde kayıtlı!';
            } else {


                if ($validate->errors()->count()) {
                    $data['error'] = $validate->errors()->messages();
                } else if (strlen($request->post('telephone')) != 10) {

                    $data['error']['telephone'][0] = 'Telefon 10 karakter içermelidir.';
                } else {
                    $user = new User();
                    $user->firstname = $request->post('firstname');
                    $user->lastname = $request->post('lastname');
                    $user->username = $request->post('username');
                    $user->email = $request->post('email');
                    $user->telephone = $request->post('telephone');
                    $user->password = Hash::make($request->post('password'));
                    $user->user_group = 'user';
                    $user->save();
                    Auth::login($user);
                    return redirect()->route('front.home');
                }


            }
        }


        return view('frontend.auth.register', ['data' => $data]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('front.home');
    }


}
