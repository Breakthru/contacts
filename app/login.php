<?php
if (!str_contains($_SERVER['HTTP_HOST'], "192.168") && $_SERVER['HTTP_HOST'] !== "localhost" && $_SERVER["HTTP_X_FORWARDED_PROTO"] !== "https") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}
session_start();
include_once("codes.php");

function printLoginForm()
{
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">";
echo "<html>";
echo "<head><title>contact manager application</title>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1' />";
echo "</head><body>";
echo "<div style='text-align: center;'>";
echo "<form action='index.php' method='post'>";
echo "<label for='user'>username&nbsp;</label>";
echo "<input name='user' type='text' /><br/>";
echo "<label for='password'>password&nbsp;</label>";
echo "<input name='password' type='password' /><br/>";
echo "<input type='submit' value='login' />";
echo "</form>";
echo "</body></html>";
echo "</div>";
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