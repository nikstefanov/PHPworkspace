<?php
$con=mysqli_connect("localhost:3306","root","123","classicmodels");

// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM offices
WHERE 0=0");

while($row = mysqli_fetch_array($result)) {
	echo $row['city'] . " " . $row['country'];
	echo "\r\n";
}

mysqli_close($con);