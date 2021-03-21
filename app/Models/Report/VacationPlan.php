<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 01.02.2020
 * Time: 19:14
 */

namespace App\Models\Report;

use App\Models\Core\PublicUser;
use App\Models\StreamRelatedModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VacationPlan extends StreamRelatedModel
{
    public const SAVED = 'saved';
    public const SENT = 'sent';
    public const APPROVED = 'approved';
    public const REJECTED = 'rejected';

    public function user(): BelongsTo
    {
        return $this->belongsTo(PublicUser::class);
    }

    public function moderatedBy(): BelongsTo
    {
        return $this->belongsTo(PublicUser::class);
    }
}
