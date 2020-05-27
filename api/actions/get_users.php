<?php
$res = $db->query("SELECT users.id, users.name, users.picture, COUNT(DISTINCT au.id) as achievements_count, COUNT(DISTINCT uc.id) as chapters_count FROM users
    LEFT JOIN achievements_users au ON au.user_id = users.id
    LEFT JOIN users_chapters uc ON uc.user_id = users.id
    GROUP BY users.id
    ORDER BY achievements_count DESC, chapters_count DESC");
while ($row=$db->fetch($res)) {
    $data[] = $row;
}