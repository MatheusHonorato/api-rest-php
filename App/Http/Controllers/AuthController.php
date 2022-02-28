<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\AuthService;

class AuthController {

  public function post() 
  {
    $data = json_decode(file_get_contents('php://input'), true);

    $search = UserService::finByParam(
      "email = :email",
      ['email' => $data['email']], 
      'email, password'
    );

    if($search)
      return AuthService::login($data, $search);
    
    throw new \Exception('Usuário não cadastrado.');
  }
}