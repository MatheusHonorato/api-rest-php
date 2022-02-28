<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService {

  private const KEY = '123456';

  public static function login($data, $search)
  {
    if(isset($search['email']) && isset($search['password']) && password_verify($data['password'], $search['password']))
      return self::generateToken($search['email']);

    throw new \Exception('Não autenticado');
  }

  public static function checkAuth()
  {
    $http_header = apache_request_headers();

    if (isset($http_header['Authorization']) && $http_header['Authorization'] != null)
    {
      $jwt = str_replace('Bearer ', '', $http_header['Authorization']);

      $decode = JWT::decode($jwt, new Key(self::KEY, 'HS256'));

      if (UserService::finByParam("email = :email", ['email' => $decode->email], 'email'))
        return true;
    }

    return false;
  }

  public static function generateToken($user) 
  {
    $payload = [
      'email' => $user
    ];

    return [
      'token' => JWT::encode($payload, self::KEY, 'HS256')
    ];
  }
}