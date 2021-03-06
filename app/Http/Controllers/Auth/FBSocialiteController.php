<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Services\SocialFacebookAccountService;

class FBSocialiteController extends Controller {
    /**
   * Create a redirect method to facebook api.
   *
   * @return void
   */
    public function redirect() {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback(SocialFacebookAccountService $service) {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        auth()->login($user);

        if (empty(auth()->user()->username) && auth()->user()->onboarded == 0) {
            return redirect()->to('/socialite/complete');
        } else {
            return redirect()->to('/dashboard');
        }
        
    }
}
