<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 04.10.2019
 * Time: 17:06
 */

namespace App\Models;

interface UserRelated
{
    /**
     * @return string
     */
    public function getUserColumn(): string;
}
