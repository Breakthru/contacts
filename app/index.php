<?php include_once("login.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>contact manager application</title>
<LINK REL="StyleSheet" HREF="style.css" TYPE="text/css" MEDIA="screen" />
<link rel="icon" 
      type="image/png" 
      href="favicon.png" />
</head>
<body>
<?php
// load database
$mysqli = new mysqli('localhost', $dbuser, $dbpassword, $dbname);


// print functions definitions
function businessList($mysqli)
{
// Perform Query
$result = $mysqli->query("select * from brm_business order by last_modified desc;");
// This shows the actual query sent to MySQL, and the error. Useful for debugging.
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    die($message);
}
echo "<div class='list'>";
while ($row = $result->fetch_assoc()) {
    echo "<div class='ticket'>";
    echo "<a href='index.php?b=".$row['id']."&admin=".$_GET['admin']."' class='button'>".$row['name']."</a>";
    echo "<br />";
    if(isset($_GET['admin'])) {
        echo "<form action='editBusiness.php' method='POST'>";
        echo "<input type='hidden' name='businessIdToEdit' value='".$row['id']."'>";
        echo "<input class='button' type='submit' value='edit'></form>";
    }
    echo "</div>";
}
echo "</div>";
}

function business_id_select($mysqli)
{
if(isset($_GET['b'])) {
    echo "<input type='hidden' name='business_id' value='".$_GET['b']."'>";
    return;
}
// Perform Query
$result = $mysqli->query("select * from brm_business order by last_modified desc;");
// This shows the actual query sent to MySQL, and the error. Useful for debugging.
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    die($message);
}
    echo "<label for='business_id'>business</label><select name='business_id'>";
while ($row = $result->fetch_assoc()) {

    echo "<option value=".$row['id'].">".$row['name']."</option>";
}
echo "</select><br/>";
}

function ticketList($mysqli)
{
// Perform Query
if(!isset($_GET['b'])) return;
$result = $mysqli->query("select t.id as id, b.name as name, t.what as what, t.payment as payment, t.last_modified as date from brm_tickets t left join brm_business b on b.id = t.business_id where b.id =
".$mysqli->real_escape_string($_GET['b'])." order by t.last_modified desc;");
// This shows the actual query sent to MySQL, and the error. Useful for debugging.
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    die($message);
}
echo "<div class='list'>";
while ($row = $result->fetch_assoc()) {
    echo "<div class='ticket'>";
    echo "[".$row['id']."] ".$row['name'].": ".$row['what']."<br/>cost: ".$row['payment']."<br/>date: ".$row['date']." CET";
    echo "<br />\n";
    if(isset($_GET['admin'])) {
        echo "<form action='editTicket.php' method='POST'>";
        echo "<input type='hidden' name='ticketIdToEdit' value='".$row['id']."'>";
        echo "<input class='button' type='submit' value='edit'></form>";
    }
    echo "</div>";
}
echo "</div>";
}

function contacts($mysqli)
{
if(!isset($_GET['b'])) return;
// Perform Query
$result = $mysqli->query("select c.id as id, b.name as bname, c.name as name, c.mail as mail, c.tel as tel from brm_contact c left join brm_business b on b.id = c.business_id
 where b.id = ".$mysqli->real_escape_string($_GET['b'])." order by c.last_modified desc;");
// This shows the actual query sent to MySQL, and the error. Useful for debugging.
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    die($message);
}
echo "<div class='list'>";
while ($row = $result->fetch_assoc()) {
    echo "<div class='ticket'>";
    echo $row['bname'].": ".$row['name']." , email: <a href = 'mailto:".$row['mail']."'>".$row['mail']."</a>, tel: ".$row['tel'];
    echo "<br />\n";
    if(isset($_GET['admin'])) {
        echo "<form action='editContact.php' method='POST'>";
        echo "<input type='hidden' name='contactIdToEdit' value='".$row['id']."'>";
        echo "<input class='button' type='submit' value='edit'></form>";
    }
    echo "</div>";
}
echo "</div>";
}
?>

<div id="header">
<a href="index.php" class="button">home</a>
<?php if(isset($_GET['b'])) { ?>
<a href="index.php?b=<?php echo $_GET['b'] ?>&admin=true" class="button">edit</a>
<?php } else { ?>
<a href="index.php?admin=true" class="button">edit</a>
<?php } ?>
</div>

<?php if(isset($_GET['b'])) { ?>
<div class='business_details'>
<?php
$result = $mysqli->query("select * from brm_business where id = ".$mysqli->real_escape_string($_GET['b']).";");
while ($row = $result->fetch_assoc()) {
    if ($row['type']) {
        echo "type: ".$row['type']."<br />";
    }
    echo "business name: ".$row['name']."<br />";
    echo "web: <a href='".$row['site']."'>".$row['site']."</a><br />";
    echo "tel: ".$row['tel']."<br />";
    $business_name = $row['name'];
}
?>
</div>
<div id="tickets">
    <h2> tickets for <?php echo $business_name; ?></h2>
    <?php
    ticketList($mysqli);
    ?>
    <div class="add_form">
        <h4> add ticket</h4>
        <form action="addTicket.php" method="post">
        <?php business_id_select($mysqli); ?>
        <label for="what">what&nbsp;</label><textarea rows="4" cols="50" name="what" type="textarea"></textarea><br/>
        <label for="payment">paid&nbsp;</label><input name="payment" type="text" value="0.00" size="5"><br/>
        <input type="submit" value="add">
        </form>
    </div>
</div>

<div id="contacts">
    <h2> contacts </h2>
    <?php
    contacts($mysqli);
    ?>
    <div class="add_form">
        <h4> add contact</h4>
        <form action="addContact.php" method="post">
        <?php business_id_select($mysqli); ?>
        <label for="name">name</label><input name="name" type="text" /><br/>
        <label for="mail">email</label><input name="mail" type="text" /><br/>
        <label for="tel">tel</label><input name="tel" type="text" /><br/>
        <input type="submit" value="add">
        </form>
    </div>
</div>
<?php } ?>

<div id="business_list">
    <?php
    businessList($mysqli);
    ?>
    <div class="add_form">
        <h4> add business</h4>
        <form action="addBusiness.php" method="post">
        <label for="name">business name</label><input name="name" type="text" /><br/>
        <label for="type">business type</label><input name="type" type="text" /><br/>
        <label for="site">business website</label><input name="site" type="text" /><br/>
        <label for="tel">business telephone</label><input name="tel" type="text" /><br/>
        <input type="submit" value="add">
        </form>
    </div>
</div>

<?php
// clean up
$mysqli->close();
?>
</body>
</html>