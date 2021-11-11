<?php

session_start();
include_once("codes.php");

function printLoginForm()
{
    echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">";
    echo "<html>";
    echo "<head><title>contact manager application</title></head><body>";
    echo "<form action='index.php' method='post'>";
    echo "<label for='user'>username</label>";
    echo "<input name='user' type='text' />";
    echo "<label for='password'>password</label>";
    echo "<input name='password' type='password' />";
    echo "<input type='submit' value='login' />";
    echo "</form>";
    echo "</body></html>";
    die();
}

if ($_POST['user']==$user and $_POST['password']==$password) {
    $_SESSION['username_check']=$_POST['user'];
    $_SESSION['password_check']=$_POST['password'];
}
if ($_SESSION['username_check']==$user and $_SESSION['password_check']==$password) {
} else {
    printLoginForm();
    die();
}
