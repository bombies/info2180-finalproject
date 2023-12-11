<?php

require_once '../utils/api_utils.php';
require_once '../database/database_helpers.php';

handle_get(function () {
    return query("SELECT CONCAT(title, '. ', firstname, ' ', lastname) AS fullname, email, company, type, id from contacts;")->fetchAll(PDO::FETCH_ASSOC);
})
?>