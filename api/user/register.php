<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Methods: POST'); 

  require dirname(dirname(__DIR__)) . '/vendor/autoload.php';

  $dotenv = Dotenv\Dotenv::createImmutable(dirname(dirname(__DIR__)));
  $dotenv->safeLoad();

  use \config\Config;
  use \config\Database;
  use \models\Users;

  $config = new Config();

  $database = new Database();
  $db = $database->connect();

  $users = new Users($db);

  require __DIR__ . '/validations/register.validation.php';

  $users->firstName = $_POST['firstName'];
  $users->lastName = $_POST['lastName'];
  $users->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $users->description = $_POST['description'];
  $users->createdAt = date('Y-m-d H:i:s', time());
  $users->updatedAt = date('Y-m-d H:i:s', time());

  if(!$users->create()) {
    http_response_code(500);
    echo json_encode(['message' => 'Server error']);
    exit();
  }

  http_response_code(200);
  echo json_encode(['message' => 'Successfully applied for the registration']);
?>