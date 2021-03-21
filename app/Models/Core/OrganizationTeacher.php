<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 25.10.2019
 * Time: 20:59
 */

namespace App\Models\Core;

class OrganizationTeacher extends RelatedUser
{
    protected const RELATIONSHIP = Relationship::TEACHER;
}
