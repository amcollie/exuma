<?php

declare(strict_types=1);

namespace Exuma\Database\Exception;

use PDOException;
use Throwable;

class DatabaseConnectionException extends PDOException
{
    protected $message;
    protected $code;
    
    public function __construct(string $message = null, int $code = null, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = $message;
        $this->code = $code;
    }
}