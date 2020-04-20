<?php

if (!$row_user) {
    die("User auth failed");
}

$res = $db->query("SELECT * FROM achievements");
while ($row = $db->fetch($res)) {
    // Read one chapter
    if ($row['name'] === 'first_chapter') {
        $count = $db->get_row("SELECT COUNT(*) FROM users_chapters WHERE user_id='{$row_user['id']}' AND is_read='1'");
        if ($count > 0) {
            $data[] = [
                'title' => $row['title_ru'],
            ];
        }
    }

    // Read one book
    if ($row['name'] === 'first_book') {

    }

    // 7 days of reading
    if ($row['name'] === '7_days') {

    }

    // 30 days of reading
    if ($row['name'] === '30_days') {

    }
}

$data = [];