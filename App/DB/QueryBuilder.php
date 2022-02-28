<?php

namespace App\DB;

use PDOException;
use InvalidArgumentException;

class QueryBuilder
{
  private $model;
  private $pk;
  protected $stmt;
  protected $params;
  protected $group;
  protected $data;
  protected $db;

  public function __construct(object $db, string $model, string $pk = 'id')
  {
    $this->db = $db;
    $this->model = $model;
    $this->pk = $pk;
  }

  public function find(?string $terms = null, ?array $params = null, string $columns = "*")
  {
    $query = "";

    if ($terms)
      $query = "SELECT {$columns} FROM {$this->model} WHERE {$terms}";
    else
      $query = "SELECT {$columns} FROM {$this->model}";

    $stmt = $this->db->prepare($query);
    $stmt->execute($params);
    
    if($stmt->rowCount() === 1)
      return $stmt->fetch($this->db::FETCH_ASSOC);

    return $stmt->fetchAll($this->db::FETCH_ASSOC);
  }

  public function findById(int $id, string $columns = "*")
  {   
    return $this->find("{$this->pk} = :id", ['id' => $id], $columns);
  }

  public function fetch()
  {
  
    $stmt = $this->db->query("SELECT * FROM {$this->model} ORDER BY id ASC");
    $result = $stmt->fetchAll($this->db::FETCH_ASSOC);

    if(is_array($result) && count($result) > 0)
      return $result;

    throw new InvalidArgumentException(getenv('MSG_ERROR_IS_NOT_RETURN'));
  }

  public function delete(string $terms, array $data)
  {
    try {
  
      $stmt = $this->db->prepare("DELETE FROM {$this->model} WHERE {$terms}");
      $stmt->execute($data);

      if($stmt->rowCount() > 0)
        return getenv('MSG_DELETE_SUCCESS');

    } catch (PDOException $exception) {
      return $exception;
    }
  }

  public function create(array $data): ?int
  {
    try {
      $columns = implode(", ", array_keys($data));
      $values = ":" . implode(", :", array_keys($data));
      $stmt = $this->db->prepare("INSERT INTO {$this->model} ({$columns}) VALUES ({$values})");
      $stmt->execute($data);

      return $this->db->lastInsertId();
    } catch (PDOException $exception) {
        return $exception;
    }
  }

  public function update(array $data, string $params, string $terms)
  {
    try {
      $stmt = $this->db->prepare("UPDATE {$this->model} SET {$params} WHERE {$terms}");
      $stmt->execute($data);

      return getenv('MSG_UPATE_SUCCESS');
    } catch (PDOException $exception) {
      return $exception;
    }
  }

}