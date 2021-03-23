<?php
//get the post variables
$value = $_POST['value'];
$unit = $_POST['unit'];
$column = $_POST['column'];
//connect to the database
$con=mysqli_connect("localhost","id15571246_laukik","4#-K1Qk((EITugaM","id15571246_esp8266");// server, user, pass, database

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
//update the value
mysqli_query($con,"UPDATE ESP_1 SET $column = '{$value}'
WHERE id=$unit");
//echo "changed";




//go back to the interface
header("location: interface.php");



    ?>