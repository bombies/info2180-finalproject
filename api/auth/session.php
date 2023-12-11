<?php

require_once '../utils/api_utils.php';

handle_get(function() {
    session_start();
    if (isset($_SESSION['user_id'])) {
        return ['user_id' => $_SESSION['user_id']];
    } else {
        return null;
    }
});
