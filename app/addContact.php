<?php include_once("login.php"); ?><?php
$mysqli = new mysqli('localhost', $dbuser, $dbpassword, $dbname);

$query = "insert into brm_contact (business_id, name,   mail,   tel, last_modified) values ('"
.$mysqli->real_escape_string($_POST["business_id"])."','"
.$mysqli->real_escape_string($_POST["name"])."','"
.$mysqli->real_escape_string($_POST["mail"])."','"
.$mysqli->real_escape_string($_POST["tel"])."', now());";

// Perform Query
$result = $mysqli->query($query);

?>
<!DOCTYPE html>
<html>
<head>
<?php
  echo "<meta http-equiv='refresh' content=\"0; URL='index.php?b=".$_POST['business_id']."'\"/>";
?>
  <title>contact added</title>
</head>
<body>
</body>
</html>
