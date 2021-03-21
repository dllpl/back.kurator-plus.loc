<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 28.08.2019
 * Time: 15:50
 */

namespace App\Models\Core;

use App\Models\EnumModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Relationship extends EnumModel
{
    public const DIRECTOR = 1;
    public const SECRETARY = 2;
    public const HEAD_TEACHER = 3;
    public const STREAM_LEADER = 4;
    public const TEACHER = 5;
    public const PSYCHOLOGIST = 6;
    public const STUDENT = 7;
    public const PARENT = 8;
    public const DEPUTY_DIRECTOR_ACADEMY = 9;
    public const DEPUTY_DIRECTOR_EDUCATION = 10;
    public const DEPUTY_DIRECTOR_METHODOLOGY = 11;
    public const DEPUTY_DIRECTOR_SUPPLY = 12;

    public function relations(): HasMany
    {
        return $this->hasMany(RelatedOrganization::class);
    }
}
