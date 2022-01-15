<?php

namespace tests\Unit\App\Http\Controllers;

use PHPUnit\Framework\TestCase;

use App\Util\ClearString;

class ClearStringTest extends TestCase {

  public function testClearBarStringCheck() {
    $expected = "";
    $atual = "/\\";
    $this->assertEquals($expected, ClearString::execute($atual)); 
  }
}