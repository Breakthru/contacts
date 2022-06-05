<?php include_once("login.php"); ?>
<?php
$mysqli = new mysqli('localhost', $dbuser, $dbpassword, $dbname);
if ($_POST["businessIdToEdit"] && !$_POST["businessId"]) // show edit form
{
// Perform Query
$result = $mysqli->query("select * from brm_business where
							id = ".$mysqli->real_escape_string($_POST["businessIdToEdit"]).";");
$row = $result->fetch_assoc()
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>contact manager - edit business</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="favicon.png">
</head>
<body>
    <div class="container">
        <h4>Edit Business <?=$row['name']?></h4>
        <form action="editBusiness.php" method="POST">
        <input type="hidden" name="businessId" value="<?=$_POST['businessIdToEdit'] ?>">
        <label for="name">business name</label><input id="name" name="name" type="text" value="<?=$row['name'] ?>">
        <label for="type">business type</label><input id="type" name="type" type="text" value="<?=$row['type'] ?>">
        <label for="site">business website</label><input id="site" name="site" type="text" value="<?=$row['site'] ?>">
        <label for="tel">business telephone</label><input id="tel" name="tel" type="text" value="<?=$row['tel'] ?>">
        <br>
        <input type="submit" value="Edit"></input>
        </form>
    </div>
</body>
<?php
}
else
{
    $query = "update brm_business set name = '".$mysqli->real_escape_string($_POST["name"])."',
    site = '".$mysqli->real_escape_string($_POST["site"])."',
    last_modified = now(),
    tel = '".$mysqli->real_escape_string($_POST["tel"])."',
    type = '".$mysqli->real_escape_string($_POST["type"])."'
    where id = '".$mysqli->real_escape_string($_POST["businessId"])."';";

    // Perform Query
    $result = $mysqli->query($query);

    // return to site :)
    include_once("index.php");
}
?>
