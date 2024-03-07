<?php

declare(strict_types=1);

namespace Exuma\Database;

use Exuma\Database\Exception\DatabaseConnectionException;
use PDO;
use PDOException;

class Database implements DatabaseInterface
{
    /**
     * @var PDO
     */
    protected PDO $db;
    
    public function __construct(protected array $credentials,)
    {
    }
    
    /**
     * @inheritdoc 
     */
    public function open(): PDO
    {
        try {
            $params = [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            
            $this->db = new PDO(
                $this->credentials['dsn'],
                $this->credentials['username'],
                $this->credentials['password'],
                $params
            );
            
            return $this->db;
        } catch (PDOException $e) {
            throw new DatabaseConnectionException($e->getMessage(), (int)$e->getCode());
        }
    }
    
    /**
     * @inheritdoc
     * 
     */
    public function close(): void
    {
        unset($this->db);
    }
}