<?php

$data = [
    'read_chapters' => (int)$db->get_row("SELECT count(*) FROM users_chapters WHERE user_id='{$row_user['id']}' AND is_read=1"),
    'total_chapters' => (int)$db->get_row("SELECT count(*) FROM chapters"),
    'read_chars' => (int)$db->get_row("SELECT SUM(chapters.chars) FROM users_chapters
        LEFT JOIN chapters ON chapters.id=users_chapters.chapter_id
        WHERE users_chapters.user_id='{$row_user['id']}' AND users_chapters.is_read=1"),
    'total_chars' => (int)$db->get_row("SELECT SUM(chars) FROM chapters"),
    'total_users' => (int)$db->get_row("SELECT count(*) FROM users"),
    'total_users_chapters' => (int)$db->get_row("SELECT count(*) FROM users_chapters"),
];

// get data per past month
$res = $db->query("SELECT DATE(users_chapters.date_created) as date, SUM(chapters.chars) as chars, COUNT(DISTINCT users_chapters.id) as chapters FROM users_chapters
    LEFT JOIN chapters ON chapters.id=users_chapters.chapter_id
    WHERE users_chapters.date_created > CURRENT_DATE - INTERVAL 1 MONTH AND users_chapters.user_id='{$row_user['id']}' AND users_chapters.is_read=1
    GROUP BY date");
while ($row = $db->fetch($res)) {
    $data['by_month'][$row['date']] = [
        'chars' => (int)$row['chars'],
        'chapters' => (int)$row['chapters'],
    ];
}

// get achievements stats
$res = $db->query("SELECT achievements.id, achievements.name, achievements.title_{$lang} AS title, (u.id IS NOT NULL) AS is_done FROM achievements
    LEFT JOIN achievements_users u ON u.achievement_id = achievements.id AND u.user_id='{$row_user['id']}'
    LIMIT 10");
while ($row=$db->fetch($res)) {
    $data['achievements'][] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'name' => $row['name'],
        'is_done' => $row['is_done'],
    ];
}