<?php

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

    query("UPDATE contacts SET assigned_to = ? WHERE id = ?;", [$_SESSION['user_id'], $contact_id]);
    return ['success' => true];
});
