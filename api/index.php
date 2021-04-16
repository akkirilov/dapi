<?php

function authenticate($user, $pass) {
    return ['error' => false];
}

function getHandler($user, $pass, $db, $table, $queryString) {
    include_once('config.php');
    include_once($DB_HANDLER);

    $where = parseQueryString($queryString);

    $res = select($user, $pass, $db, $table, $where, $DB_HOST, $DB_PORT);

    echo json_encode($res);

    return;
}



// function postHandler() {
//     var_dump($_SERVER['REQUEST_URI']);

// }

// function putHandler() {
//     var_dump($_SERVER['REQUEST_URI']);

// }

// function patchHandler() {
//     var_dump($_SERVER['REQUEST_URI']);

// }

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
        getHandler($user, $pass, $db, $table, $_SERVER['QUERY_STRING']);
        break;
    case 'POST':
        # code...
        break;
    case 'PUT':
        # code...
        break;
    case 'PATCH':
        # code...
        breagetHandlerk;
    case 'DELETE':
        # code...
        break;
    default:
        # code...
        break;
}
