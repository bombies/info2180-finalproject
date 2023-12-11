<?php

require_once '../utils/api_utils.php';
require_once '../database/database_helpers.php';

session_start();

handle_get(function (){
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        return ['error' => 'Not logged in'];
    }

    $params = $_GET;
    $contactid = isset($params['contactid']) ? $params['contactid'] : null;
    $sql = "SELECT CONCAT(contacts.title, '. ', contacts.firstname, ' ', contacts.lastname) AS fullname,"
    . "contacts.email, contacts.company, contacts.telephone, contacts.created_at, contacts.updated_at, contacts.type,"
    . "CONCAT(users.firstname, ' ', users.lastname) AS userfullname FROM contacts"
    . "JOIN users WHERE contacts.id = ? AND assigned_to = ?;;";
    return query($sql, [$contactid, $_SESSION['user_id']])->fetch(PDO::FETCH_ASSOC);
});