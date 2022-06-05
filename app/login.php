<?php
// read credentials from disk
include_once("codes.php");

// write log into db
// load database
$mysqli = new mysqli('localhost', $dbuser, $dbpassword, $dbname);
$query = "insert into brm_logs (user_agent, ip_address, referrer, url, timestamp) values ('"
.$mysqli->real_escape_string($_SERVER['HTTP_USER_AGENT'])."','"
.$mysqli->real_escape_string($_SERVER['REMOTE_ADDR'])."','"
.$mysqli->real_escape_string($_SERVER['HTTP_REFERER'])."','"
.$mysqli->real_escape_string($_SERVER['REQUEST_URI'])."', now());";

// Perform Query
$result = $mysqli->query($query);


// redirect to https
if (!str_starts_with($_SERVER['HTTP_HOST'], "192.168") && $_SERVER['HTTP_HOST'] !== "localhost" && $_SERVER["HTTP_X_FORWARDED_PROTO"] !== "https") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}
session_start();


if (isset($_POST['user']) AND isset($_POST['password']) AND $_POST['user']===$user AND password_verify($_POST['password'], $password_hash))
{	// login successful
	$_SESSION['user_token']=$user_token;
}
// check current session
if (!array_key_exists('user_token', $_SESSION) || !$_SESSION['user_token']==$user_token)
{
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>contact manager application</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="css/style.css">
        </head>
        <body>
            <div class="container">
                <form action='index.php' method='post'>
                <div class="row"><div class="twelve columns">
                    <label for='user'>username</label>
                    <input name='user' id='user' type='text'>
                    <label for='password'>password</label>
                    <input name='password' id='password' type='password'>
                    <br>
                    <input type='submit' value='login'>
                </div></div>
        </body>
    </html>
    <?php
    die();
}
// logged in.
?>