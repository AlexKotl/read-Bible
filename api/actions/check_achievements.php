<?php

// record achievement
function achieve($data) {
    global $row_user, $db;
    if ($db->get_row("SELECT * FROM achievements_users WHERE achievement_id='{$data['id']}' AND user_id='{$row_user['id']}'")) {
        return false;
    }
    $db->insert('achievements_users', [
        'achievement_id' => $data['id'],
        'user_id' => $row_user['id'],
    ]);

    return [
        'id' => $data['id'],
        'name' => $data['name'],
        'title' => $data['title_ru'],
    ];
}

if (!$row_user) {
    die("User auth failed");
}

$data = [];

$res_ach = $db->query("SELECT * FROM achievements");
while ($row_ach = $db->fetch($res_ach)) {
    // Read one chapter
    if ($row_ach['name'] === 'first_chapter') {
        $count = $db->get_row("SELECT COUNT(*) FROM users_chapters WHERE user_id='{$row_user['id']}' AND is_read='1'");
        if ($count > 0) {
            $data[] = achieve($row_ach);
        }
    }

    // Read one book
    if ($row_ach['name'] === 'first_book') {
        $whole_chapters_count = $db->get_row("SELECT COUNT(*) FROM (
            SELECT books.*, count(DISTINCT chapters.id) AS chapters_count, count(DISTINCT users_chapters.id) AS user_count  FROM books
            LEFT JOIN chapters ON chapters.book_id=books.id
            LEFT JOIN users_chapters ON chapters.id=users_chapters.chapter_id AND users_chapters.user_id='{$row_user['id']}' AND users_chapters.is_read=1
            GROUP BY books.id
        ) subtable WHERE user_count = chapters_count");

        if ($whole_chapters_count > 0) {
            $data[] = achieve($row_ach);
        }
    }

    // get list of longest days streak when user readed
    $longest = $current = 1;
    $res = $db->query("SELECT *, DATE(date_created) as date FROM users_chapters
        WHERE users_chapters.user_id='{$row_user['id']}' AND users_chapters.is_read=1
        ORDER BY date");
    while ($row = $db->fetch($res)) {
        if (!$prev) {
            $prev = $row;
            continue;
        }

        $days_passed = date_diff(date_create($row['date']), date_create($prev['date']))->days;
        if ($days_passed === 1) {
            $current++;
        }
        elseif ($days_passed > 1) {
            if ($longest < $current) {
                $longest = $current;
            }
            $current = 1;
        }

        $prev = $row;
    }

    // 7 days of reading
    if ($row_ach['name'] === '7_days') {
        if ($longest >= 7) {
            $data[] = achieve($row_ach);
        }
    }

    // 30 days of reading
    if ($row_ach['name'] === '30_days') {
        if ($longest >= 30) {
            $data[] = achieve($row_ach);
        }
    }
}

