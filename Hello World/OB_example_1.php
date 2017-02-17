<?php
// Output buffering example 1 from http://www.devshed.com/c/a/PHP/Output-Buffering-With-PHP/
// run at script start
function page_init() {
	// start buffering the output 
	ob_start();
}
// run at script end
function page_exit() {
	global $error;
	// if an error occurred
	// erase all output generated so far
	// and display an error message
	if ($error == 1) {
		ob_end_clean();
		print_error_template();
	}
	// no errors?
	// display output
	else {
		ob_end_flush();
	}
}
// print error page
function print_error_template() {
	echo “<html><head><basefont face=Arial></head><body>An error occurred. Total system meltdown now in progress.</body></html>”;
}

page_init();// script code goes here
echo “This script is humming like a well-oiled machine”;
// if an error occurs
// set the global $error variable to 1
// uncomment the next line to see what happens if no error occurs
$error = 1;
page_exit();
?> 