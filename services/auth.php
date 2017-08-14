<?php

function auth_create_token($username, $password) {
    global $db;
    $hashPass = sha1($password);

    $stmt = $db->query("select * from users where username = '$username' and password = '$hashPass' limit 1");
    $first = $stmt->fetch_assoc();

    if ($first) {
        $token = md5($username . microtime());

        $stmt = $db->query("update users set token = '$token' where username = '$username' and password = '$hashPass'");

        return json_encode(array(
            'token' => $token
        ));
    }
    else {
        http_response_code(400);
        return json_encode(array(
            'error' => 'Bad credentials'
        ));
    }
}

function register($email, $username, $password) {
    global $db;
    $hashPass = sha1($password);

    $stmt = $db->query("INSERT INTO `users` (email, username, `password`) VALUES ('$email', '$username', '$hashPass')");

    if($stmt) {
        return auth_create_token($username, $password);
    }
    else {
        http_response_code(400);
        return json_encode(array(
            'error' => 'Bad credentials'
        ));
    }
}

$checkIfAuth = function($token) {
    global $db;
    $stmt = $db->query("select * from users where token = '$token' limit 1");
    $first = $stmt->fetch_assoc();

    if ($first) {
        return true;
    }
    else {
        return false;
    }
};

function getUser($token) {
    global $db;
    $stmt = $db->query("select id from users where token = '$token'");
    $id = $stmt->fetch_assoc()['id'];

    return $id;
};
