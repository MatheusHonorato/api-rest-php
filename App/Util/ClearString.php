<?php

namespace App\Util;

class ClearString
{
  public static function execute($string) {
    return str_replace('\\', '', str_replace('/', '', $string));
  }    
}
