<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController {
  private const KEY = '123456';

  public function post() {
    $data = json_decode(file_get_contents('php://input'), true);

    $search = User::finByParam('email', $data['email']);

    if(isset($search['email']) && isset($search['password']) && password_verify($data['password'], $search['password'])) {
      $token = self::generateToken($search['email']);
      return $token;
    }

    throw new \Exception('Não autenticado');
  }

  public static function checkAuth()
  {
      $http_header = apache_request_headers();

      if (isset($http_header['Authorization']) && $http_header['Authorization'] != null) {
          $jwt = str_replace('Bearer ', '', $http_header['Authorization']);

          $decode = JWT::decode($jwt, new Key(self::KEY, 'HS256'));

          if (User::finByParam('email', $decode->email)) {
            return true;
          }
      }

      return false;
  }

  public static function generateToken($user) {
    $payload = [
      'email' => $user
    ];

    return [
      'token' => JWT::encode($payload, self::KEY, 'HS256')
    ];
  }
}