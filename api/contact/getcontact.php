<?php

require_once '../utils/api_utils.php';
require_once '../database/database_helpers.php';

session_start();

handle_get(function () {
    $contact_id = isset($_GET['id']) ? $_GET['id'] : null;
    if (!$contact_id) {
        http_response_code(400);
        return ['error' => 'You must provide the ID of a contact to fetch!'];
    }

    if (!is_admin() && $contact_id !== $_SESSION['user_id']) {
        http_response_code(403);
        return ['error' => "You can't view this contact!"];
    }

    $sql = "SELECT CONCAT(contacts.title, '. ', contacts.firstname, ' ', contacts.lastname) AS contactFullName,"
    . "contacts.email, contacts.company, contacts.telephone, contacts.created_at, contacts.updated_at, contacts.type,"
    . "CONCAT(users.firstname, ' ', users.lastname) AS userFullName FROM contacts"
    . "JOIN users WHERE contacts.id = ? AND assigned_to = ?;";
    return query($sql, [$contact_id, $_SESSION['user_id']])->fetch(PDO::FETCH_ASSOC);
});