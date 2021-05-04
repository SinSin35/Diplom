<?php
$dbServername = "localhost";
$dbUsername="root"; 
$dbPassword="";
$dbName="kursor";

$conn=mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);

if (!$conn){
	die("Connection failed: ".mysqli_connect_error());
}

$sql="SET NAMES 'utf8mb4';";	//решение проблем с кодировкой
mysqli_query($conn,$sql);

?>