<?php
// credentials from disk
include_once("codes.php");
date_default_timezone_set('Europe/London');

// redirect to https
if (!str_starts_with($_SERVER['HTTP_HOST'], "192.168") && $_SERVER['HTTP_HOST'] !== "localhost" && $_SERVER["HTTP_X_FORWARDED_PROTO"] !== "https") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}
session_start();

if (isset($_POST['logout']))
{
  unset($_SESSION['user_token']);
  unset($_SESSION['user_is_admin']);
  unset($_SESSION['display_user_name']);
  echo "<h1>Logout successful</h1>";
  die();
}

if (isset($_POST['user']) AND isset($_POST['password']))
{
    // search for user
    $user_id = array_search($_POST['user'], $users);
    if ($user_id !== false AND password_verify($_POST['password'], $passwords_hash[$user_id]))
    {
        // login successful
        $_SESSION['user_token']=$user_tokens[$user_id];
        $_SESSION['user_is_admin'] = false;
        $_SESSION['display_user_name'] = $users[$user_id];
        header('Location: index.php');
        die();
	}
	// check admin login?
	if ($_POST['user']===$admin_user AND password_verify($_POST['password'], $admin_password_hash))
	{
	    $_SESSION['user_token'] = $admin_user_token;
	    $_SESSION['user_is_admin'] = true;
	    $_SESSION['display_user_name'] = "admin";
	}
}
// if not logged in, send login form
if (!array_key_exists('user_token', $_SESSION))
{
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>Welcome to the children's bank</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <?php
                if (isset($_POST['user']))
                {
                    echo "<h2>login failed. try again.</h2>";
                }
                ?>
                <form action='index.php' method='post'>
                <div class="row"><div class="twelve columns">
                    <label for='user'>username</label>
                    <input name='user' id='user' type='text'>
                    <label for='password'>password</label>
                    <input name='password' id='password' type='password'>
                    <br>
                    <input type='submit' value='login'>
                </form>
                </div></div>
        </body>
    </html>
    <?php
    die();
}
// logged in.
// load database
$mysqli = new mysqli('localhost', $dbuser, $dbpassword, $dbname);
?>

<?php
// regular user page
if (!$_SESSION['user_is_admin']) {
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Welcome to the children's bank</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div class="container">
        <h1>welcome <?=$_SESSION['display_user_name']?></h1>
        <form action='index.php' method='post'>
        <input type='hidden' name='logout' value='logout'>
        <input type='submit' value='logout'>
        </form>
        <hr>
<?php
    // Perform Query
    $result = $mysqli->query("SELECT * FROM `toy_bank_transactions` WHERE `account_to`=\"".$mysqli->real_escape_string($_SESSION['display_user_name'])."\" ORDER BY timestamp DESC;");
    // This shows the actual query sent to MySQL, and the error. Useful for debugging.
    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        die($message);
    }
    $balance = 0;
    while ($row = $result->fetch_assoc()) {
        echo "<div class='row'><div class='twelve columns'>";
        printf("<p class='code_ticket'>");
        printf("&nbsp;date and time: %s", $row['timestamp']);
        printf("&nbsp;%s", $row['reference']);
        printf("&nbsp;amount: &#163; %s", number_format((float)($row['amount']/100), 2, '.', ''));
        $balance = $balance + $row['amount'];
        printf("&nbsp;balance: &#163; %s", number_format((float)($balance/100), 2, '.', ''));
        printf("</p>");
        echo "</div></div>";
    }
?>
    </body>
</html>
<?php
// end regular user page
}
// admin page
if ($_SESSION['user_is_admin']) {
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Welcome to the children's bank</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div class="container">
        <h1>welcome <?=$_SESSION['display_user_name']?></h1>
        <?php
        if (array_key_exists("account_to", $_POST))
        {
            // process transaction
            // validate user input
            $outcome = "validation error";
            $user_id = array_search($_POST['account_to'], $users);
            if ($user_id !== false) {
                $account_to = $users[$user_id];
                $amount = floatval($_POST['amount']);
                if ($amount > 0 && $amount < 10) {
                    // not proper validation but this is a toy anyway
                    $amount_pence = intval(100*$amount);
                    // execute transaction
                    $result = $mysqli->query(
                    "INSERT INTO `toy_bank_transactions` ".
                    "(`account_from`, `account_to`, `amount`, `reference`) VALUES ".
                    "('mum', '".$mysqli->real_escape_string($account_to)."', ".
                    "'".$mysqli->real_escape_string($amount_pence)."', ".
                    "'".$mysqli->real_escape_string($_POST['reference'])."');");
                    if (!$result) {
                        $outcome  = 'Internal error: ' . mysql_error() . "\n";
                    } else {
                        $outcome = "transferred ".number_format((float)($amount_pence/100), 2, '.', '')." to ".$account_to;
                    }
                } else {
                    $outcome = "amount must be between 0 and 10";
                }
            } else {
                $outcome = "destination account not found";
            }
            printf("<h2>%s</h2>", $outcome);
            echo "<p>do not reload the page</p>";
            echo "<button><a href=\"index.php\">back</a></button>";
            die();
        }
        ?>
        <form action='index.php' method='post'>
        <input type='hidden' name='logout' value='logout'>
        <input type='submit' value='logout'>
        </form>
        <hr>
        <h2>Send reward</h2>
        <form action='index.php' method='post'>
        <label for="account_to">Send to:</label>
        <select name="account_to" id="account_to">
        <?php
        foreach ($users as $account_to) {
            printf("<option value=%s>%s</option>", $account_to, $account_to);
        }
        ?>
        </select>
        <label for="amount">Amount:</label>
        <input name="amount" type="text" id="amount">
        <label for="reference">Description:</label>
        <input name="reference" type="text" id="reference">
        <input type="submit" value="send">
        </form>
    </body>
</html>
<?php
} // end admin page
?>