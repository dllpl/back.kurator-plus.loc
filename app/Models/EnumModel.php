<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 03.09.2019
 * Time: 14:03
 */

namespace App\Models;

class EnumModel extends Model
{
    protected $keyType = 'int';

    protected $fillable = [
        'slug', 'name',
    ];

    public $incrementing = false;
}
