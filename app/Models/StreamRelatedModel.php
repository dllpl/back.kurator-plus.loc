<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 27.10.2019
 * Time: 13:03
 */

namespace App\Models;

use App\Models\Core\LearningStream;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StreamRelatedModel extends Model
{
    public function learningStream(): BelongsTo
    {
        return $this->belongsTo(LearningStream::class);
    }
}
