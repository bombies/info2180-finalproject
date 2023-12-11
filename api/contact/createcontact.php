<?php

require_once '../utils/api_utils.php';
require_once '../database/database_helpers.php';

session_start();

handle_post(function () {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        return ['error' => 'Not logged in'];
    }

    $body = $_POST;
    $title = isset($body['title']) ? $body['title'] : null;
    $firstname = isset($body['firstname']) ? $body['firstname'] : null;
    $lastname = isset($body['lastname']) ? $body['lastname'] : null;
    $email = isset($body['email']) ? $body['email'] : null;
    $company = isset($body['company']) ? $body['company'] : null;
    $telephone = isset($body['telephone']) ? $body['telephone'] : null;
    $type = isset($body['type']) ? $body['type'] : null;
    $assigned_to = isset($body['assigned_to']) ? $body['assigned_to'] : null;

    if (!$title || !$firstname || !$lastname || !$email || !$company || !$telephone || !$type || !$assigned_to) {
        http_response_code(400);
        return ['error' => 'Missing required fields'];
    }

    query("INSERT INTO contacts (title, firstname, lastname, email, company, telephone, type, assigned_to, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);", [$title, $firstname, $lastname, $email, $company, $telephone, $type, $assigned_to, $_SESSION['user_id']]);
    return ['success' => true];
});
