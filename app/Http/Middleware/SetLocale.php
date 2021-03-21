<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 01.09.2019
 * Time: 15:33
 */

namespace App\Http\Middleware;

use App;
use Closure;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Log;

class SetLocale
{
    private $ftsLocales = [
//        'en' => 'english',
        'ru' => 'russian',
    ];

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        app()->setLocale($locale);

        try {
            // set setting_parameter = ? can't be prepared. a PDO bug?
            DB::statement('select set_config(?, ?, false)', [
                'default_text_search_config',
                'public.' . ($this->ftsLocales[$locale] ?? 'russian')
            ]);
        }
        catch (QueryException $exception) {
            if (!App::isLocal()) {
                Log::warning('Full-text search not configured properly');
            }
            else {
                throw $exception;
            }
        }

        return $next($request);
    }
}
