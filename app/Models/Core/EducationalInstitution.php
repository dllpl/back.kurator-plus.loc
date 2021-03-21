<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 25.10.2019
 * Time: 21:02
 */

namespace App\Models\Core;

use App\Models\OrganizationRelatedModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class EducationalInstitution extends Organization
{
    protected const ORGANIZATION_TYPE = OrganizationType::EDUCATIONAL;

    public function students(): hasManyThrough
    {
        return $this->hasManyThrough(User::class, OrganizationStudent::class);
    }

    public function teachers(): hasManyThrough
    {
        return $this->hasManyThrough(User::class, OrganizationTeacher::class);
    }
}
