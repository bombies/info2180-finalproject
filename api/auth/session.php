<?php

require_once '../utils/api_utils.php';

handle_get(function() {
    session_start();
    if (isset($_SESSION['user_id'])) {
        return json_encode(['user_id' => $_SESSION['user_id']]);
    } else {
        return null;
    }
});
