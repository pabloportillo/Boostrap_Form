<?php 
session_start();
require_once 'includes/connect.php';

if (isset($_POST["submit"])) 
{
	$email = trim($_POST["email"]);
	$password = sha1($_POST["password"]); //la contraseña se cifraba en la bbdd en sha1 y los cifrados son identicos por lo que para comparar contraseñas (ambas en sha1) debe de ponerse esta también en sha1.

	$sql = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}';";
	$login = mysqli_query($db, $sql);

	if ($login && mysqli_num_rows($login)==1) //Si $login da true 
	{
		$_SESSION["logged"] = mysqli_fetch_assoc($login); // $_SESSION["logged"] va a contener los datos del usuario con la función mysqli_fetch_assoc (de $login)

		if (isset($_SESSION["error_login"])) 
		{
			unset($_SESSION["error_login"]);
		}

		header("Location: index.php");
	}else
	{
		$_SESSION["error_login"] = "Login incorrecto!!";
	}
}
header("Location: login.php");
?>