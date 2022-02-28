<?php

namespace App\DB;

use PDO;

class MySQL implements InterfaceDB
{
  public function getConnection()
  {
    return new PDO(
      "mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASSWORD')
    );
  }
}