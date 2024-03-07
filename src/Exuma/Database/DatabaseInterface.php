<?php

declare(strict_types=1);

namespace Exuma\Database;

use PDO;

interface  DatabaseInterface
{
    /**
     * creates a database connection
     *
     * @return PDO
     */
    public function open(): PDO;
    
    /**
     * closes database connection
     *
     * @return void
     */
    public function close(): void;
}