<?php

namespace App\Services;

use  App\Adapters\RequestAdapter;

class IbgeService {
  private const URI = 'https://servicodados.ibge.gov.br/api/v1/';

  public static function findById($id) 
  {
    return RequestAdapter::get(self::URI.'localidades/municipios/', $id);
  }

  public static function getAll() 
  {
    return RequestAdapter::get(self::URI.'localidades/municipios/');
  }
}