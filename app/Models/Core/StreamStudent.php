<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 25.10.2019
 * Time: 22:03
 */

namespace App\Models\Core;

class StreamStudent extends StreamRelatedUser
{
    protected const RELATIONSHIP = Relationship::STUDENT;
}
