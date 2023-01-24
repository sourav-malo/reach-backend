<?php
  namespace models;

  class Admin {
    public const CORRECT_USERNAME = 'admin';
    public const CORRECT_PASSWORD = '123456';

    public $username;
    public $password;

    public function match() {
      return (self::CORRECT_USERNAME == $this->username && self::CORRECT_PASSWORD == $this->password);
    }
  }
?>