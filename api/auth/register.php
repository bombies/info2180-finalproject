<?php

require_once '../database/database_helpers.php';
require_once '../utils/api_utils.php';

handle_post(function () {
    if (!is_admin()) {
        http_response_code(403);
        return ['error' => "You can't register users!"];
    }

    $body = $_POST;
    $email = $body['email'];
    $password = $body['password'];
    $firstname = $body['firstname'];
    $lastname = $body['lastname'];
    $role = $body['role'];

    $user = query('SELECT * FROM users WHERE email = ?', [$email])->fetch();
    if ($user) {
        http_response_code(409);
        return ['error' => 'User already exists'];
    }

    $res = create_user($email, $password, $firstname, $lastname, $role);
    if (!$res) {
        http_response_code(500);
        return ['error' => 'Failed to create user'];
    }

    http_response_code(200);
    return ['success' => 'User created'];
});

function create_user($email, $password, $firstname, $lastname, $role) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    return query('INSERT INTO users (email, password, firstname, lastname, role) VALUES (?, ?, ?, ?, ?)', [$email, $hashed_password, $firstname, $lastname, $role])->execute();
}
