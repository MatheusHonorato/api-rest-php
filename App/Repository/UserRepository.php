<?php

namespace App\Repository;

use App\DB\MySQL;

class UserRepository {

  public static function getMySQL() {
    return new MySQL();
  }
}