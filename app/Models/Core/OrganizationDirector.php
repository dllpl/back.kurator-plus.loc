<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 25.10.2019
 * Time: 21:19
 */

namespace App\Models\Core;

class OrganizationDirector extends RelatedUser
{
    protected const RELATIONSHIP = Relationship::DIRECTOR;
}
