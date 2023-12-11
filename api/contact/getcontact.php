<?php

require_once '../utils/api_utils.php';
require_once '../database/database_helpers.php';

handle_get(function (){
    $params = $_GET;
    $contactid = isset($params['contactid']) ? $params['contactid'] : null;
    $sql = "SELECT CONCAT(contacts.title, '. ', contacts.firstname, ' ', contacts.lastname) AS fullname, \n"

    . "contacts.email, contacts.company, contacts.telephone, contacts.created_at, contacts.updated_at,\n"

    . "CONCAT(users.firstname, ' ',users.lastname) AS userfullname FROM contacts\n"

    . "JOIN users WHERE contacts.id = ?;\n";
    $response = query($sql, [$contactid])->fetch(PDO::FETCH_ASSOC);
    return json_encode($response);
})

?>