<?php include_once("login.php"); ?><?php
$mysqli = new mysqli('localhost', $dbuser, $dbpassword, $dbname);

$query = "insert into brm_tickets (business_id, what, payment, date, last_modified) values ('"
.$mysqli->real_escape_string($_POST["business_id"])."','"
.$mysqli->real_escape_string($_POST["what"])."','"
.$mysqli->real_escape_string($_POST["payment"])."', now(), now());";


// Perform Query
$result = $mysqli->query($query);


// update business
$query = "UPDATE brm_business SET last_modified = now() WHERE id = '"
.$mysqli->real_escape_string($_POST["business_id"])."';";

// Perform Query
$result = $mysqli->query($query);

?>
<!DOCTYPE html>
<html>
<head>
<?php
  echo "<meta http-equiv='refresh' content=\"0; URL='index.php?b=".$_POST['business_id']."'\"/>";
?>
  <title>ticket added</title>
</head>
<body>
</body>
</html>