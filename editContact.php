<?php include_once("login.php"); ?>
<?php
$link = mysql_connect('localhost', $dbuser, $dbpassword);
$db_selected = mysql_select_db($dbname, $link);
if ($_POST["contactIdToEdit"] && !$_POST["contactId"]) // show edit form
{
// Perform Query
$result = mysql_query("select * from brm_contact where
							id = ".mysql_real_escape_string($_POST["contactIdToEdit"]).";");
// This shows the actual query sent to MySQL, and the error. Useful for debugging.
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    die($message);
}
$row = mysql_fetch_assoc($result);
?>
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
<?php
}
else // don't show edit form, perform edit
{

$query = "update brm_contact set
last_modified = now(),
name = '".mysql_real_escape_string($_POST["name"])."',
mail = '".mysql_real_escape_string($_POST["mail"])."',
tel = '".mysql_real_escape_string($_POST["tel"])."'
where id = '".mysql_real_escape_string($_POST["contactId"])."';";

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
}
?>
