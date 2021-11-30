<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$_POST = json_decode(file_get_contents("php://input"),true);

echo json_encode($_POST);

if (isset($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {

    print_r($_POST);

}