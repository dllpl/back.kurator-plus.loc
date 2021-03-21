<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 04.09.2019
 * Time: 13:43
 */

namespace App\Models\Core;

class PublicUser extends User
{
    protected $table = 'core.users';

    // todo: check logic that ONLY these attributes are visible from this model
    protected $visible = [
        'name',
        'email',
        'avatar',
    ];
}
