<?php

require_once '../../api/utils/api_utils.php';
require_once '../../api/database/database_helpers.php';

function fetch_contact() {
    $contact_id = isset($_GET['id']) ? $_GET['id'] : null;
    if (!$contact_id) {
        http_response_code(400);
        return ['error' => 'You must provide the ID of a contact to fetch!'];
    }

    // Select the contact with the related user and notes
    $sql = "SELECT contacts.id, contacts.title, contacts.firstname, contacts.lastname,\n"
        . "contacts.email, contacts.company, contacts.telephone, contacts.created_at, contacts.updated_at, contacts.type, contacts.assigned_to,\n"
        . "CONCAT(au.firstname, ' ', au.lastname) AS assignedFullName,\n"
        . "CONCAT(cu.firstname, ' ', cu.lastname) AS creatorFullName FROM contacts\n"
        . "JOIN users as au ON contacts.assigned_to = au.id\n"
        . "JOIN users as cu ON contacts.created_by = cu.id\n"
        . "WHERE contacts.id = ?;";

    $contact = query($sql, [$contact_id])->fetch(PDO::FETCH_ASSOC);

    if (!is_admin() && $contact['assigned_to'] !== $_SESSION['user_id']) {
        http_response_code(403);
        $contact = null;
    }

    return $contact;
}

$contact = fetch_contact();

function fetch_notes() {
    global $contact;
    if (!$contact)
        return null;

    if (!is_admin() && $contact['assigned_to'] !== $_SESSION['user_id']) {
        http_response_code(403);
        $contact = null;
    }

    $sql = "SELECT notes.content, notes.contact_id, notes.created_at, users.firstname, users.lastname FROM notes\n"
        . "JOIN users\n"
        . "ON notes.created_by = users.id WHERE notes.contact_id = ?;";
    return query($sql, [$contact['id']])->fetchAll(PDO::FETCH_ASSOC);
}

$notes = fetch_notes();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INFO2180 Project 2 - Contact</title>
    <link rel="stylesheet" href="../../styles.css">
</head>
<body>
<header class="overhead">
    <div class="nav-brand">
        <img src="../../images/Dolphin.png" alt="Dolphin">
        <p>Dolphin CRM</p>
    </div>
