<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 02.09.2019
 * Time: 15:57
 */

namespace App\Services;

use App\Contracts\SocialAccount as SocialAccountInterface;
use App\Models\Core\SocialAccount;
use App\Scopes\UserScope;
use App\Models\Core\SocialProvider;
use App\Models\Core\User;
use DB;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Socialite\Contracts\User as SocialUser;
use Str;

class SocialAccountService implements SocialAccountInterface
{
    /**
     * Find or create user instance by provider name and social user contract.
     *
     * @param string $driver
     * @param SocialUser $socialUser
     *
     * @return Authenticatable
     * @throws AuthorizationException
     * @throws ModelNotFoundException
     */
    public function findOrCreate(string $driver, SocialUser $socialUser): Authenticatable
    {
        $socialProvider = SocialProvider::where('driver', $driver)->first('id');
        if (!$socialProvider) {
            throw new ModelNotFoundException(
                __(':driver authentication is not supported', ['driver' => Str::ucfirst($driver)])
            );
        }

        $socialAccount = SocialAccount::withoutGlobalScope(UserScope::class)
            ->where('provider_id', $socialProvider->id)
            ->where('provider_user', $socialUser->getId())
            ->first();
        if ($socialAccount) {
            if (!auth()->user() or auth()->user()->id === $socialAccount->user_id) {
                return $socialAccount->user;
            }

            throw new AuthorizationException(
                'This account is already linked to another user'
            );
        }

        // hack for VK
        $email = $socialUser->getEmail() ?: $socialUser->accessTokenResponseBody['email'] ?? null;
        $user = auth()->user() ?: User::where('email', $email)->first();

        DB::beginTransaction();
        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $email,
                'email_verified_at' => now(),
                'avatar' => $socialUser->getAvatar(),
            ]);
        }
        else {
            if ($email and !$user->email) {
                $user->email = $email;
            }
            if ($socialUser->getAvatar() and !$user->avatar) {
                $user->avatar = $socialUser->getAvatar();
            }
            $user->save();
        }
        $user->socialAccounts()->create([
            'provider_id' => $socialProvider->id,
            'provider_user' => $socialUser->getId(),
            'name' => $socialUser->getName(),
            'email' => $email,
            'avatar' => $socialUser->getAvatar(),
        ]);
        DB::commit();

        return $user;
    }
}
