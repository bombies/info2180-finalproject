<?php

require_once '../utils/api_utils.php';
require_once '../database/database_helpers.php';

handle_post(function () {
    if (!is_admin()) {
        http_response_code(403);
        return ['error' => "You can't assign contacts to yourself!"];
    }

    $body = $_POST;
    $contact_id = isset($body['contact_id']) ? $body['contact_id'] : null;

    if (!$contact_id) {
        http_response_code(400);
        return ['error' => 'Missing required fields'];
    }

    $contact = query('SELECT * FROM contacts WHERE id = ?;', [$contact_id])->fetch();
    $res = query("UPDATE contacts SET type = ? WHERE id = ?;", [$contact['type'] === 'Support' ? "Sales Lead" : "Support", $contact_id]);
    return ['success' => $res];
});