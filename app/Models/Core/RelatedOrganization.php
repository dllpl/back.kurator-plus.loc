<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 28.08.2019
 * Time: 15:15
 */

namespace App\Models\Core;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelatedOrganization extends Model
{
    protected $table = 'core.relations';

//    protected $dates = [
//        'logged_at',
//    ];

//    public function scopeRecent(Builder $query): Builder
//    {
//        return $query->orderBy('logged_at', 'desc')->limit($this->recentLimit);
//    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function relationship(): BelongsTo
    {
        return $this->belongsTo(Relationship::class);
    }
}
