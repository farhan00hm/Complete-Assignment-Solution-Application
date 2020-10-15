<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Services\SocialGoogleAccountService;

class GoogleSocialiteController extends Controller {
    /**
   * Create a redirect method to google api.
   *
   * @return void
   */
    public function redirect() {
        return Socialite::driver('google')->redirect();
    }

	/**
     * Return a callback method from google api.
     *
     * @return callback URL from google
     */
    public function callback(SocialGoogleAccountService $service) {
        $user = $service->createOrGetUser(Socialite::driver('google')->user());
        auth()->login($user);
        
        if (empty(auth()->user()->username) && auth()->user()->onboarded == 0) {
            return redirect()->to('/socialite/complete');
        } else {
            return redirect()->to('/dashboard');
        }
    }
}
