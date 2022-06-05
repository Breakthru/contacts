<?php include_once("login.php"); ?>
<?php
$mysqli = new mysqli('localhost', $dbuser, $dbpassword, $dbname);

$query = "insert into brm_tickets (business_id,	what, date, last_modified) values ('"
.$mysqli->real_escape_string($_POST["business_id"])."','"
.$mysqli->real_escape_string($_POST["what"])."', now(), now());";


// Perform Query
$result = $mysqli->query($query);
// This shows the actual query sent to MySQL, and the error. Useful for debugging.
if (!$result) {
    $message  = 'Invalid query: ' . mysqli_error($mysqli) . "\n";
    die($message);
}

// update business
$query = "UPDATE brm_business SET last_modified = now() WHERE id = '"
.$mysqli->real_escape_string($_POST["business_id"])."';";

// Perform Query
$result = $mysqli->query($query);

// return to site :)
$_GET['b']=$_POST['business_id'];
include_once("index.php");
?>
