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
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>contact manager - edit ticket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="favicon.png">
</head>
<body>
    <div class="container">
        <h4>Edit Ticket [<?=$_POST['ticketIdToEdit']?>]</h4>
        <form action="editTicket.php" method="POST">
            <input type="hidden" name="ticketId" value="<?php echo $_POST['ticketIdToEdit'] ?>">
            <label for="what">what</label>
            <textarea id="what" name="what" type="textarea"><?php echo $row['what'];?></textarea>
            <br>
            <input type="submit" value="Edit"></input>
        </form>
    </div>
</body>
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

    // return to site
    include_once("index.php");
}
?>
