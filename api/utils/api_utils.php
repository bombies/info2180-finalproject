<?php

function handle_call($callback) {
    try {
        $result = $callback();
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch (Exception $e) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo $e;
    }
}

function handle_get($callback) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        handle_call($callback);
    }
}

function handle_post($callback) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        handle_call($callback);
    }
}

function is_admin() {
    if (!isset($_SESSION))
        session_start();
    return $_SESSION['role'] === 'Admin';
}
