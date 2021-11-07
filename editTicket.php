<?php include_once("login.php"); ?>
<?php
$mysqli = new mysqli('localhost', $dbuser, $dbpassword, $dbname);
if ($_POST["ticketIdToEdit"] && !$_POST["ticketId"]) // show edit form
{
// Perform Query
$result = $mysqli->query("select * from brm_tickets where
							id = ".$mysqli->real_escape_string($_POST["ticketIdToEdit"]).";");
$row = $result->fetch_assoc();
?>
<div style="border: 1px solid black;">
<h4> Edit Ticket</h4>
<form action="editTicket.php" method="POST">
<input type="hidden" name="ticketId" value="<?php echo $_POST['ticketIdToEdit'] ?>" />
<br/>
<label for="what">what</label><textarea name="what" type="textarea"><?php echo $row['what'];?></textarea><br/>
<label for="paid">payment</label><input name="paid" type="text" value="<?php echo $row['payment'];?>"/><br/>
<input type="submit" value="Edit"></input>
</form>
</div>
<?php
}
else // don't show edit form, perform edit
{

$query = "update brm_tickets set 	
what = '".$mysqli->real_escape_string($_POST["what"])."',
date = now(),
last_modified = now(),
payment = '".$mysqli->real_escape_string($_POST["paid"])."'
where id = '".$mysqli->real_escape_string($_POST["ticketId"])."';";

// Perform Query
$result = $mysqli->query($query);

// return to site :)
include_once("index.php");
}
?>
