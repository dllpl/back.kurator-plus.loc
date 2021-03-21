<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 04.09.2019
 * Time: 13:43
 */

namespace App\Models\Core;

use App\Models\OrganizationRelatedModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelatedUser extends OrganizationRelatedModel
{
    protected const RELATIONSHIP = null;

    protected $table = 'core.relations';

//    protected $dates = [
//        'logged_at',
//    ];

    protected static function boot()
    {
        parent::boot();

        if (static::RELATIONSHIP) {
            static::addGlobalScope('relationship', function (Builder $builder) {
                $builder->where('relationship_id', static::RELATIONSHIP);
            });
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(PublicUser::class);
    }

    public function relationship(): BelongsTo
    {
        return $this->belongsTo(Relationship::class);
    }
}
