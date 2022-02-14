<?php

namespace App\DB;

use stdClass;
use PDO;
use PDOException;
use InvalidArgumentException;
use App\DB\Factory;

class QueryBuilder
{
    private $model;
    private $pk;
    private $timestamps;
    protected $stmt;
    protected $params;
    protected $group;
    protected $data;
    protected $db;

    public function __construct(object $db, string $model, string $pk = 'id', bool $timestamps = true)
    {
      $this->db = $db;
      $this->model = $model;
      $this->pk = $pk;
      $this->timestamps = $timestamps;

    }

    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new stdClass();
        }

        $this->data->$name = $value;
    }

    public function __isset($name)
    {
        return isset($this->data->$name);
    }

    public function __get($name)
    {
    return ($this->data->$name ?? null);
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

    public function fetch(bool $all = false)
    {
    
      $query = "SELECT * FROM {$this->model} ORDER BY id ASC";
      $stmt = $this->db->query($query);
      $result = $stmt->fetchAll($this->db::FETCH_ASSOC);

      if(is_array($result) && count($result) > 0)
        return $result;

      throw new InvalidArgumentException(getenv('MSG_ERROR_IS_NOT_RETURN'));
    }

  public function delete(string $terms, ?string $params)
  {
    try {
  
        $query = "DELETE FROM {$this->model} WHERE {$terms}";
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        if($stmt->rowCount() > 0)
          return getenv('MSG_DELETE_SUCCESS');

    } catch (\PDOException $exception) {
        return $exception;
    }
  }

  public function create(array $data): ?int
  {
    try {

        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $stmt = Factory::getInstance()->prepare("INSERT INTO {$this->model} ({$columns}) VALUES ({$values})");
        $stmt->execute($this->data);

        return Factory::getInstance()->lastInsertId();
    } catch (\PDOException $exception) {
        return $exception;
    }
  }

  public function update(array $data): ?int
  {
    try {

        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $stmt = Factory::getInstance()->prepare("INSERT INTO {$this->model} ({$columns}) VALUES ({$values})");
        $stmt->execute($this->data);

        return Factory::getInstance()->lastInsertId();
    } catch (\PDOException $exception) {
        return $exception;
    }
  }

}