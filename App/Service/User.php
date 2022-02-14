<?php

namespace App\Service;

use App\Models\User as UserModel;
use App\DB\Factory;
use App\DB\QueryBuilder;

class User {

  public static function findById(int $id) {
    $user_data = new UserModel();
    $user_data->setId($id);
    return (new QueryBuilder((new Factory())->getConnection(), UserModel::TABLE))->findById($user_data->getId());
  }

  public static function finByParam($terms, $params, $columns) {
    return (new QueryBuilder((new Factory())->getConnection(), UserModel::TABLE))->find($terms, $params, $columns);
  }

  public static function getAll($page, $limit) {
    /*if(isset($_GET['page']))
      $page = $_GET['page'];
  
    if(isset($_GET['limit']))
      $limit = $_GET['limit'];*/

    return (new QueryBuilder((new Factory())->getConnection(), UserModel::TABLE))->fetch();
  }

  public static function save(array $data) {
    $user_data = (new UserModel($data))->get();
    return (new QueryBuilder((new Factory())->getConnection(), UserModel::TABLE))->create($user_data);
  }

  public static function update(array $data) {
    $user_data = (new UserModel($data))->get();
    return (new QueryBuilder((new Factory())->getConnection(), UserModel::TABLE))->update($user_data);
  }

  public static function destroy(int $id) {
    $user_data = new UserModel();
    $user_data->setId($id);
    return (new QueryBuilder((new Factory())->getConnection(), UserModel::TABLE))->delete("id = :id", $id);
  }
}
