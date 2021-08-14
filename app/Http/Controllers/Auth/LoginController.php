<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param mixed $user
     * @return RedirectResponse
     */
    protected function authenticated(Request $request, mixed $user): RedirectResponse
    {
        Cart::instance('savedforlater')->restore($user->id);
        Cart::instance('default')->restore($user->id);

        return  redirect()->intended($this->redirectPath());
    }

    /**
     * Redirect the user to the Social sites authentication page.
     *
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Social Sites.
     *
     * @param $provider
     * @return Redirector|Application|RedirectResponse
     */
    public function handleProviderCallback($provider): Redirector|Application|RedirectResponse
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::where('provider_id', $socialUser->getId())->where('provider', $provider)->first();
        if (!$user) {
            $user = $this->createUser($socialUser, $provider);
        }

        Auth::login($user, true);

        return redirect($this->redirectTo);
    }

    /**
     * @param \Laravel\Socialite\Contracts\User $socialUser
     * @param $provider
     * @return User
     */
    protected function createUser(\Laravel\Socialite\Contracts\User $socialUser, $provider): User
    {
        return User::create([
            'email' => $socialUser->getEmail(),
            'name' => $socialUser->getName(),
            'provider_id' => $socialUser->getId(),
            'provider' => $provider,
        ]);
    }
}
