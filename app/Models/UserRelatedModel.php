<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 28.08.2019
 * Time: 15:50
 */

namespace App\Models;

use App\Scopes\UserScope;
use App\Models\Core\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRelatedModel extends Model implements UserRelated
{
    public const USER_COLUMN = 'user_id';

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(new UserScope());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, $this->getUserColumn());
    }

    /**
     * @return string
     */
    public function getUserColumn(): string
    {
        return static::USER_COLUMN;
    }
}
