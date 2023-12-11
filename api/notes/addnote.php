<?php

require_once '../utils/api_utils.php';
require_once '../database/database_helpers.php';

handle_post(function () {
    $body = $_POST;
    $content = isset($body['content']) ? $body['content'] : null;
    $contact_id = isset($body['contact_id']) ? $body['contact_id'] : null;

    $contact = query('SELECT * FROM contacts WHERE id = ?;', [$contact_id])->fetch();

    if (!is_admin() && $_SESSION['user_id'] !== $contact['assigned_to']) {
        http_response_code(403);
        return ['error' => "You can't add a note to this contact!"];
    }

    if (!$content || !$contact_id) {
        http_response_code(400);
        return ['error' => 'Missing required fields'];
    }

    query("INSERT INTO notes (content, contact_id, created_by) VALUES (?, ?, ?);", [$content, $contact_id, $_SESSION['user_id']]);
    query("UPDATE contacts SET updated_at = NOW() WHERE id = ?;", [$contact_id]);
    $sql = "SELECT notes.content, notes.contact_id, notes.created_at, users.firstname, users.lastname FROM notes\n"
        . "JOIN users\n"
        . "ON notes.created_by = users.id WHERE notes.contact_id = ?\n"
        . "ORDER BY notes.created_at DESC\n";
    return query($sql, [$contact_id])->fetch(PDO::FETCH_ASSOC);
});
