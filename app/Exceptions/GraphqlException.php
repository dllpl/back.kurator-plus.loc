<?php
/**
 * Created by PhpStorm.
 * User: V.A.I
 * Date: 03.09.2019
 * Time: 18:58
 */

namespace App\Exceptions;

use Exception;
use Nuwave\Lighthouse\Exceptions\RendersErrorsExtensions;
use Str;

class GraphqlException extends Exception implements RendersErrorsExtensions
{
    private $reason;

    protected $safe = true;

    /**
     * GraphqlException constructor.
     *
     * @param string $message
     * @param string $reason
     */
    public function __construct(string $message, string $reason = '')
    {
        parent::__construct($message);

        $this->reason = $reason;
    }

    protected function getReason(): string
    {
        return $this->reason;
    }

    /**
     * Returns true when exception message is safe to be displayed to a client.
     *
     * @return bool
     *
     * @api
     */
    public function isClientSafe(): bool
    {
        return $this->safe;
    }

    /**
     * Returns string describing a category of the error.
     *
     * Value "graphql" is reserved for errors produced by query parsing or validation, do not use it.
     *
     * @return string
     *
     * @api
     */
    public function getCategory(): string
    {
        return 'api';
    }

    /**
     * Return the content that is put in the "extensions" part
     * of the returned error.
     *
     * @return array
     */
    public function extensionsContent(): array
    {
        return [
            'reason' => $this->getReason(),
        ];
    }
}
