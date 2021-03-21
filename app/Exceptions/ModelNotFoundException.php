<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 04.09.2019
 * Time: 02:33
 */

namespace App\Exceptions;

class ModelNotFoundException extends GraphqlException
{
    public function __construct(string $message = 'Model not found', string $reason = 'Invalid arguments')
    {
        parent::__construct($message, $reason);
    }
}
