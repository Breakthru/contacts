<?php include_once("login.php"); ?><?php
$mysqli = new mysqli('localhost', $dbuser, $dbpassword, $dbname);
if ($_POST["businessIdToEdit"] && !$_POST["businessId"]) { // show edit form
// Perform Query
    $result = $mysqli->query("select * from brm_business where
                                                        id = ".$mysqli->real_escape_string($_POST["businessIdToEdit"]).";");
    $row = $result->fetch_assoc()
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>contact manager - edit business</title>
  <link rel="StyleSheet" href="style.css" type="text/css" media="screen">
  <link rel="icon" type="image/png" href="favicon.png">
  <meta name="author" content="Marco Paladini">
</head>
<body>
  <div style="border: 1px solid black;">
    <h4>Edit Business</h4>
    <form action="editBusiness.php" method="post">
      <input type="hidden" name="businessId" value="<?php echo $_POST['businessIdToEdit'] ?>"> <label for="name">business name</label><input name="name" type="text" value="<?php echo $row['name']; ?>"><br>
      <label for="type">business type</label><input name="type" type="text" value="<?php echo $row['type']; ?>"><br>
      <label for="site">business website</label><input name="site" type="text" value="<?php echo $row['site']; ?>"><br>
      <label for="tel">business telephone</label><input name="tel" type="text" value="<?php echo $row['tel']; ?>"><br>
      <input type="submit" value="Edit">
    </form>
  </div><?php
} else {
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
</body>
</html>
