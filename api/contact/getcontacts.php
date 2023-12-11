<?php

require_once '../utils/api_utils.php';
require_once '../database/database_helpers.php';

session_start();

handle_get(function () {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        return ['error' => 'Not logged in'];
    }

    return query("SELECT CONCAT(title, '. ', firstname, ' ', lastname) AS fullname, email, company, type, id from contacts;")->fetchAll(PDO::FETCH_ASSOC);
});