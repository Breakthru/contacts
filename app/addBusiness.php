<?php include_once("login.php"); ?><?php
$mysqli = new mysqli('localhost', $dbuser, $dbpassword, $dbname);

$query = "insert into brm_business (name,       site,   tel,    type, last_modified) values ('".$mysqli->real_escape_string($_POST["name"])."','"
.$mysqli->real_escape_string($_POST["site"])."','"
.$mysqli->real_escape_string($_POST["tel"])."','"
.$mysqli->real_escape_string($_POST["type"])."', now());";

// Perform Query
$result = $mysqli->query($query);

?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="refresh" content="0; URL='index.php'" />
  <title>business added</title>
</head>
<body>
</body>
</html>
