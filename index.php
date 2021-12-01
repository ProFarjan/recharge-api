<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    include_once 'route.php';

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