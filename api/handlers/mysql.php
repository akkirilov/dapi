<?php

function parseQueryString($queryString) {
    $res = "";
    if (empty($queryString) || strpos($queryString, ";") > -1) {
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