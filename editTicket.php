<?php include_once("login.php"); ?>
<?php
$link = mysql_connect('localhost', $dbuser, $dbpassword);
$db_selected = mysql_select_db($dbname, $link);
if ($_POST["ticketIdToEdit"] && !$_POST["ticketId"]) // show edit form
{
// Perform Query
$result = mysql_query("select * from brm_tickets where
							id = ".mysql_real_escape_string($_POST["ticketIdToEdit"]).";");
// This shows the actual query sent to MySQL, and the error. Useful for debugging.
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    die($message);
}
$row = mysql_fetch_assoc($result);
?>
<div style="border: 1px solid black;">
<h4> Edit Ticket</h4>
<form action="editTicket.php" method="POST">
<input type="hidden" name="ticketId" value="<?php echo $_POST['ticketIdToEdit'] ?>" />
<br/>
<label for="what">what</label><textarea name="what" type="textarea"><?php echo $row['what'];?></textarea><br/>
<label for="paid">payment</label><input name="pay" type="text" value="<?php echo $row['payment'];?>"/><br/>
<input type="submit" value="Edit"></input>
</form>
</div>
<?php
}
else // don't show edit form, perform edit
{

$query = "update brm_tickets set 	
what = '".mysql_real_escape_string($_POST["what"])."',
date = now(),
payment = '".mysql_real_escape_string($_POST["paid"])."'
where id = '".mysql_real_escape_string($_POST["ticketId"])."';";

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
