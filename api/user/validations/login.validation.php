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
    'email' => 'required',
    'password' => 'required'
  ]);
  
  $validation->setMessages([
    'email:required' => 'Email is required',
    'password:required' => 'Password is required'
  ]);

  $validation->validate();

  if($validation->fails()) {
    http_response_code(400);
    echo json_encode(['message' => $validation->errors()->firstOfAll()[array_key_first($validation->errors()->firstOfAll())]]);
    exit();
  }

  $users->email = $_POST['email'];
  $users->password = $_POST['password'];

  if(!$users->readByEmail()->rowCount()) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid email or password']);
    exit();
  }

  $user = $users->readByEmail()->fetch(PDO::FETCH_ASSOC);

  if(!password_verify($users->password, $user['password']) || $user['isVerified'] != 1) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid email or password']);
    exit();
  }
?>