<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 28.08.2019
 * Time: 15:50
 */

namespace App\Models\Core;

use App\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Organization extends Model
{
    protected const ORGANIZATION_TYPE = null;

    protected static function boot()
    {
        parent::boot();

        if (static::ORGANIZATION_TYPE) {
            static::addGlobalScope('organization_type', function (Builder $builder) {
                $builder->where('organization_type_id', static::ORGANIZATION_TYPE);
            });
        }
    }

    public function changes(): hasMany
    {
        return $this->hasMany(OrganizationChange::class)->orderBy('version', 'desc');
    }

    public function parent(): belongsTo
    {
        return $this->belongsTo(__CLASS__);
    }

    public function children(): hasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function relatedUsers(): hasMany
    {
        return $this->hasMany(RelatedUser::class);
    }

    public function director(): HasOneThrough
    {
        return $this->hasOneThrough(PublicUser::class, OrganizationDirector::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(OrganizationType::class);
    }

    public function learningStreams(): HasMany
    {
        return $this->hasMany(LearningStream::class)->orderBy('created_at', 'desc');
    }
}
