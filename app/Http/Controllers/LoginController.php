<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     * @param Request $request
     * @return RedirectResponse
     */
    public function redirectToProvider(Request $request): RedirectResponse
    {
        return Socialite::driver($request->route('driver'))->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     * @param Request $request
     * @return RedirectResponse
     */
    public function handleProviderCallback(Request $request): RedirectResponse
    {
        $socialite = Socialite::driver($request->route('driver'))->user();

        $user = User::query()->where('email', $socialite->email)->firstOrCreate([
            'email' => $socialite->email,
            'name' => $socialite->name,
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/');
    }
}
