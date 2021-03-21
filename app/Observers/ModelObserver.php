<?php

namespace App\Observers;

use App\Models\Model;
use App\Contracts\Scope;

class ModelObserver
{
    /**
     * Handle the model "creating" event.
     *
     * @param Model $model
     * @return void
     */
    public function creating(Model $model): void
    {
        foreach ($model->getGlobalScopes() as $globalScope) {
            if ($globalScope instanceof Scope) {
                $globalScope::creating($model);
            }
        }
    }
}
