<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Methods: POST'); 

  require dirname(dirname(__DIR__)) . '/vendor/autoload.php';

  $dotenv = Dotenv\Dotenv::createImmutable(dirname(dirname(__DIR__)));
  $dotenv->safeLoad();

  use \config\Config;
  use \config\Database;
  use \models\Categories;

  $config = new Config();

  $database = new Database();
  $db = $database->connect();

  $categories = new Categories($db);

  $allCategories = $categories->read()->fetchAll(PDO::FETCH_ASSOC);

  http_response_code(200);
  echo json_encode($allCategories);
?>