<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function callback($provider)
    {
        $data = Socialite::driver($provider)->user();

        $user = User::updateOrCreate([
            'email' => $data->getEmail(),
        ], [
            'name' => $data->getName(),
            'avatar' => $data->getAvatar(),
        ]);

        Auth::login($user);

        return redirect()->route('register');
    }

    public function registering(Request $request) {
        $password = Hash::make($request->password);

        if(auth()->check()){
            User::where('id', auth()->user()->id)
                ->update([
                    'password' => $password
                ]);
        } else {
            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => $password,
            ]);
            Auth::login($user);
        }
        // return redirect()->route('/');
    }
}
