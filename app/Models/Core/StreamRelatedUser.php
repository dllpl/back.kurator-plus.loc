<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 12.11.2019
 * Time: 19:03
 */

namespace App\Models\Core;

use App\Models\StreamRelatedModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StreamRelatedUser extends StreamRelatedModel
{
    protected const RELATIONSHIP = null;

    protected $table = 'core.stream_relations';

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
