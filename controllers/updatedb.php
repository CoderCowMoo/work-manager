<?php
header("Access-Control-Allow-Origin: *");
require 'dd.php';
require 'db_conn.php';
global $conn;
/*
* This php file will update the database by either inserting a new row for a new day
* or updating an existing row for the current day. Subject states should be passed by
* POST request.
*/

// we'll wrap this in a try catch in case client sends BS.

try {
    var_dump($_POST, $_GET);
    if (empty($_GET)) {
        throw new Exception("No data sent");
    }
    // first we'll check if a record exists for today
    $sql_date = date("Y-m-d");
    $date_query = "SELECT * FROM WORK WHERE date = '$sql_date'";
    $result = $conn->query($date_query);
    if ($result->num_rows != 0) {
        // so today's record exists, we'll update it
        $update_query = "UPDATE WORK SET ";
        // add each subject to the query
        foreach ($_GET as $subject => $doneness) {
            $update_query .= "$subject = $doneness, ";
        }
        // make sure to remove the last comma
        $update_query = substr($update_query, 0, -2);
        // make sure to add to the correct row
        $update_query .= " WHERE date = '$sql_date'";
        var_dump($update_query);
        $conn->query($update_query);
        // done now so return a success code of 201: (Created)
        http_response_code(201);
        die();
    }

    // so record doesn't exist
    $insert_query = "INSERT INTO WORK (date, ";
    // add each subject to the query
    foreach ($_GET as $subject => $doneness) {
        $insert_query .= "$subject, ";
    }
    // make sure to remove the last comma
    $insert_query = substr($insert_query, 0, -2);
    // add the values
    $insert_query .= ") VALUES ('$sql_date', ";
    foreach ($_GET as $subject => $doneness) {
        $insert_query .= "$doneness, ";
    }
    // make sure to remove the last comma
    $insert_query = substr($insert_query, 0, -2);
    $insert_query .= ")";

    $conn->query($insert_query);
    // done now so return a success code of 201: (Created)
    http_response_code(201);
    die();
}

// pretty much no matter the Exception, we'll return a 400: (Bad Request)
catch (Exception $ex) {
    // return a 400: (Bad Request)
    http_response_code(400);
    print $ex->getMessage();
    die();
}

