<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 18.09.2019
 * Time: 2:40
 */

namespace App\Exceptions;

class ModelSaveException extends GraphqlException
{
    public function __construct(string $message = 'Integrity constraint violation', string $reason = 'Invalid inputs')
    {
        parent::__construct($message, $reason);
    }
}
