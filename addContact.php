<?php include_once("login.php"); ?>
<?php
$mysqli = new mysqli('localhost', $dbuser, $dbpassword, $dbname);

$query = "insert into brm_contact (business_id, name,	mail,	tel, last_modified) values ('"
.$mysqli->real_escape_string($_POST["business_id"])."','"
.$mysqli->real_escape_string($_POST["name"])."','"
.$mysqli->real_escape_string($_POST["mail"])."','"
.$mysqli->real_escape_string($_POST["tel"])."', now());";

// Perform Query
$result = $mysqli->query($query);

// return to site :)
$_GET['b']=$_POST['business_id'];
include_once("index.php");
?>
