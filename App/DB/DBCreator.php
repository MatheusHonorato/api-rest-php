<?php

namespace App\DB;

class DBCreator extends AbstractCreatorDB {

  function factoryMethod()
  {
    return (new MySQL())->getConnection();
  }
}