<?php

function select($username, $password, $dbname, $table, $where) {
    $res = [];
    $conn = new mysqli("localhost", $username, $password, $dbname);
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

        $conn->close();
        return $res;
    }
}
