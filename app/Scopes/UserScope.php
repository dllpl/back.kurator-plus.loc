<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 28.08.2019
 * Time: 15:50
 */

namespace App\Scopes;

use App\Contracts\Scope;
use App\Models\UserRelated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class UserScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (!$model instanceof UserRelated) {
            throw new RuntimeException(sprintf(
                '%s must implement %s interface',
                class_basename($model),
                UserRelated::class
            ));
        }

        $builder->where(sprintf('%s.%s', $model->getTable(), $model->getUserColumn()), auth()->user()->id);
    }

    public static function creating(Model $model)
    {
        $userColumn = $model->getUserColumn();

        if (!$model->$userColumn) {
            $model->$userColumn = auth()->user()->id ?? null;
        }

        return $model;
    }
}
