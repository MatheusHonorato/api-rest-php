<?php

namespace App\Util;

class ClearString
{
  public static function execute($string) {
    $string = str_replace('/', '', $string);
    $string = str_replace('\\', '', $string);
    return $string;
  }    
}
