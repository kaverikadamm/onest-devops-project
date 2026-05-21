<?php
// Database connection
$hname = 'host.docker.internal';
$uname = 'root';
$pass = '';
$db = 'RadhaFarm';
$port='3307';

$con = mysqli_connect($hname, $uname, $pass, $db,$port);
if (!$con) {
    die("Cannot connect to database: " . mysqli_connect_error());
}

// Database connection ended

/**
 * Sanitize input data to prevent XSS and SQL injection.
 *
 * @param array $data
 * @return array
 */
function filteration($data) {
    foreach($data as $key => $value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        $data[$key] = $value;
    }
    return $data;
}

/**
 * Execute a SELECT query with parameters.
 *
 * @param string $sql
 * @param array $values
 * @param string $datatypes
 * @return mysqli_result
 */
function select($sql, $values, $datatypes) {
    global $con; // Use global connection variable
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Select: " . mysqli_error($con));
        }
    } else {
        die("Query cannot be prepared - Select: " . mysqli_error($con));
    }
}

/**
 * Execute a SELECT * query on a specified table.
 *
 * @param string $table
 * @return mysqli_result
 */
function selectAll($table) {
    global $con; // Use global connection variable
    $res = mysqli_query($con, "SELECT * FROM $table");
    if (!$res) {
        die("Query cannot be executed - Select All: " . mysqli_error($con));
    }
    return $res;
}

/**
 * Execute an UPDATE query with parameters.
 *
 * @param string $sql
 * @param array $values
 * @param string $datatypes
 * @return int
 */
function update($sql, $values, $datatypes) {
    global $con; // Use global connection variable
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Update: " . mysqli_error($con));
        }
    } else {
        die("Query cannot be prepared - Update: " . mysqli_error($con));
    }
}

/**
 * Execute an INSERT query with parameters.
 *
 * @param string $sql
 * @param array $values
 * @param string $datatypes
 * @return int
 */
function insert($sql, $values, $datatypes) {
    global $con; // Use global connection variable
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Insert: " . mysqli_error($con));
        }
    } else {
        die("Query cannot be prepared - Insert: " . mysqli_error($con));
    }
}

/**
 * Execute a DELETE query with parameters.
 *
 * @param string $sql
 * @param array $values
 * @param string $datatypes
 * @return int
 */
function delete($sql, $values, $datatypes) {
    global $con; // Use global connection variable
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Delete: " . mysqli_error($con));
        }
    } else {
        die("Query cannot be prepared - Delete: " . mysqli_error($con));
    }
}

function get_safe_value($con,$str){
	if($str!=''){
		$str=trim($str);
		return mysqli_real_escape_string($con,$str);
	}
}

