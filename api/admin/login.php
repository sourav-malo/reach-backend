<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Methods: POST'); 

  require dirname(dirname(__DIR__)) . '/vendor/autoload.php';

  $dotenv = Dotenv\Dotenv::createImmutable(dirname(dirname(__DIR__)));
  $dotenv->safeLoad();

  use \config\Config;
  use \config\Database;
  use \models\Admin;
  use Firebase\JWT\JWT;
  use Firebase\JWT\Key;

  $config = new Config();

  $database = new Database();
  $db = $database->connect();

  $admin = new Admin($db);

  require __DIR__ . '/validations/login.validation.php';

  if(!$admin->match()) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid username or password']);
    exit();
  }

  $payload = [
    'username' => Admin::CORRECT_USERNAME
  ];
  $jwt = JWT::encode($payload, $_ENV['JWT_SECRET_KEY'], 'HS256');

  http_response_code(200);
  echo json_encode(['jwt' => $jwt]);
?>