<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 30.08.2019
 * Time: 16:52
 */

namespace App\Http\Controllers\Auth;

trait RedirectToClient
{
    protected function redirectTo(): string {
        return route('passport.authorizations.authorize', [
            'client_id' => config('auth.client_id'),
            'response_type' => 'token'
        ]);
    }
}
