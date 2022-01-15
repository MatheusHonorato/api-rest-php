<?php

namespace App\Services;

use GuzzleHttp\Client;

class IbgeService {
  private const URI = 'https://servicodados.ibge.gov.br/api/v1/';

  public static function findById($id) {

    try {
      $client = new Client();
      $res = $client->request('GET', self::URI.'localidades/municipios/'.$id);
      return $res->getBody()->getContents();
    } catch (\Throwable $th) {
      return $th;
    }
  }

  public static function getAll() {

    try {
      $client = new Client();
      $res = $client->request('GET', self::URI.'localidades/municipios');
      return $res->getBody()->getContents();
    } catch (\Throwable $th) {
      return $th;
    }
  }
}