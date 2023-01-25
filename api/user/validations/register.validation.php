<?php
  if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(503);
    echo json_encode(['message' => 'Access denied']);
    exit();
  }

  use Rakit\Validation\Validator;

  $_POST = array_map('trim', $_POST);

  $validator = new Validator();

  $validation = $validator->make($_POST, [
    'firstName' => 'required|max:20',
    'lastName' => 'required|max:20',
    'email' => 'required|email',
    'phone' => 'required|regex:/^\+8801[3-9]{1}[0-9]{8}$/',
    'password' => 'required|min:8|max:20|regex:/^[a-zA-Z0-9]{8,20}$/',
    'confirmPassword' => 'same:password',
    'description' => 'required|max:1000'
  ]);
  
  $validation->setMessages([
    'firstName:required' => 'First name is required',
    'firstName:max' => 'First name should not exceed 20 characters',
    'lastName:required' => 'Last name is required',
    'lastName:max' => 'Last name should not exceed 20 characters',
    'email:required' => 'Email is required',
    'email:email' => 'Invalid email address',
    'phone:required' => 'Phone number is required',
    'phone:regex' => 'Phone number must start with +880 and contain 10 digits afterwards',
    'password:required' => 'Password is required',
    'password:min' => 'Password must contain at least 8 characters',
    'password:max' => 'Password may contain at most 20 characters',
    'password:regex' => 'Password should contain only English alphabets and digits',
    'confirmPassword:same' => 'Passwords do not match',
    'description:required' => 'Description is required',
    'description:max' => 'Description must not exceed 1000 characters'
  ]);

  $validation->validate();

  if($validation->fails()) {
    http_response_code(400);
    echo json_encode(['message' => $validation->errors()->firstOfAll()[array_key_first($validation->errors()->firstOfAll())]]);
    exit();
  }

  $users->phone = $_POST['phone'];

  if($users->readByPhone()->rowCount()) {
    http_response_code(400);
    echo json_encode(['message' => 'Phone number already used']);
    exit();
  }

  $users->email = $_POST['email'];

  if($users->readByEmail()->rowCount()) {
    http_response_code(400);
    echo json_encode(['message' => 'Email already used']);
    exit();
  }
?>