<?php include_once("login.php"); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>contact manager application</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="icon" type="image/png" href="favicon.png">
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
    while ($row = $result->fetch_assoc()) {
        echo "<div class='row'><div class='twelve columns'>";
        echo "<a href='index.php?b=".$row['id'];
        if (isset($_GET['admin'])) {
            echo "&admin=".$_GET['admin'];
        }
        echo "' class='button button-primary'>".$row['name']."</a>";
        echo "<br>";
        if(isset($_GET['admin'])) {
            echo "<form action='editBusiness.php' method='POST'>";
            echo "<input type='hidden' name='businessIdToEdit' value='".$row['id']."'>";
            echo "<input class='button' type='submit' value='edit'></form>";
        }
        echo "</div></div>";
    }
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
    $result = $mysqli->query("select t.id as id, b.name as name, t.what as what, t.last_modified as date from brm_tickets t left join brm_business b on b.id = t.business_id where b.id =
    ".$mysqli->real_escape_string($_GET['b'])." order by t.last_modified desc;");
    // This shows the actual query sent to MySQL, and the error. Useful for debugging.
    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        die($message);
    }

    while ($row = $result->fetch_assoc()) {
        echo "<div class='row'><div class='twelve columns'>";
        printf("<pre><code>%s</code></pre>", $row['what']);
        printf("<p>[%s]&nbsp;&nbsp;%s CET</p>", $row['id'], $row['date']);
        echo "</div></div>";
        if(isset($_GET['admin'])) {
            echo "<form action='editTicket.php' method='POST'>";
            echo "<input type='hidden' name='ticketIdToEdit' value='".$row['id']."'>";
            echo "<input class='button' type='submit' value='edit'></form>";
        }
    }
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
<div class='container'>
    <p></p>
    <div class="row"><div class="twelve columns">
    <a href="index.php" class="button">home</a>
    <?php if(isset($_GET['b'])) { ?>
        <a href="index.php?b=<?php echo $_GET['b'] ?>&admin=true" class="button">edit</a>
    <?php } else { ?>
        <a href="index.php?admin=true" class="button">edit</a>
    <?php } ?>
    </div></div>
<?php if(isset($_GET['b'])) { ?>

    <?php
    $result = $mysqli->query("select * from brm_business where id = ".$mysqli->real_escape_string($_GET['b']).";");
    while ($row = $result->fetch_assoc()) {
    ?>
        <div class="row"><div class="twelve columns">
        <p>business name: <?=$row['name']?></p>
        <p>web: <a href="<?=$row['site']?>"><?=$row['site']?></a></p>
        </div></div>
    <?php
    $business_name = $row['name'];
    } ?>

    <div id="tickets">
        <h2> tickets for <?=$business_name?></h2>
        <?php
        ticketList($mysqli);
        ?>
        <div class="add_form">
            <h4> add ticket</h4>
            <form action="addTicket.php" method="post">
            <?php business_id_select($mysqli); ?>
            <label for="what">what</label>
            <textarea class="u-full-width" id="what" name="what" type="textarea"></textarea>
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
<?php } else { ?>
    <?php
    businessList($mysqli);
    ?>
    <div class="row"><div class="twelve columns">
        <h4> add business</h4>
        <form action="addBusiness.php" method="post">
        <label for="name">business name</label><input name="name" type="text" /><br/>
        <label for="site">business website</label><input name="site" type="text" /><br/>
        <input type="submit" value="add">
        </form>
    </div></div>
<?php } ?>
</div>
<?php
// clean up
$mysqli->close();
?>
</body>
</html>