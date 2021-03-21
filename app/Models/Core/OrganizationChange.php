<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 07.09.2019
 * Time: 20:23
 */

namespace App\Models\Core;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationChange extends Model
{
    public static function bootSoftDeletes()
    {
        // exclude SoftDeletingScope
    }

    public function organization(): BelongsTo {
        return $this->belongsTo(Organization::class);
    }

    public function parent(): belongsTo
    {
        return $this->belongsTo(__CLASS__);
    }

    public function children(): hasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }
}
