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

if ($_GET['action'] === 'auth') {
    $request_body = file_get_contents('php://input');
    $request_body = json_decode($request_body, true);

    $email = $db->filter($request_body['email'], 'email');
    $password = md5($request_body['password']);
    $row = $db->get_row("SELECT * FROM users WHERE email='{$email}' AND password='{$password}' LIMIT 1");

    if ($row) {
        // generate new session key for user
        $session_id = md5($email . $password . time());
        $db->update('users', $row['id'], ['session' => $session_id]);

        $data = [
            'session_id' => $session_id,
            'user_name' => $row['name'],
            'user_email' => $row['email'],
        ];
    }
    elseif ($db->get_row("SELECT id FROM users WHERE email='{$email}'") != false) {
        $data = [
            'error' => "Неверный пароль.",
        ];
    }
    else {
        $data = [
            'error' => "Пользователь с email {$email} не найден.",
        ];
    }
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($data);