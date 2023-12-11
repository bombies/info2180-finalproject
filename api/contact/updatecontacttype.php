<?php

require_once '../utils/api_utils.php';
require_once '../database/database_helpers.php';

handle_post(function () {
    $body = $_POST;
    $contactid = isset($body['contactid']) ? $body['contactid'] : null;
    $type = isset($body['type']) ? $body['type'] : null;
    $response = query("UPDATE contacts SET type = ? WHERE contacts.id = ?", [$type, $contactid])->execute();

    if (!$response) {
        http_response_code(500);
        return ['error' => 'Failed to create note'];
    }

    http_response_code(200);
    $sql = "SELECT CONCAT(contacts.title, '. ', contacts.firstname, ' ', contacts.lastname) AS fullname, \n"
        . "contacts.email, contacts.company, contacts.telephone, contacts.created_at, contacts.updated_at, contacts.type,\n"
        . "CONCAT(users.firstname, ' ',users.lastname) AS userfullname FROM contacts\n"
        . "JOIN users WHERE contacts.id = ?;\n";
    $updatedContact = query($sql, [$contactid])->fetch(PDO::FETCH_ASSOC);
    return $updatedContact;
})
?>