<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 09.09.2019
 * Time: 2:32
 */

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('searchByName', function(string $field, string $operator, string $value) {
            /** @var Builder $this */
            return $this->whereRaw("to_tsvector(concat(name, ' ', short_name)) @@ websearch_to_tsquery(?)", [$value]);
        });

        Builder::macro('searchByAddress', function(string $field, string $operator, string $value) {
            /** @var Builder $this */
            return $this->whereRaw('to_tsvector(address) @@ websearch_to_tsquery(?)', [$value]);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
