<?php

namespace App\Models;

class User {
  public const TABLE = 'users';

  private int $id;
  private string $name;
  private string $email;
  private string $password;

  public function __construct(?array $data = null){
    if($data['name']) $this->setName($data['name']);
    if($data['email']) $this->setEmail($data['email']);
    if($data['password']) $this->setPassword($data['password']);
  }

  public function getId() {
    return $this->id;
  }
  public function setId(int $id) {
    $this->id = $id;
  }
  public function getName() {
    return $this->name;
  }
  public function setName(string $name) {
    $this->name = $name;
  }
  public function getEmail() {
    return $this->email;
  }
  public function setEmail(string $email) {
    $this->email = $email;
  }
  public function getPassword() {
    return $this->password;
  }
  public function setPassword(string $password) {
    $this->password = password_hash($password, PASSWORD_DEFAULT);
  }

  public function get() {
    $user['name'] = $this->getName();
    $user['email'] = $this->getEmail();
    $user['password'] =$this->getPassword();

    return $user;
  }
}
