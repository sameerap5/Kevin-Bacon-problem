<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "project_1";

//Create connection
$conn = new mysqli($servername, $username, $password, $database);

//Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);

   }else
   {
//echo "Database Connected successfully";
}

?>
