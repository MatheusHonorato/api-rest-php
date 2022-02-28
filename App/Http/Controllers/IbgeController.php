<?php

namespace App\Http\Controllers;

use App\Services\IbgeService;
use App\Services\AuthService;

class IbgeController {
  public function get($id = null) 
  {
    if($id)
      return json_decode(IbgeService::findById($id));

    if(AuthService::checkAuth())
      return json_decode(IbgeService::getAll());

    throw new \Exception('Não autenticado');
  }
}