<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 04.09.2019
 * Time: 02:33
 */

namespace App\GraphQL\Mutations;

use App\Models\Core\User;

class UpdateUserMutation extends UpdateMutation
{
    protected $modelClass = User::class;

    /**
     * @return User
     */
    public function getModel()
    {
        return auth()->user();
    }
}
