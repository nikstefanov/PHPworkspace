<?php 
// start buffering the output 
ob_start();
// output format – either "www" or "file"
$output = "file";
// send some output
?>
<html>
	<head>
		<basefont face="Arial">
	</head>
	<body>
		<?
		// open connection to database
		$connection = mysql_connect("localhost", "joe", "nfg84m") or die ("Unable to connect!");
		mysql_select_db("weather") or die ("Unable to select database!");
		// get data
		$query = "SELECT * FROM weather";
		$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
		// if a result is returned
		if (mysql_num_rows($result) > 0) {
			// iterate through resultset
			// print data
			while (list($temp, $forecast) = mysql_fetch_row($result)) {
				echo "Outside temperature is $temp";
				echo "<br>"; echo "Forecast is $forecast"; echo "<p>"; 
			}
		} else { echo "No data available"; }
		// close database connection
		mysql_close($connection);
		// send some more output
		?>
	</body>
</html>
<?php
// now decide what to do with the buffered output
if ($output == "www") {
	// either print the contents of the buffer…
	ob_end_flush();
} else {
	// … or write it to a file
	$data = ob_get_contents();
	$fp = fopen ("weather.html", "w");
	fwrite($fp, $data);
	fclose($fp);
	ob_end_clean();
}
?> 