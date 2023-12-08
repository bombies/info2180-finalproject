<?php

require_once '../utils/api_utils.php';

handle_post(function () {
    session_start();
    if ($_SESSION['user_id']) {
        session_destroy();
        http_response_code(301);
    } else {
        http_response_code(401);
    }
    return null;
});
