<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 25.10.2019
 * Time: 20:30
 */

namespace App\Models\Core;

class OrganizationStudent extends RelatedUser
{
    protected const RELATIONSHIP = Relationship::STUDENT;
}
