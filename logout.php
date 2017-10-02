<?php 
//Iniciamos la session
session_start();

//Logout
if(isset($_SESSION["logged"])) //Si no existe la session te redirige al formulario para loguearse
{
	unset($_SESSION["logged"]); //va a "desloguear" (borrar) esa sesion.
	header("Location: login.php");
}

?>