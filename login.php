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

if ($_POST['user']==$user AND $_POST['password']==$password )
{	// Accesso consentito
// il post e' valido
	$_SESSION['controllo_user']=$_POST['user'];
	$_SESSION['controllo_password']=$_POST['password'];
//	$_SESSION['controllo_utente']=$_SERVER['PHP_AUTH_USER'];
//	$_SESSION['controllo_password']=$_SERVER['PHP_AUTH_PW'];
}
if ($_SESSION['controllo_user']==$user AND $_SESSION['controllo_password']==$password)
{
}
else
{
printLoginForm();
die();
}
?>