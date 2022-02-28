<?php

namespace App\Adapters;

use GuzzleHttp\Client;

class RequestAdapter {

  public static function get($uri, $params = '') {
    try {
      $res = (new Client())->request('GET', $uri.$params);
      return $res->getBody()->getContents();
    } catch (\Throwable $th) {
      return $th;
    }
  }

}