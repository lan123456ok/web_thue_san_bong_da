<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Http\Requests\Auth\ResgisteringRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        $user = User::query()
            ->where('email', $data->getEmail())
            ->first();
        $checkExist = true;

        if (is_null($user)) {
            $user = new User();
            $user->email = $data->getEmail();
            $checkExist = false;
        }

        $user->name = $data->getName();
        $user->avatar = $data->getAvatar();
        $user->save();

        $role = strtolower(UserRoleEnum::getKeys($user->role)[0]);
        // Auth::guard($role)->attempt($user);
        Auth::login($user);

        if ($checkExist) {
            // dd($role);
            return redirect()->route("$role.welcome");
        }
        return redirect()->route('register');
    }

    public function registering(ResgisteringRequest $request)
    {
        $password = Hash::make($request->password);

        if (auth()->check()) {
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

    public function logout(Request $request) : RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect()->route('login');
    }
}
