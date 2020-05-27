<?php
include "../vendor/autoload.php";
include "config.php";
include "classes/class_mysql.php";

$db = new CMysql();

// uncomment to use parser
// include "parser.php";

$data = [];

if (in_array($_GET['lang'], ['en', 'ua', 'ru'])) {
    $lang = $_GET['lang'];
}
else {
    $lang = 'ru';
}

if (isset($_GET['session_id'])) {
    $session_id = $db->filter($_GET['session_id']);
    $row_user = $db->get_row("SELECT id, name, email, session FROM users WHERE session='{$session_id}'");
}

if ($_GET['action'] === 'chapters') {
    $user_id = (int)$db->get_row("SELECT id FROM users WHERE session='".$db->filter($_GET['session_id'])."' LIMIT 1");

    $res = $db->query("SELECT books.name_{$lang} as name, chapters.number, chapters.id, users_chapters.is_read FROM chapters
        LEFT JOIN books ON books.id = chapters.book_id
        LEFT JOIN users_chapters ON users_chapters.user_id = '{$user_id}' AND users_chapters.chapter_id = chapters.id
        ORDER BY chapters.id") or die($db->error());
    while ($row = $db->fetch($res)) {
        $data[$row['name']][] = [
            'id' => $row['id'],
            'number' => $row['number'],
            'is_read' => (int)$row['is_read'],
        ];
    }
}

if ($_GET['action'] === 'chapter') {
    $id = (int)$_GET['id'];
    $res = $db->query("SELECT * FROM verses WHERE chapter_id='{$id}' AND lang='{$lang}' ORDER BY number") or die($db->error());
    while ($row = $db->fetch($res)) {
        $data['verses'][] = [
            'number' => $row['number'],
            'text' => $row['content'],
        ];
    }
    $row_chapter = $db->get_row("SELECT * FROM chapters WHERE id='{$id}'");
    $data['chapter'] = [
        'number' => $row_chapter['number'],
        'book_name' => $db->get_row("SELECT name_{$lang} as name FROM books WHERE id='{$row_chapter['book_id']}'"),
        'next_id' => $db->get_row("SELECT id FROM chapters WHERE id>{$id} ORDER BY id LIMIT 1"),
        'prev_id' => $db->get_row("SELECT id FROM chapters WHERE id<{$id} ORDER BY id DESC LIMIT 1")
    ];
}

if ($_GET['action'] === 'auth') {
    include "actions/auth.php";
}

if ($_GET['action'] === 'verify_session') {
    if ($row_user !== false) {
        $data = [
            'session_id' => $row_user['session'],
            'user_name' => $row_user['name'],
            'user_email' => $row_user['email'],
        ];
    }
    else {
        $data['error'] = "No user found with session {$_GET['session_id']}.";
    }
}

if ($_GET['action'] === 'register') {
    $request_body = file_get_contents('php://input');
    $request_body = json_decode($request_body, true);

    $email = $db->filter($request_body['email'], 'email');
    $name = $db->filter($request_body['name']);
    $password = md5($request_body['password']);

    if ($db->get_row("SELECT * FROM users WHERE email='{$email}'") !== false) {
        $data['error'] = "Пользователь с таким Email уже зарегистрирован.";
    }
    else {
        $db->insert("users", [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'session' => md5($email . $password),
        ]);

        $row_user = $db->get_row("SELECT * FROM users WHERE id='" . $db->last_insert_id('users') . "'");
        $data = [
            'session_id' => $row_user['session'],
            'user_name' => $row_user['name'],
            'user_email' => $row_user['email'],
        ];
    }
}

if ($_GET['action'] === 'mark_read') {
    $chapter_id = (int)$_GET['chapter_id'];
    $is_read = (int)$_GET['is_read'];
    $session_id = $db->filter($_GET['session_id']);
    $user_id = $db->get_row("SELECT id FROM users WHERE session='{$session_id}' LIMIT 1");

    if ($user_id ==0 || $session_id == '') {
        $data['error'] = "Can't verify user credentials.";
    }
    else {
        if ($db->get_row("SELECT * FROM users_chapters WHERE user_id='{$user_id}' AND chapter_id='{$chapter_id}'") === false) {
            $db->insert('users_chapters', [ 'user_id' => $user_id, 'chapter_id' => $chapter_id ]);
        }

        $db->query("UPDATE users_chapters SET is_read='{$is_read}' WHERE user_id='{$user_id}' AND chapter_id='{$chapter_id}'");

        $data['code'] = 200;

        include "actions/check_achievements.php";
    }
}

if ($_GET['action'] === 'statistics' && $row_user['id'] > 0) {
    include "actions/statistics.php";
}

if ($_GET['action'] === 'get_achievements') {
    include "actions/get_achievements.php";
}
if ($_GET['action'] === 'check_achievements') {
    include "actions/check_achievements.php";
}
if ($_GET['action'] === 'get_users') {
    include "actions/get_users.php";
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($data);