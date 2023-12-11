<?php
require_once '../database/database_helpers.php';
require_once '../utils/api_utils.php';

handle_get(function() {
    if (!is_admin()) {
        http_response_code(403);
        return ['error' => "You can't view all users!"];
    }

    return query("SELECT firstname, lastname, role, email, created_at, id FROM users;")->fetchAll(PDO::FETCH_ASSOC);
});