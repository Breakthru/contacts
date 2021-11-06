<?php include_once("login.php"); ?>
<?php
$link = mysql_connect('localhost', $dbuser, $dbpassword);
$db_selected = mysql_select_db($dbname, $link);
$query = "insert into brm_tickets (business_id,	what,	payment, date) values ('"
.mysql_real_escape_string($_POST["business_id"])."','"
.mysql_real_escape_string($_POST["what"])."','"
.mysql_real_escape_string($_POST["payment"])."', now());";


// Perform Query
$result = mysql_query($query);
// This shows the actual query sent to MySQL, and the error. Useful for debugging.
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

// return to site :)
include_once("index.php");
?>