</header>
<main class="layout">
    <aside class="sidebar">
        <a href="/info2180-finalproject/dashboard" class="sidebar-item">
            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
            <svg width="30px" height="30px" viewBox="0 -0.5 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M18.867 15.8321L18.873 10.0391L14.75 5.92908C13.5057 4.69031 11.4942 4.69031 10.25 5.92908L6.13599 10.0291V15.8291C6.1393 17.5833 7.56377 19.0028 9.31799 19.0001H15.685C17.438 19.0029 18.862 17.5851 18.867 15.8321Z"
                      stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M19.624 6.01807C19.624 5.60385 19.2882 5.26807 18.874 5.26807C18.4598 5.26807 18.124 5.60385 18.124 6.01807H19.624ZM18.874 10.0391H18.124C18.124 10.2384 18.2033 10.4295 18.3445 10.5702L18.874 10.0391ZM19.9705 12.1912C20.2638 12.4837 20.7387 12.4829 21.0311 12.1896C21.3236 11.8962 21.3229 11.4214 21.0295 11.1289L19.9705 12.1912ZM6.66552 10.5602C6.95886 10.2678 6.95959 9.79289 6.66714 9.49955C6.3747 9.20621 5.89982 9.20548 5.60648 9.49793L6.66552 10.5602ZM3.97048 11.1289C3.67714 11.4214 3.67641 11.8962 3.96886 12.1896C4.2613 12.4829 4.73618 12.4837 5.02952 12.1912L3.97048 11.1289ZM13.75 19.0001C13.75 19.4143 14.0858 19.7501 14.5 19.7501C14.9142 19.7501 15.25 19.4143 15.25 19.0001H13.75ZM9.75 19.0001C9.75 19.4143 10.0858 19.7501 10.5 19.7501C10.9142 19.7501 11.25 19.4143 11.25 19.0001H9.75ZM18.124 6.01807V10.0391H19.624V6.01807H18.124ZM18.3445 10.5702L19.9705 12.1912L21.0295 11.1289L19.4035 9.50792L18.3445 10.5702ZM5.60648 9.49793L3.97048 11.1289L5.02952 12.1912L6.66552 10.5602L5.60648 9.49793ZM15.25 19.0001V17.2201H13.75V19.0001H15.25ZM15.25 17.2201C15.25 15.7013 14.0188 14.4701 12.5 14.4701V15.9701C13.1904 15.9701 13.75 16.5297 13.75 17.2201H15.25ZM12.5 14.4701C10.9812 14.4701 9.75 15.7013 9.75 17.2201H11.25C11.25 16.5297 11.8096 15.9701 12.5 15.9701V14.4701ZM9.75 17.2201V19.0001H11.25V17.2201H9.75Z"
                      fill="#000000"/>
            </svg>
            <span>Home</span>
        </a>
        <a href="/info2180-finalproject/dashboard/newcontact" class="sidebar-item">
            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.0376 5.31617L10.6866 6.4791C11.2723 7.52858 11.0372 8.90532 10.1147 9.8278C10.1147 9.8278 10.1147 9.8278 10.1147 9.8278C10.1146 9.82792 8.99588 10.9468 11.0245 12.9755C13.0525 15.0035 14.1714 13.8861 14.1722 13.8853C14.1722 13.8853 14.1722 13.8853 14.1722 13.8853C15.0947 12.9628 16.4714 12.7277 17.5209 13.3134L18.6838 13.9624C20.2686 14.8468 20.4557 17.0692 19.0628 18.4622C18.2258 19.2992 17.2004 19.9505 16.0669 19.9934C14.1588 20.0658 10.9183 19.5829 7.6677 16.3323C4.41713 13.0817 3.93421 9.84122 4.00655 7.93309C4.04952 6.7996 4.7008 5.77423 5.53781 4.93723C6.93076 3.54428 9.15317 3.73144 10.0376 5.31617Z"
                      stroke="#000000" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <span>New Contact</span>
        </a>
        <a href="/info2180-finalproject/dashboard/users" class="sidebar-item">
            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 12.25C13.2583 12.25 12.5333 12.0301 11.9166 11.618C11.2999 11.206 10.8193 10.6203 10.5355 9.93506C10.2516 9.24984 10.1774 8.49584 10.3221 7.76841C10.4668 7.04098 10.8239 6.3728 11.3484 5.84835C11.8728 5.3239 12.541 4.96675 13.2684 4.82206C13.9958 4.67736 14.7498 4.75162 15.4351 5.03545C16.1203 5.31928 16.706 5.79993 17.118 6.41661C17.5301 7.0333 17.75 7.75832 17.75 8.5C17.75 9.49456 17.3549 10.4484 16.6517 11.1517C15.9484 11.8549 14.9946 12.25 14 12.25ZM14 6.25C13.555 6.25 13.12 6.38196 12.75 6.62919C12.38 6.87643 12.0916 7.22783 11.9213 7.63896C11.751 8.0501 11.7064 8.5025 11.7932 8.93895C11.8801 9.37541 12.0943 9.77632 12.409 10.091C12.7237 10.4057 13.1246 10.62 13.561 10.7068C13.9975 10.7936 14.4499 10.749 14.861 10.5787C15.2722 10.4084 15.6236 10.12 15.8708 9.75003C16.118 9.38002 16.25 8.94501 16.25 8.5C16.25 7.90326 16.0129 7.33097 15.591 6.90901C15.169 6.48705 14.5967 6.25 14 6.25Z"
                      fill="#000000"/>
                <path d="M21 19.25C20.8019 19.2474 20.6126 19.1676 20.4725 19.0275C20.3324 18.8874 20.2526 18.6981 20.25 18.5C20.25 16.55 19.19 15.25 14 15.25C8.81 15.25 7.75 16.55 7.75 18.5C7.75 18.6989 7.67098 18.8897 7.53033 19.0303C7.38968 19.171 7.19891 19.25 7 19.25C6.80109 19.25 6.61032 19.171 6.46967 19.0303C6.32902 18.8897 6.25 18.6989 6.25 18.5C6.25 13.75 11.68 13.75 14 13.75C16.32 13.75 21.75 13.75 21.75 18.5C21.7474 18.6981 21.6676 18.8874 21.5275 19.0275C21.3874 19.1676 21.1981 19.2474 21 19.25Z"
                      fill="#000000"/>
                <path d="M8.31999 13.06H7.99999C7.20434 12.9831 6.47184 12.5933 5.96361 11.9763C5.45539 11.3593 5.21308 10.5657 5.28999 9.77001C5.36691 8.97436 5.75674 8.24186 6.37373 7.73363C6.99073 7.22541 7.78434 6.9831 8.57999 7.06001C8.68201 7.0644 8.78206 7.08957 8.87401 7.13399C8.96596 7.1784 9.04787 7.24113 9.11472 7.31831C9.18157 7.3955 9.23196 7.48553 9.26279 7.58288C9.29362 7.68023 9.30425 7.78285 9.29402 7.88445C9.28379 7.98605 9.25292 8.08449 9.20331 8.17374C9.15369 8.26299 9.08637 8.34116 9.00548 8.40348C8.92458 8.46579 8.83181 8.51093 8.73286 8.53613C8.6339 8.56133 8.53084 8.56605 8.42999 8.55001C8.23479 8.53055 8.03766 8.55062 7.85038 8.60904C7.6631 8.66746 7.48952 8.76302 7.33999 8.89001C7.18812 9.01252 7.06216 9.16403 6.96945 9.33572C6.87673 9.50741 6.81913 9.69583 6.79999 9.89001C6.77932 10.0866 6.79797 10.2854 6.85488 10.4747C6.91178 10.6641 7.0058 10.8402 7.13144 10.9928C7.25709 11.1455 7.41186 11.2716 7.58673 11.3638C7.76159 11.456 7.95307 11.5125 8.14999 11.53C8.47553 11.5579 8.80144 11.4808 9.07999 11.31C9.24973 11.2053 9.45413 11.1722 9.64824 11.2182C9.84234 11.2641 10.0102 11.3853 10.115 11.555C10.2198 11.7248 10.2528 11.9292 10.2069 12.1233C10.1609 12.3174 10.0397 12.4853 9.86999 12.59C9.40619 12.8858 8.86998 13.0484 8.31999 13.06Z"
                      fill="#000000"/>
                <path d="M3 18.5C2.80189 18.4974 2.61263 18.4176 2.47253 18.2775C2.33244 18.1374 2.25259 17.9481 2.25 17.75C2.25 15.05 2.97 13.25 6.5 13.25C6.69891 13.25 6.88968 13.329 7.03033 13.4697C7.17098 13.6103 7.25 13.8011 7.25 14C7.25 14.1989 7.17098 14.3897 7.03033 14.5303C6.88968 14.671 6.69891 14.75 6.5 14.75C4.15 14.75 3.75 15.5 3.75 17.75C3.74741 17.9481 3.66756 18.1374 3.52747 18.2775C3.38737 18.4176 3.19811 18.4974 3 18.5Z"
                      fill="#000000"/>
            </svg>
            <span>Users</span>
        </a>
        <hr class="divider"/>
        <div class="sidebar-item logout-button">
            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="Interface / Log_Out">
                    <path id="Vector"
                          d="M12 15L15 12M15 12L12 9M15 12H4M9 7.24859V7.2002C9 6.08009 9 5.51962 9.21799 5.0918C9.40973 4.71547 9.71547 4.40973 10.0918 4.21799C10.5196 4 11.0801 4 12.2002 4H16.8002C17.9203 4 18.4796 4 18.9074 4.21799C19.2837 4.40973 19.5905 4.71547 19.7822 5.0918C20 5.5192 20 6.07899 20 7.19691V16.8036C20 17.9215 20 18.4805 19.7822 18.9079C19.5905 19.2842 19.2837 19.5905 18.9074 19.7822C18.48 20 17.921 20 16.8031 20H12.1969C11.079 20 10.5192 20 10.0918 19.7822C9.71547 19.5905 9.40973 19.2839 9.21799 18.9076C9 18.4798 9 17.9201 9 16.8V16.75"
                          stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </g>
            </svg>
            <span>Logout</span>
        </div>
    </aside>
    <section class="main-layout space-y-6">
        <div class="dashboard-heading">
            <div>
                <div>
                    <h1><?php echo $contact['title'] . ". " . $contact['firstname'] . " " . $contact['lastname'] ?></h1>
                    <h3 class="subtitle">Created on <?php
                        $date = date_create($contact['created_at']);
                        echo date_format($date, 'F j, Y');
                        ?> by <?php echo $contact['creatorFullName'] ?>
                    </h3>
                    <h3 class="subtitle">
                        Updated on <?php
                        $date = date_create($contact['updated_at']);
                        echo date_format($date, 'F j, Y');
                        ?>
                    </h3>
                </div>
            </div>
            <div class="flex gap-4">
                <?php if ($contact['assigned_to'] !== $_SESSION['user_id']): ?>
                    <button id="assign-to-self-btn">Assign to me</button>
                <?php endif; ?>
                <button id="switch-btn">Switch
                    to <?php echo $contact['type'] === 'Sales Lead' ? 'Support' : 'Sales Lead' ?></button>
            </div>
        </div>
        <div class="default-container grid grid-cols-2 gap-4">
            <div>
                <p class="mini-heading">Email</p>
                <p><?php echo $contact['email'] ?></p>
            </div>
            <div>
                <p class="mini-heading">Telephone</p>
                <p><?php echo $contact['telephone'] ?></p>
            </div>
            <div>
                <p class="mini-heading">Company</p>
                <p><?php echo $contact['company'] ?></p>
            </div>
            <div>
                <p class="mini-heading">Assigned To</p>
                <p><?php echo $contact['assignedFullName'] ?></p>
            </div>
        </div>
        <div class="default-container space-y-6">
            <h3 style="margin-bottom: 4rem;">Notes</h3>
            <div id="notes-container" style="margin-bottom: 4rem;" class="space-y-6">
                <?php foreach ($notes as $note): ?>
                    <div class="note">
                        <h6 class="mini-heading"><?php echo $note['firstname'] . " " . $note['lastname'] ?></h6>
                        <p><?php echo $note['content'] ?></p>
                        <p class="subtitle"><?php
                            $date = date_create($note['created_at']);
                            echo date_format($date, 'F j, Y');
                            ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <form id="note-form" class="space-y-6">
                <label>
                    Add a note about <?php echo $contact['firstname'] ?>
                    <textarea name="note" id="note-textarea" cols="30" rows="10"></textarea>
                </label>
                <button type="submit">Add Note</button>
            </form>
        </div>
    </section>
</main>
<script type="module" src="../../logout-handler.js"></script>
<script type="module" src="contact.js"></script>
</body>
</html>