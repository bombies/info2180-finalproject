<?php

require_once '../database/database_helpers.php';
require_once '../utils/api_utils.php';

handle_get(function() {
    if (!is_admin()) {
        return query("SELECT firstname, lastname, role, email, created_at, id FROM users WHERE id = ?;", [$_SESSION['user_id']])->fetchAll(PDO::FETCH_ASSOC);
    }

    return query("SELECT firstname, lastname, role, email, created_at, id FROM users;")->fetchAll(PDO::FETCH_ASSOC);
});