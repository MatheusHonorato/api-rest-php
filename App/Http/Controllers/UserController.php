<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\AuthService;

class UserController {

  public function get($id = null, $page = 1, $limit = 20)
  {
    if ($id)
      return UserService::findById($id);

    if(AuthService::checkAuth())
      return UserService::getAll($page, $limit);
    throw new \Exception('Não autenticado');
  }

  public function post()
  {
    $data = json_decode(file_get_contents('php://input'), true);

    return UserService::save($data);
  }

  public function put() 
  {
    $data = json_decode(file_get_contents('php://input'), true);

    return UserService::update($data);
  }

  public function delete($id = null)
  {
    return UserService::destroy($id);
  }
}