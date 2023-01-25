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
  use Firebase\JWT\JWT;
  use Firebase\JWT\Key;

  $config = new Config();

  $database = new Database();
  $db = $database->connect();

  $users = new Users($db);

  require __DIR__ . '/validations/login.validation.php';

  $payload = [
    'id' => $user['id']
  ];
  $jwt = JWT::encode($payload, $_ENV['JWT_SECRET_KEY'], 'HS256');

  http_response_code(200);
  echo json_encode(['jwt' => $jwt]);
?>