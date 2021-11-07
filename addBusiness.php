<?php include_once("login.php"); ?>
<?php
$link = mysql_connect('localhost', $dbuser, $dbpassword);
$db_selected = mysql_select_db($dbname, $link);
$site = $_POST["site"];
if (strpos($site,"http://") === false )
	$site = "http://".$site;
$query = "insert into brm_business (name,	site,	tel,	type, last_modified) values ('".mysql_real_escape_string($_POST["name"])."','"
.mysql_real_escape_string($site)."','"
.mysql_real_escape_string($_POST["tel"])."','"
.mysql_real_escape_string($_POST["type"])."', now());";

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
