<?php

require_once '../utils/api_utils.php';
require_once '../database/database_helpers.php';

handle_get(function () {
    $params = $_GET;
    $contactid = isset($params['contactid']) ? $params['contactid'] : null;
    $sql = "SELECT notes.content, notes.contact_id, users.firstname, users.lastname FROM notes\n"
        . "JOIN users\n"
        . "ON notes.created_by = users.id WHERE notes.contact_id = ?;";
    $notes = query($sql, [$contactid])->fetchAll(PDO::FETCH_ASSOC);
    return json_encode($notes);
});

