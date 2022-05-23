<?php
//allow request from any origin -- for testing only
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/api/v1/', $uri); //split  /api/v1/ part and resource


//endpoint we are using is test
if (!isset($uri[1]) || $uri[1] != 'test') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$request_method = $_SERVER['REQUEST_METHOD'];
$now = date('Y-m-d H:i:s');


if ($request_method === 'GET') {
    http_response_code(200);
    echo json_encode([
        'message' => "Server has received a GET request at $now"]);
} elseif ($request_method === 'POST') {

    //read body data
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $name = $data->name;

    http_response_code(201); //code 201
    echo json_encode([
        'message' => "Server has received a POST request at $now. Name received $name"]);
} elseif ($request_method === 'PATCH') {

    //read body data
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $name = $data->name;

    http_response_code(200); //code 200
    echo json_encode([
        'message' => "Server has received a PATCH request at $now. New name received: $name"]);
} elseif ($request_method === 'DELETE') {
    http_response_code(200);
    echo json_encode([
        'message' => "Server has received a DELETE request at $now"]);
} else {
    http_response_code(405);

    echo json_encode([
        'message' => "Method not allowed at $now"
    ]);
}
