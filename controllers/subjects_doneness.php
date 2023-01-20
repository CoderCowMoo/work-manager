<?php
// import db connection
require 'db_conn.php';
require 'dd.php';
global $conn;
// get all subject data from db
$table = "WORK";
$subjects = ['ucat', 'english', 'software', 'methods', 'chemistry'];
$sql_date = date("Y-m-d");
$query = "SELECT * FROM $table WHERE date = '$sql_date'";

function get_subjects_assoc() : array {
    // 'import' variables from global scope
    global $conn, $sql_date, $subject, $query;

    $result = $conn->query($query);
    $result_assoc = $result->fetch_assoc();
    
    // check if today's record exists
    if ($result->num_rows == 0) {
        // if not, return a zeroed array
        return [
            'ucat' => 0,
            'english' => 0,
            'software' => 0,
            'methods' => 0,
            'chemistry' => 0
        ];
    }
    // if it does, remove the date column/index
    $result_assoc = array_slice($result_assoc, 1, -1);

    return $result_assoc;
}

// error type for php
function set_subjects_assoc($array) {
    // TODO
}
?>