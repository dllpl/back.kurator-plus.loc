<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 25.10.2019
 * Time: 19:18
 */

namespace App\Models\Core;

use App\Models\OrganizationRelatedModel;
use DB;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LearningStream extends OrganizationRelatedModel
{
    public function streamLeaders(): HasMany
    {
        return $this->hasMany(StreamLeader::class);
    }

    public function streamStudents(): HasMany
    {
        return $this->hasMany(StreamStudent::class);
    }

    public function leaders(): BelongsToMany
    {
        return $this->belongsToMany(User::class, StreamLeader::class)
            ->wherePivot('relationship_id', Relationship::STREAM_LEADER)
            ->wherePivot('deleted_at', 'is not distinct from', DB::raw('null'));
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, StreamStudent::class)
            ->wherePivot('relationship_id', Relationship::STUDENT)
            ->wherePivot('deleted_at', 'is not distinct from', DB::raw('null'));
    }
}
