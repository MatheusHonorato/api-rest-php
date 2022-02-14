<?php

namespace App\DB;

use PDO;
use PDOException;

class Factory
{
    protected $connection;

    public function getConnection() 
    {
        if (!$this->connection) {
          try {
            $this->connection = new PDO(
              getenv('DB_CONNECTION').":host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASSWORD')
            );
      
          } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage());
          }
        }
        return $this->connection;
    }
}