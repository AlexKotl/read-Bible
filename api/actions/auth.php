<?php
$data = [];

$request_body = file_get_contents('php://input');
$request_body = json_decode($request_body, true);

$email = $db->filter($request_body['email'], 'email');
$password = md5($request_body['password']);

// Auth by Google
if ($request_body['apple_user_id']) {
    $user_id = $request_body['apple_user_id'];
    $email = $request_body['email'];
    $name = $request_body['name'];

    if (!$email) {
        $email = $user_id;
    }

    $row = $db->get_row("SELECT * FROM users WHERE email='{$email}' LIMIT 1");

    // register if user not exists
    if (!$row) {
        $db->insert('users', [
            'name' => $name,
            'email' => $email,
            'picture' => '',
            'flag' => 1,
        ]);
        $row = $db->get_row("SELECT * FROM users WHERE email='{$email}' LIMIT 1");
    }
}
elseif ($request_body['code'] || $request_body['token']) {
    $client = new Google_Client();
    $client->setClientId($google_client_id);
    $client->setClientSecret($google_secret);
    $client->setRedirectUri('postmessage');
    $client->addScope("email");
    $client->addScope("profile");

    if ($request_body['code']) {
        $token = $client->fetchAccessTokenWithAuthCode($request_body['code']);
    }
    else {
        $token['access_token'] = $request_body['token'];
    }

    // login with Google OAuth2
    if ($token['access_token']) {
        $client->setAccessToken($token['access_token']);
        $service = new Google_Service_Oauth2($client);
        $user = $service->userinfo->get();

        $row = $db->get_row("SELECT * FROM users WHERE email='{$user->email}' LIMIT 1");

        // check for updated fields
        if ($row['name'] != $user->name || $row['picture'] != $user->picture) {
            $db->update('users', $row['id'], [
                'name' => $user->name,
                'picture' => $user->picture,
            ]);
        }

        // register if user not exists
        if (!$row) {
            $db->insert('users', [
                'name' => $user->name,
                'email' => $user->email,
                'picture' => $user->picture,
                'flag' => 1,
            ]);
            $row = $db->get_row("SELECT * FROM users WHERE email='{$user->email}' LIMIT 1");
        }
    }
    else {
        $data['error'] = "Не могу получить access_token: " . $token['error'];
    }



}
else {
    $row = $db->get_row("SELECT * FROM users WHERE email='{$email}' AND password='{$password}' LIMIT 1");
}



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
    $data['error'] = "Неверный пароль.";
}
elseif ($email != '') {
    $data['error'] = "Пользователь с email {$email} не найден.";
}
elseif (!$data['error']) {
    $data['error'] = "Ошибка авторизации.";
}