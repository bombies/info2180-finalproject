<?php

require_once '../utils/api_utils.php';
require_once '../database/database_helpers.php';

session_start();

handle_get(function () {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        return ['error' => 'Not logged in'];
    }

    $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
    $whereQuery = '';
    $whereParams = [];
    switch ($filter) {
        case 'assigned':
            $whereQuery = 'WHERE assigned_to = ?';
            $whereParams = [$_SESSION['user_id']];
            break;
        case 'sales':
            $whereQuery = 'WHERE type = ?';
            $whereParams = ['Sales Lead'];
            break;
        case "support":
            $whereQuery = 'WHERE type = ?';
            $whereParams = ['Support'];
            break;
    }

    return query(
        "SELECT CONCAT(title, '. ', firstname, ' ', lastname) AS fullname, email, company, type, id from contacts $whereQuery;",
        $whereParams
    )->fetchAll(PDO::FETCH_ASSOC);
});