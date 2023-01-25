<?php
  if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(503);
    echo json_encode(['message' => 'Access denied']);
    exit();
  }

  use Rakit\Validation\Validator;

  $validator = new Validator();

  $_POST = array_map('trim', $_POST);

  $validation = $validator->make($_POST, [
    'id' => 'required'
  ]);
  
  $validation->setMessages([
    'id:required' => 'User id is required'
  ]);

  $validation->validate();

  if($validation->fails()) {
    http_response_code(400);
    echo json_encode(['message' => $validation->errors()->firstOfAll()[array_key_first($validation->errors()->firstOfAll())]]);
    exit();
  }

  $users->id = $_POST['id'];

  if(!$users->readById()->rowCount()) {
    http_response_code(404);
    echo json_encode(['message' => 'User not found']);
    exit();
  }
?>