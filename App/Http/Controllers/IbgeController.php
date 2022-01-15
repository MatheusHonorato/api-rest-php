<?php

namespace App\Http\Controllers;

use App\Services\IbgeService;

class IbgeController {
  public function get($id = null) {
    if($id) {
      return json_decode(IbgeService::findById($id));
    } else {
      if(AuthController::checkAuth())
        return json_decode(IbgeService::getAll());
      throw new \Exception('Não autenticado');
    }
  }
}