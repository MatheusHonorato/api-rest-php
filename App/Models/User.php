<?php

namespace App\Models;

use App\Repository\UserRepository;

class User {
  public const TABLE = 'users';

  public static function findById($id) {
    return UserRepository::getMySQL()->getById(self::TABLE, $id);
  }

  public static function finByParam($param, $value) {
    return UserRepository::getMySQL()->getByParam(self::TABLE, $param, $value);
  }

  public static function getAll($page, $limit) {
    if(isset($_GET['page']))
      $page = $_GET['page'];
  
    if(isset($_GET['limit']))
      $limit = $_GET['limit'];

    return UserRepository::getMySQL()->getAll(self::TABLE, $page, $limit);
  }

  public static function save($user) {
    $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
  
    return UserRepository::getMySQL()->save(self::TABLE, $user);
  }

  public static function update($user) {
    if($user['password'])
      $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);

    return UserRepository::getMySQL()->update(self::TABLE, $user);
  }

  public static function destroy($id) {
    return UserRepository::getMySQL()->destroy(self::TABLE, $id);
  }
}
