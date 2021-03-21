<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 10.09.2019
 * Time: 12:48
 */

if (!function_exists('whoami')) {
    /**
     * Returns a current user
     * @return string
     */
    function whoami(): string
    {
        static $whoami;

        if (!$whoami) {
            // shell_exec MUST NOT be used since it has a bug (returns \n at the end of its result)
            $whoami = exec('whoami');
        }

        return $whoami;
    }
}
