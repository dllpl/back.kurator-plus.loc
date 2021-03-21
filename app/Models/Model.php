<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 23.08.2019
 * Time: 18:50
 */

namespace App\Models;

use App\Observers\ModelObserver;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class Model extends EloquentModel
{
    use SoftDeletes;

    protected $keyType = 'uuid';

    protected $dateFormat = 'Y-m-d H:i:sO';

    protected $attributeSignificances = [];

    protected static function boot()
    {
        parent::boot();

        static::observe(ModelObserver::class);
    }

    public function getTable()
    {
        $result = parent::getTable();

        if (!Str::contains($result, '.') && !$this->table) {
            $schema = Str::snake(basename(dirname(str_replace('\\', '/', get_class($this)))));
            $result = $schema . '.' . $result;
        }

        return $result;
    }

    public function getFillFactorAttribute() {
        $base = 10 ** (1 / 5);
        $used = 0;
        $filled = 0;

        foreach ($this->attributeSignificances as $attribute => $significance) {
            $weight = 10 * $base ** $significance;
            $used += $weight;
            if ($this->$attribute) {
                $filled += $weight;
            }
        }

        return $used ? round($filled / $used * 100) : 0;
    }
}
