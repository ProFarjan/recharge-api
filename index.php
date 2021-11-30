<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    header("Access-Control-Allow-Headers: Content-Type, Authorization");


    $_POST = json_decode(file_get_contents("php://input"),true);
    $headers = getallheaders();

    if (isset($_GET) && !empty($_GET['path'])) {


    } elseif (isset($_POST) && !empty($_POST)) {


    }
