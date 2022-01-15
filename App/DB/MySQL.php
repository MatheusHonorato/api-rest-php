<?php

namespace App\DB;

use InvalidArgumentException;
use Exception;
use PDO;
use PDOException;

class MySQL {
  private object $db;

  public function __construct() {
    $this->db = $this->setDB();
  }

  public function setDB() {
    try {
      return new PDO(
        "mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASSWORD')
      );

    } catch (PDOException $exception) {
      throw new PDOException($exception->getMessage());
    }
  }

  public function getById($table, $id) {
    if($table && $id) {
      $query = "SELECT * FROM $table WHERE id = :id";
      $stmt = $this->db->prepare($query);
      $stmt->execute(['id' => $id]);

      if($stmt->rowCount() === 1)
        return $stmt->fetch($this->db::FETCH_ASSOC);

      throw new InvalidArgumentException(getenv('MSG_ERROR_IS_NOT_RETURN'));
    }
    throw new InvalidArgumentException(getenv('MSG_ERROR_ID_IS_REQUIRED'));
  }

  public function getByParam($table, $param, $value) {
    if($table && $param && $value) {
      $query = "SELECT * FROM $table WHERE $param = :$param";
      $stmt = $this->db->prepare($query);
      $stmt->execute([$param => $value]);

      if($stmt->rowCount() === 1)
        return $stmt->fetch($this->db::FETCH_ASSOC);

      throw new InvalidArgumentException(getenv('MSG_ERROR_IS_NOT_RETURN'));
    }
    throw new InvalidArgumentException(getenv('MSG_ERROR_ID_IS_REQUIRED'));
  }

  public function getAll($table, $page, $limit) {
    $init = ($page * $limit) - $limit;
    
    if($table) {
      $query = "SELECT * FROM $table ORDER BY id ASC LIMIT $init, $limit";
      $stmt = $this->db->query($query);
      $result = $stmt->fetchAll($this->db::FETCH_ASSOC);

      if(is_array($result) && count($result) > 0)
        return $result;

    }
    throw new InvalidArgumentException(getenv('MSG_ERROR_IS_NOT_RETURN'));
  }

  public function save($table, $data) {
    if($table && $data) {
      $query = "INSERT INTO $table (name, email, password) VALUES(:name, :email, :password)";
      $stmt = $this->db->prepare($query);
      $stmt->execute($data);

      if($stmt->rowCount() > 0) {
        return getenv('MSG_SAVE_SUCCESS');
      } else {
        throw new Exception(getenv('MSG_SAVE_ERROR'));
      }
    }
  }

  public function update($table, $data) {
    if($table && $data) {
      $query = "UPDATE $table SET name = :name, email = :email, password = :password WHERE id = :id";
      $stmt = $this->db->prepare($query);
      $stmt->execute($data);

      if($stmt->rowCount() > 0) {
        return getenv('MSG_UPATE_SUCCESS');
      } else {
        throw new Exception(getenv('MSG_UPATE_ERROR'));
      }
    }
  }

  public function destroy($table, $id) {
    if($table && $id) {
      $query = "DELETE FROM $table WHERE id = :id";
      $stmt = $this->db->prepare($query);
      $stmt->execute(['id' => $id]);

      if($stmt->rowCount() > 0)
        return getenv('MSG_DELETE_SUCCESS');

      throw new InvalidArgumentException(getenv('MSG_ERROR_NOT_RETURN'));
    }
    throw new InvalidArgumentException(getenv('MSG_GENERIC_ERROR'));
  }
}