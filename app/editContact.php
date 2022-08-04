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
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>contact manager - edit contact</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="favicon.png">
</head>
<body>
    <div class="container">
        <h4>Edit Contact <?=$row['name']?></h4>
        <form action="editContact.php" method="POST">
            <input type="hidden" name="contactId" value="<?php echo $_POST['contactIdToEdit'] ?>">
            <label for="name">name</label><input id="name" name="name" type="text" value="<?php echo $row['name'];?>">
            <label for="mail">email</label><input id="mail" name="mail" type="text" value="<?php echo $row['mail'];?>">
            <label for="tel">telephone</label><input id="tel" name="tel" type="text" value="<?php echo $row['tel'];?>">
            <br>
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
WHERE id = '".$mysqli->real_escape_string($_POST["contactId"])."';";

// Perform Query
$result = $mysqli->query($query);

// return to site :)
include_once("index.php");
}
?>
