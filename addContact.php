<?php include_once("login.php"); ?>
<?php
$link = mysql_connect('localhost', $dbuser, $dbpassword);
$db_selected = mysql_select_db($dbname, $link);
$query = "insert into brm_contact (business_id, name,	mail,	tel) values ('"
.mysql_real_escape_string($_POST["business_id"])."','"
.mysql_real_escape_string($_POST["name"])."','"
.mysql_real_escape_string($_POST["mail"])."','"
.mysql_real_escape_string($_POST["tel"])."');";

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
