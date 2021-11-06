<?php include_once("login.php"); ?>
<?php
$link = mysql_connect('localhost', $dbuser, $dbpassword);
$db_selected = mysql_select_db($dbname, $link);
if ($_POST["businessIdToEdit"] && !$_POST["businessId"]) // show edit form
{
// Perform Query
$result = mysql_query("select * from brm_business where
							id = ".mysql_real_escape_string($_POST["businessIdToEdit"]).";");
// This shows the actual query sent to MySQL, and the error. Useful for debugging.
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    die($message);
}
$row = mysql_fetch_assoc($result)
?>
<div style="border: 1px solid black;">
<h4> Edit Business</h4>
<form action="editBusiness.php" method="POST">
<input type="hidden" name="businessId" value="<?php echo $_POST['businessIdToEdit'] ?>" />
<label for="name">business name</label><input name="name" type="text" value="<?php echo $row['name'];?>"/><br/>
<label for="type">business type</label><input name="type" type="text" value="<?php echo $row['type'];?>"/><br/>
<label for="site">business website</label><input name="site" type="text" value="<?php echo $row['site'];?>"/><br/>
<label for="tel">business telephone</label><input name="tel" type="text" value="<?php echo $row['tel'];?>"/><br/>
<input type="submit" value="Edit"></input>
</form>
</div>
<?php
}
else
{
$site = $_POST["site"];
if (strpos($site,"http://") === false )
	$site = "http://".$site;
$query = "update brm_business set name = '".mysql_real_escape_string($_POST["name"])."',	
site = '".mysql_real_escape_string($site)."',
	tel = '".mysql_real_escape_string($_POST["tel"])."',
		type = '".mysql_real_escape_string($_POST["type"])."'
 where id = '".mysql_real_escape_string($_POST["businessId"])."';";

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
