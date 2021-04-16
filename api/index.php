<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, POST, PUT');


function getPostBody()
{
    if (!empty($_POST)) {
        // when using application/x-www-form-urlencoded or multipart/form-data as the HTTP Content-Type in the request
        // NOTE: if this is the case and $_POST is empty, check the variables_order in php.ini! - it must contain the letter P
        return $_POST;
    }

    // when using application/json as the HTTP Content-Type in the request 
    $post = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() == JSON_ERROR_NONE) {
        return $post;
    }

    return [];
}

function authenticate($user, $pass) {
    return ['error' => false];
}

function handleGetRequest($user, $pass, $db, $table, $queryString) {
    include_once('config.php');
    include_once($DB_HANDLER);

    $where = parseQueryString($queryString);

    $res = select($user, $pass, $db, $table, $where, $DB_HOST, $DB_PORT);

    echo json_encode($res);

    return;
}

function handlePostRequest($user, $pass, $db, $table) {
    include_once('config.php');
    include_once($DB_HANDLER);

    $body = getPostBody();

    $res = post($user, $pass, $db, $table, $body, $DB_HOST, $DB_PORT);
    echo json_encode($res);

    return;
}

$uriParams = explode("/", explode("?", $_SERVER['REQUEST_URI'])[0]);
array_shift($uriParams);

$user = $uriParams[0];
$pass = $uriParams[1];
array_shift($uriParams);
array_shift($uriParams);

if (authenticate($user, $pass)['error']) {
    echo "404";
    return;
}

$db = $uriParams[0];
$table = $uriParams[1];
array_shift($uriParams);
array_shift($uriParams);

// echo "<pre>" . print_r(
//     array($_SERVER['REQUEST_METHOD'], 
//             $_SERVER['REQUEST_URI'], 
//             $_SERVER['QUERY_STRING'])) . "</pre>";

// echo "<pre>" . print_r($uriParams) . "</pre>";
// // echo $_SERVER['QUERY_STRING'];
// return;


switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        handleGetRequest($user, $pass, $db, $table, $_SERVER['QUERY_STRING']);
        break;
    case 'POST':
        handlePostRequest($user, $pass, $db, $table);
        break;
    case 'PUT':
        # code...
        break;
    case 'PATCH':
        # code...
    case 'DELETE':
        # code...
        break;
    default:
        # code...
        break;
}
