<?php
$res = $db->query("SELECT achievements.id, achievements.name, achievements.title_{$lang} AS title, (u.id IS NOT NULL) AS is_done FROM achievements
    LEFT JOIN achievements_users u ON u.achievement_id = achievements.id AND u.user_id='{$row_user['id']}'");
while ($row=$db->fetch($res)) {
    $data[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'name' => $row['name'],
        'is_done' => $row['is_done'],
    ];
}