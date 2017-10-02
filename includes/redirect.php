<?php 
//Iniciamos la session
session_start();

if(!isset($_SESSION["logged"])) //Si no existe la session te redirige al formulario para loguearse
{
	header("Location: login.php");
}

?>