<?php include_once("login.php"); ?>
<?php
$mysqli = new mysqli('localhost', $dbuser, $dbpassword, $dbname);
if ($_POST["contactIdToEdit"] && !$_POST["contactId"]) // show edit form
{
// Perform Query
$result = $mysqli->query("select * from brm_contact where
							id = ".$mysqli->real_escape_string($_POST["contactIdToEdit"]).";");
$row = $result->fetch_assoc();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>contact manager - edit contact</title>
<LINK REL="StyleSheet" HREF="style.css" TYPE="text/css" MEDIA="screen" />
<link rel="icon"
      type="image/png"
      href="favicon.png" />
<meta name="author" content="Marco Paladini">
</head>
<body>
<div style="border: 1px solid black;">
<h4> Edit Contact</h4>
<form action="editContact.php" method="POST">
<input type="hidden" name="contactId" value="<?php echo $_POST['contactIdToEdit'] ?>" />
<br/>
<label for="name">name</label><input name="name" type="text" value="<?php echo $row['name'];?>" /><br/>
<label for="mail">email</label><input name="mail" type="text" value="<?php echo $row['mail'];?>" /><br/>
<label for="tel">telephone</label><input name="tel" type="text" value="<?php echo $row['tel'];?>" /><br/>
<input type="submit" value="Edit"></input>
</form>
</div>
</body>
<?php
}
else // don't show edit form, perform edit
{

$query = "update brm_contact set
last_modified = now(),
name = '".$mysqli->real_escape_string($_POST["name"])."',
mail = '".$mysqli->real_escape_string($_POST["mail"])."',
tel = '".$mysqli->real_escape_string($_POST["tel"])."'
where id = '".$mysqli->real_escape_string($_POST["contactId"])."';";

// Perform Query
$result = $mysqli->query($query);

// return to site :)
include_once("index.php");
}
?>
