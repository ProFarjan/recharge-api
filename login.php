<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include_once 'Lib.php';

$_POST = json_decode(file_get_contents('php://input'),true); //changes

if (isset($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $lib = new Lib();

    if ($res = $lib->login($_POST)) {
        echo (json_encode([
            'status' => 'success',
            'message' => $res
        ]));
    } else {
        echo (json_encode([
            'status' => 'failure',
            'message' => 'Username or password can not match!'
        ]));
    }
} else {
    echo json_encode([
        'status' => 'failure',
        'message' => 'Please Enter Valid Username & Password!'
    ]);
}