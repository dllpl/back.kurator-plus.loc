<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 12.11.2019
 * Time: 19:39
 */

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelatedStream extends RelatedOrganization
{
    protected $table = 'core.stream_relations';

    public function learningStream(): BelongsTo
    {
        return $this->belongsTo(LearningStream::class);
    }
}
