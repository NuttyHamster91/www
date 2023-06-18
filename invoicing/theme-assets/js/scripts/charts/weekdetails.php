<?php
session_start();
include_once("../../../../includes/config.php");
// DATA FOR CHART.JS //
//query to get data from the table
$id = $_SESSION['id'];
$query = "SELECT user_id, wk_start, sum_hours FROM timesheet_details WHERE user_id = $id";
//execute query
$result = $mysqli->query($query);
//loop through the returned data
$data = array();
foreach ($result as $row) {
$data[] = $row;
}
//close connection
$mysqli->close();

//now print the data
print json_encode($data);
?>