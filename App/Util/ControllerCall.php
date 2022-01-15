<?php

namespace App\Util;

use App\Util\ClearString;


class ControllerCall
{
  public static function generate($url) {
    $url = explode('?', $_SERVER['REQUEST_URI']);
    $url = explode('/', $url[getenv('FIRST_VALUE')]);

    $controller = '\App\Http\Controllers\\'.ucfirst(ClearString::execute($url[getenv('CONTROLLER_INDICE')])).'Controller';

    $controller = preg_replace('/[0-9]+h/', '', $controller);

    return $controller;
  }    
}
