<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    include_once 'route.php';

    $headers = getallheaders();
    if (!array_key_exists('Authorization', $headers)) {
        echo json_encode(['status' => 'failure', 'message' => 'Authorization not found!']);
        return;
    }
    $getAuth = getToken(trim($headers['Authorization'], 'Bearer '));
    if ($getAuth != true) {
        echo $getAuth;
    } else {
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                postRequest ();
                break;
            case 'GET':
                getRequest ();
                break;
            case 'DELETE':
                deleteRequest ();
                break;
            case 'PUT':
                putRequest ();
                break;
        }
    }