<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController {
  public function get($id = null, $page = 1, $limit = 20) {
    if($id) {
      return User::findById($id);
    } else {
      if(AuthController::checkAuth())
        return User::getAll($page, $limit);
      throw new \Exception('Não autenticado');
    }
  }

  public function post() {
    $data = json_decode(file_get_contents('php://input'), true);
  
    return User::save($data);
  }

  public function put() {
    $data = json_decode(file_get_contents('php://input'), true);

    return User::update($data);
  }

  public function delete($id = null) {
    return User::destroy($id);
  }
}