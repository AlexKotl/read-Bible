<?php
include "db_config.php";
include "classes/class_mysql.php";

$db = new CMysql();

// uncomment to use parser
// include "parser.php";

$data = [];
if ($_GET['action'] === 'chapters') {
    $res = $db->query("SELECT books.name, chapters.number, chapters.id FROM chapters
        LEFT JOIN books ON books.id = chapters.book_id
        ORDER BY chapters.id") or die($db->error());
    while ($row = $db->fetch($res)) {
        $data[$row['name']][] = [
            'id' => $row['id'],
            'number' => $row['number'],
        ];
    }
}

if ($_GET['action'] === 'chapter') {
    $id = (int)$_GET['id'];
    $res = $db->query("SELECT * FROM verses WHERE chapter_id='{$id}'") or die($db->error());
    while ($row = $db->fetch($res)) {
        $data[] = [
            'number' => $row['number'],
            'text' => $row['content'],
        ];
    }
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($data);