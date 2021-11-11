<?php include_once("login.php"); ?><?php
$mysqli = new mysqli('localhost', $dbuser, $dbpassword, $dbname);
if ($_POST["ticketIdToEdit"] && !$_POST["ticketId"]) { // show edit form
    // Perform Query
    $result = $mysqli->query("select * from brm_tickets where id = ".
        $mysqli->real_escape_string($_POST["ticketIdToEdit"]).";");
    $row = $result->fetch_assoc(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <title>contact manager - edit ticket</title>
  <link rel="StyleSheet" href="style.css" type="text/css" media="screen">
  <link rel="icon" type="image/png" href="favicon.png">
  <meta name="author" content="Marco Paladini">
</head>
<body>
  <div style="border: 1px solid black;">
    <h4>Edit Ticket</h4>
    <form action="editTicket.php" method="post">
      <input type="hidden" name="business_id" value="<?php echo $_POST['business_id']; ?>">
      <input type="hidden" name="ticketId" value="<?php echo $_POST['ticketIdToEdit']; ?>">
      <label for="what">what</label>
      <textarea name="what" type="textarea"><?php echo $row['what']; ?></textarea><br>
      <label for="paid">payment</label><input name="paid" type="text" value="<?php echo $row['payment']; ?>"><br>
      <input type="submit" value="Edit">
    </form>
  </div>
</body>
</html>
<?php
} elseif ($_POST['ticketId']) { // don't show edit form, perform edit
        $query = "update brm_tickets set        
  what = '".$mysqli->real_escape_string($_POST["what"])."',
  date = now(),
  last_modified = now(),
  payment = '".$mysqli->real_escape_string($_POST["paid"])."'
  where id = '".$mysqli->real_escape_string($_POST["ticketId"])."';";

        // Perform Query
        $result = $mysqli->query($query);
    }
if (!$_POST["ticketIdToEdit"]) {
    // either after running the edit or invalid request, return to home?>
<!DOCTYPE html>
<html>
<head>
<?php
  echo "<meta http-equiv='refresh' content=\"0; URL='index.php?b=".$_POST['business_id']."'\"/>"; ?>
  <title>ticket added</title>
</head>
<body>
</body>
</html>

<?php
} ?>
