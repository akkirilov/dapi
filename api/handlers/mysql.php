<?php

function parseQueryString($queryString) {
    $res = "";
    if (empty($queryString) || empty(strpos($queryString, ";"))) {
        return $res;
    }
    
    $params = explode("&", $queryString);
    $len = count($params);
    for ($i = 0; $i < $len; $i++) { 
        $tokens = explode("=", $params[$i]);
        if (is_numeric($tokens[1])) {
            if (strpos($queryString, ".gt") > -1) {
                $res .= substr($tokens[0], 0, -3) . ">" . $tokens[1];
            } else if (strpos($queryString, ".lt") > -1) {
                $res .= substr($tokens[0], 0, -3) . "<" . $tokens[1];
            } else {
                $res .= $tokens[0] . "=" . $tokens[1];
            }
        } else {
            $res .= $tokens[0] . "='" . $tokens[1] . "'";
        }

        if ($i < ($len - 1)) {
            $res .= " AND ";
        }
    }

    return $res;
}

function parseBodyKeys($body) {
    $columns = [];
    foreach($body as $k => $v){
        if (empty(strpos($k, ";"))) {
            $columns[] = $k;
        }
    }

    return $columns;
}

function parseBodyValues($body) {
    $values = [];
    foreach($body as $k => $v){
        if (empty(strpos($v, ";"))) {
            if (is_numeric($v[1])) {
                $values[] = $v;
            } else {
                $values[] = "'" . $v . "'";
            }
        }
    }

    return $values;
}

function select($username, $password, $dbname, $table, $where, $host, $port) {
    $res = [];

    $conn = new mysqli($host, $username, $password, $dbname, $port);
    if ($conn->connect_error) {
        $res['error'] = true;
        $res['msg'] = "Connection failed: " . $conn->connect_error;
    } else {
        $sql = "SELECT * FROM " . $table;
        if ($where == NULL || empty($where)) {
            $sql .= ";";
        } else {
            $sql .= " WHERE " . $where . ";";
        }
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $res['data'] = [];
            while($row = $result->fetch_assoc()) {
                $res['data'][] = $row;
            }
        } else {
            $res['error'] = true;
            $res['msg'] = "No results.";
        }

    }

    $conn->close();

    return $res;
}

function post($username, $password, $dbname, $table, $body, $host, $port) {
    $res = [];

    $columns = parseBodyKeys($body);
    $values = parseBodyValues($body);

    if (count($columns) != count($values)) {
        $res['error'] = true;
        $res['msg'] = "Body is incorrect!";
        return $res;
    }

    $sql = "INSERT INTO " . $table . "(" . implode(",", $columns) . ") VALUES (" . implode(",", $values) . ");";
    $conn = new mysqli($host, $username, $password, $dbname, $port);
    if ($conn->connect_error) {
        $res['error'] = true;
        $res['msg'] = "Connection failed: " . $conn->connect_error;
    } else {
        if ($conn->query($sql) === TRUE) {
            $res['msg'] = "New record created successfully";
        } else {
            $res['error'] = true;
            $res['msg'] = "Error in " . $sql . " Caused by: " . $conn->error;
        }
    }

    $conn->close();

    return $res;
}
