<?php

include ("includes/functions.php");
include ("includes/config.php");

$id = $_SESSION['id'];
echo "Session ID = " . $id . " - ";

//////////////////////////////////////////////////////////////////////////





// the query
$query = "SELECT wk_start FROM timesheet_details WHERE user_id = $id AND wk_start >= DATE(NOW() - INTERVAL 70 DAY)";
$results = $mysqli->query($query);
if(mysqli_num_rows($results) > 0) {
    $last_timesheet = "You've Completed A Timesheet Within The Last Week";
} else {
    $last_timesheet = "You Haven't Completed A Timesheet This Week";
}
?>