<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 02.09.2019
 * Time: 15:57
 */

namespace App\Models\Core;

use App\Models\UserRelatedModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialAccount extends UserRelatedModel
{
    protected $fillable = [
        'provider_id',
        'provider_user',
        'name',
        'email',
        'avatar',
    ];

    /*
    // moved to socialAccounts relation
    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(function (Builder $builder) {
            $builder->joinBelongsTo('provider')->orderBy('position');
        });
    }
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(SocialProvider::class);
    }
}
