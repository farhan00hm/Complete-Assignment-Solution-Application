<?php
    namespace App\Services;

    use Illuminate\Support\Str;
    use Carbon\Carbon;
    use App\Models\SocialiteAccount;
    use App\User;
    use Laravel\Socialite\Contracts\User as ProviderUser;

    class SocialGoogleAccountService {
        public function createOrGetUser(ProviderUser $providerUser) {
            $account = SocialiteAccount::whereProvider('google')
                ->whereProviderUserId($providerUser->getId())
                ->first();

            if ($account) {
                return $account->user;
            } else {
                $account = new SocialiteAccount([
                    'provider_user_id' => $providerUser->getId(),
                    'provider' => 'google'
                ]);

                $user = User::whereEmail($providerUser->getEmail())->first();
                if (!$user) {
                    $full = $providerUser->getName();
                    $first = trim($full);
                    $last = trim($full);
                    if ($full == trim($full) && strpos($full, ' ') !== false) {
                        $pieces = explode(" ", trim($full));
                        $first = $pieces[0];
                        $last = $pieces[1];
                    }

                    $user = User::create([
                        'email' => $providerUser->getEmail(),
                        'first_name' => $first,
                        'last_name' => $last,
                        'user_type' => 'Student',
                        'email_verified_at' => Carbon::now()->toDateString(),
                        'password' => bcrypt((string) Str::uuid()),
                    ]);
                }

                $account->user()->associate($user);
                $account->save();
                return $user;
            }
        }
    }