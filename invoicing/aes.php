<?php
//include_once("includes/header.php");
//include_once("includes/navbar.php");
include_once("includes/functions.php");
session_start();
//include_once("includes/config.php");

/////// SET PAGE TITLE ////////
$PT = "Main Settings";

?>


<?php 

//Data to encrypt 
$data = "7 Redavon Rise"; 
$id = "16";



// Generate encryption key
$encryption_key = generateRandomString(); 
// Use openssl_encrypt() function to encrypt the data
$encryption = openssl_encrypt($data, $cipher,
            $encryption_key, $options, $encryption_iv);
  




////// DISPLAY STUFF ///////////////////////////////////////////
// Display the encrypted string
echo "Encrypted String: " . $encryption . "<br><br><br>";
echo "Encrypted key: " . $encryption_key . "<br><br><br>"; 





/////// INSERT INTO SQL ///////
$sql = "INSERT INTO `user_details` (id, addressl1, addressl2, addressl3, postcode, mobile, ni_no, utr_no, cis_rate, vat_rate, pay_rate, salary, srt, acct, k1) 
VALUES ('$id', '$encryption', '234234', '234234', '234234', '234234', '234234', '234234', '0.20', '0.20', '234234', '234234', '234234', '234234', '$encryption_key')";

if ($mysqli->query($sql) === TRUE) {
  echo "New record created successfully <br><br><br>";
} else {
  echo "Error: " . $sql . "<br><br><br>" . $conn->error . "<br><br><br>";
}



////////// RETRIEVE FROM SQL /////////////
$sql = "SELECT * FROM user_details WHERE user_id= $id";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
/// Get K1 Value
$k1 = $row['k1'];



$adl1 = $row['addressl1']; ////ADDRESS LINE 1 ONLY



//////// DECRYPT DATA FROM DB ////////////
$decdata = openssl_decrypt ($adl1, $cipher, $k1, $options, $encryption_iv);




///////// DISPLAY DATA ////////////
echo $adl1 . '<-- ADL1 in DB<br><br><br>';
echo $decdata . '<-- decrypted from DB';







//////// TEST AREA /////////////////////////////////////////////////////////////////////////////////////////////////////////////


?>

<html>
<head>
   <title> Example- add rows to a table using JavaScript DOM </title>
   <style>
      table,
      td,
      th {
         border: 1px solid black;
      }
   </style>
</head>
<body>
   <h2> Adding rows to a table using JavaScript DOM </h2>
   <p> Click on the button to add the row to the table </p>
   <button id="btn" onclick="addRow()"> Click me </button>
   <br><br>
   <table id="timesheet_table">
      <thead>
         <th> Name </th>
         <th> Age </th>
         <th> City </th>
      </thead>
      <tbody>
         <tr>
            <td> Alex </td>
            <td> 20 </td>
            <td> New York </td>
         </tr>
         <tr>
            <td> Tim </td>
            <td> 18 </td>
            <td> Boston </td>
         </tr>
         <tr>
            <td> Mark </td>
            <td> 23 </td>
            <td> San Diego </td>
         </tr>
      </tbody>
   </table>
</body>
<script>
   function addRow() {
      // Get the table element in which you want to add row
      let table = document.getElementById("timesheet_table");
   
      // Create a row using the inserRow() method and
      // specify the index where you want to add the row
      let row = table.insertRow(-1); // We are adding at the end
   
      // Create table cells
      let c1 = row.insertCell(0);
      let c2 = row.insertCell(1);
      let c3 = row.insertCell(2);
   
      // Add data to c1 and c2
      c1.innerText = "Elon"
      c2.innerText = 45
      c3.innerText = "Houston"
   }
</script>
</html>

<? 
include_once("includes/footer.php");?>