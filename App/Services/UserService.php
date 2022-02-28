<?php

namespace App\Services;

use App\Models\User as UserModel;
use App\DB\DBCreator;
use App\DB\QueryBuilder;

class UserService {

  public static function findById(int $id)
  {
    $user_data = new UserModel();
    $user_data->setId($id);

    return (new QueryBuilder((new DBCreator())->factoryMethod(), UserModel::TABLE))->findById($user_data->getId());
  }

  public static function finByParam($terms, $params, $columns)
  {
    return (new QueryBuilder((new DBCreator())->factoryMethod(), UserModel::TABLE))->find($terms, $params, $columns);
  }

  public static function getAll()
  {
    return (new QueryBuilder((new DBCreator())->factoryMethod(), UserModel::TABLE))->fetch();
  }

  public static function save(array $data)
  {
    $user_data = (new UserModel($data))->get();

    return (new QueryBuilder((new DBCreator())->factoryMethod(), UserModel::TABLE))->create($user_data);
  }

  public static function update(array $data)
  {
    $user_data = (new UserModel($data))->getAll();

    return (new QueryBuilder((new DBCreator())->factoryMethod(), UserModel::TABLE))->update(
      $user_data,
      "name = :name, email = :email, password = :password",
      "id = :id"
    );
  }

  public static function destroy(int $id)
  {
    $user_data = new UserModel();
    $user_data->setId($id);

    return (new QueryBuilder((new DBCreator())->factoryMethod(), UserModel::TABLE))->delete("id = :id", ['id' => $user_data->getId()]);
  }
}
