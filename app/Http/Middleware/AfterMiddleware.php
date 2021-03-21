<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 28.08.2019
 * Time: 18:55
 */

namespace App\Http\Middleware;

use Closure;
use DateTime;
use DB;
use Exception;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class AfterMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (config('app.debug', false)) {
            $handler = new StreamHandler(storage_path().'/logs/sql-' . date('Y-m-d') . '.log', Logger::DEBUG);
            $handler->setFormatter(new LineFormatter(null, 'Y-m-d H:i:sO'));
            $logger = new Logger('sql');
            $logger->pushHandler($handler);

            foreach (DB::getQueryLog() as $line) {
                $bindings = [];
                foreach($line['bindings'] as $binding) {
                    $bindings[] = ($binding instanceof DateTime) ? $binding->format('Y-m-d H:i:sO') : $binding;
                }
                $logger->debug(vsprintf(str_replace('?', "'%s'", $line['query']), $bindings));
            }
            $logger->debug( 'Total queries: ' . count(DB::getQueryLog()));
        }

        return $response;
    }
}
