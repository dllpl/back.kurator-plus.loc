<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 03.09.2019
 * Time: 13:33
 */

namespace App\Models;

use App\Models\Core\Organization;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationRelatedModel extends Model
{
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
