<?php

require_once '../database/database_helpers.php';
require_once '../utils/api_utils.php';

handle_post(function () {
    $body = $_POST;
    $email = isset($body['email']) ? $body['email'] : null;
    $password = isset($body['password']) ? $body['password'] : null;

    $user = query('SELECT * FROM users WHERE email = ?', [$email])->fetch();
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        http_response_code(200);
        return json_encode(['user_id' => $user['id']]);
    } else {
        http_response_code(401);
        return null;
    }
});




