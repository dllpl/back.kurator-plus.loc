<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 02.09.2019
 * Time: 15:57
 */

namespace App\Models\Core;

use App\Models\EnumModel;

class SocialProvider extends EnumModel
{
    public const GOOGLE = 1;
    public const FACEBOOK = 2;
    public const VKONTAKTE = 3;
}
