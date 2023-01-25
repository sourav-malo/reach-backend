<?php
  namespace models;

  class Categories {
    private $conn;
    private $tableName = 'categories';
    
    public $id;
    public $name;
    public $createdAt;
    public $updatedAt;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function read() {
      $query = "SELECT `c`.`id`, `c`.`name`, (SELECT COUNT(*) FROM `users` `u` WHERE `u`.`categoryId` = `c`.`id`) AS `usersCnt`, `c`.`createdAt`, `c`.`updatedAt` FROM `$this->tableName` `c`;";

      $stmt = $this->conn->prepare($query);

      $stmt->execute();

      return $stmt;
    }
  }
?>