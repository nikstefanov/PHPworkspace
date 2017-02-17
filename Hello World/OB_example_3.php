<?php
// user-defined output handler
function myOutputHandler($buf) {
	global $output;
	// either dump the buffer to a file
	if ($output != “www”) {
		$fp = fopen (“weather.html”, “w”);
		fwrite($fp, $buf);
		fclose($fp);
	}
	// … or return it for printing to the browser
	else { return $buf; }
}
// start buffering the output
// specify the callback function
ob_start(“myOutputHandler”);
// output format – either “www” or “file”
$output = “www”;
// send some output
?>
<html>
	<head><basefont face=”Arial”></head>
	<body>
		<?
		// open connection to database
		$connection = mysql_connect(“localhost”, “joe”, “nfg84m”) or die (“Unable to connect!”);
		mysql_select_db(“weather”) or die (“Unable to select database!”);
		// get data
		$query = “SELECT * FROM weather”;
		$result = mysql_query($query) or die (“Error in query: $query. ” . mysql_error());
		// if a result is returned
		if (mysql_num_rows($result) > 0) {
			// iterate through resultset
			// print data
			while (list($temp, $forecast) = mysql_fetch_row($result)) {
				echo “Outside temperature is $temp”;
				echo “<br>”;
				echo “Forecast is $forecast”; echo “<p>”;
			}
		} else { echo “No data available”; }
		// close database connection
		mysql_close($connection);
		// send some more output
		?>
	</body>
</html>
<?php
// end buffering
// this will invoke the user-defined callback
ob_end_flush();
?> 