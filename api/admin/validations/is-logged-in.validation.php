<?php
  if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(503);
    echo json_encode(['message' => 'Access denied']);
    exit();
  }
  
  use Firebase\JWT\JWT;
  use Firebase\JWT\Key;
  use \models\Admin;

  $headers = array_change_key_case(getallheaders(), CASE_LOWER);

  if(!isset($headers['authorization'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Missing JWT token']);
    exit();
  }

  $jwt = $headers['authorization'];

  try {
    $payload = (array) JWT::decode($jwt, new Key($_ENV['JWT_SECRET_KEY'], 'HS256'));
  } catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid JWT token']);
    exit();
  }

  if($payload['username'] != Admin::CORRECT_USERNAME) {
    http_response_code(400);
    echo json_encode(['message' => 'Admin not found']);
    exit();
  }
?>