<?php
//Conexión a la base de datos
$db = new mysqli("mysql.webcindario.com", "boostrap_form", "PPortill0", "boostrap_form") or die("Error conectando a la BBDD");
	//echo "Conexíon con la Base de datos establecida <br /> <hr>";

mysqli_query($db, "SET NAMES 'utf8'") //--> Para utilizar esa codificación de caracteres y no tener problemas con las ñ o tildes.

?>