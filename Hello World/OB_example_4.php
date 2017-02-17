<?php
// use an output buffer to store page contents
ob_start();
?>
<html>
	<head><basefont face=”Arial”></head>
	<body>
		<h2>News</h2>
		<?php
		// custom error handler
		function e($type, $msg, $file, $line) {
			// read some environment variables
			// these can be used to provide some additional debug information
			global $HTTP_HOST, $HTTP_USER_AGENT, $REMOTE_ADDR, $REQUEST_URI;
			// define the log file
			$errorLog = “error.log”;
			// construct the error string
			$errorString = “Date: ” . date(“d-m-Y H:i:s”, mktime()) . “n”;
			$errorString .= “Error type: $typen”;
			$errorString .= “Error message: $msgn”; $errorString .= “Script: $file($line)n”;
			$errorString .= “Host: $HTTP_HOSTn”;
			$errorString .= “Client: $HTTP_USER_AGENTn”;
			$errorString .= “Client IP: $REMOTE_ADDRn”;
			$errorString .= “Request URI: $REQUEST_URInn”;
			// log the error string to the specified log file
			error_log($errorString, 3, $errorLog);
			// discard current buffer contents
			// and turn off output buffering
			ob_end_clean();
			// display error page
			echo “<html><head><basefont face=Arial></head><body>”;
			echo “<h1>Error!</h1>”;
			echo “We’re sorry, but this page could not be displayed because of an internal error. The error has been recorded and will be rectified as soon as possible. Our apologies for the inconvenience. <p> <a href=/>Click here to go back to the main menu.</a>”;
			echo “</body></html>”;
			// exit
			exit();
		}
		// report warnings and fatal errors
		error_reporting(E_ERROR | E_WARNING);
		// define a custom handler
		set_error_handler(“e”);
		// attempt a MySQL connection
		$connection = @mysql_connect(“localhost”, “john”, “doe”); mysql_select_db(“content”);
		// generate and execute query
		$query = “SELECT * FROM news ORDER BY timestamp DESC”;
		$result = mysql_query($query, $connection);
		// if resultset exists
		if (mysql_num_rows($result) > 0) {?>
			<ul>
				<?php
				// iterate through query results
				// print data
				while($row = mysql_fetch_object($result)) { ?>
					<li><b><?=$row->slug?></b>
						<br>
						<font size=-1><i><?=$row->timestamp?></i></font>
						<p> <font size=-1><?php echo substr($row->content, 0, 150); ?>… <a href=story.php?id=<?=$row->id?>>Read more</a></font> </p>
				<?php } ?>
			</ul>
		<?php } else { echo “No stories available at this time”; }
			// no errors occured
			// print buffer contents
			ob_end_flush();
		?>
	</body>
</html>