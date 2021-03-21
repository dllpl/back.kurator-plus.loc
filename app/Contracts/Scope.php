<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 05.09.2019
 * Time: 11:05
 */

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope as EloquentScope;

interface Scope extends EloquentScope
{
    public static function creating(Model $model);
}
