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
    $contactid = isset($body['contactid']) ? $body['contactid'] : null;
    $type = isset($body['type']) ? $body['type'] : null;
    $response = query("UPDATE contacts SET type = ? WHERE contacts.id = ?", [$type, $contactid])->execute();

    if (!$response) {
        http_response_code(500);
        return ['error' => 'Failed to create note'];
    }

    http_response_code(200);
    $sql = "SELECT CONCAT(contacts.title, '. ', contacts.firstname, ' ', contacts.lastname) AS fullname,"
        . "contacts.email, contacts.company, contacts.telephone, contacts.created_at, contacts.updated_at, contacts.type,"
        . "CONCAT(users.firstname, ' ', users.lastname) AS userfullname FROM contacts"
        . "JOIN users WHERE contacts.id = ? AND assigned_to = ?;";
    return query($sql, [$contactid, $_SESSION['user_id']])->fetch(PDO::FETCH_ASSOC);
});