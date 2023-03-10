<?php
  namespace models;

  class Users {
    private $conn;
    private $tableName = 'users';

    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $password;
    public $isVerified;
    public $description;
    public $categoryId;
    public $currentBalance;
    public $createdAt;
    public $updatedAt;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function read() {
      $query = "SELECT * FROM `$this->tableName` ORDER BY `id` DESC;";

      $stmt = $this->conn->prepare($query);

      $stmt->execute();

      return $stmt;
    }

    public function readById() {
      $query = "SELECT * FROM `$this->tableName` WHERE `id` = :id;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':id', $this->id);

      $stmt->execute();

      return $stmt;
    }

    public function readByPhone() {
      $query = "SELECT * FROM `$this->tableName` WHERE `phone` = :phone;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':phone', $this->phone);

      $stmt->execute();

      return $stmt;
    }

    public function readByEmail() {
      $query = "SELECT * FROM `$this->tableName` WHERE `email` = :email;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':email', $this->email);

      $stmt->execute();

      return $stmt;
    }

    public function create() {
      $query = "INSERT INTO `$this->tableName`(`firstName`, `lastName`, `email`, `phone`, `password`, `description`, `createdAt`, `updatedAt`) VALUES(:firstName, :lastName, :email, :phone, :password, :description, :createdAt, :updatedAt);";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':firstName', $this->firstName);
      $stmt->bindParam(':lastName', $this->lastName);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':phone', $this->phone);
      $stmt->bindParam(':password', $this->password);
      $stmt->bindParam(':description', $this->description);
      $stmt->bindParam(':createdAt', $this->createdAt);
      $stmt->bindParam(':updatedAt', $this->updatedAt);

      return $stmt->execute() ? true : false;
    }

    public function updateIsVerified() {
      $query = "UPDATE `$this->tableName` SET `isVerified` = :isVerified, `updatedAt` = :updatedAt WHERE `id` = :id;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':isVerified', $this->isVerified);
      $stmt->bindParam(':updatedAt', $this->updatedAt);
      $stmt->bindParam(':id', $this->id);

      return $stmt->execute() ? true : false;
    }

    public function updateCategoryId() {
      $query = "UPDATE `$this->tableName` SET `categoryId` = :categoryId, `updatedAt` = :updatedAt WHERE `id` = :id;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':categoryId', $this->categoryId);
      $stmt->bindParam(':updatedAt', $this->updatedAt);
      $stmt->bindParam(':id', $this->id);

      return $stmt->execute() ? true : false;
    }
  }
?>