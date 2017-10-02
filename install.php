<?php 

require_once 'includes/connect.php'; //include la conexión a la base de datos

/*
$sql = "CREATE TABLE IF NOT EXISTS users (
			user_id int(255) auto_increment not null,
			name varchar(50),
			surname varchar(50),
			bio text,
			email varchar(255),
			password varchar(255),
			role carchar(20),
			image varchar(255),
			CONSTRAINT pk_users PRIMARY KEY(users_id)
		)";

$create_usuarios_table = mysqli_query($db, $sql);

if($create_usuarios_table) //comprueba si está ejecutando la consulta correctamente.
{
	echo "La tabla users se ha creado correctamente !!";
}

*/

$sql = "INSERT INTO users VALUES (NULL, 'Victor', 'Robles', 'Web Developer', 'victor@victor.com', '".sha1("password")."', '1', NULL)";

$insert_user = mysqli_query($db, $sql);

$sql = "INSERT INTO users VALUES (NULL, 'Pablo', 'Portillo', 'Web Developer', 'pablo@portillo.com', '".sha1("PPortill0")."', '2', NULL)";

$insert_user1 = mysqli_query($db, $sql);

$sql = "INSERT INTO users VALUES (NULL, 'Zhuldhyz', 'Portillo', 'Fashion Desinger', 'zhuldhyz@portillo.com', '".sha1("noname")."', '1', NULL)";

$insert_user2 = mysqli_query($db, $sql);

$sql = "INSERT INTO users VALUES (NULL, 'Alex', 'Terroba', 'Cochecitos', 'alex@terroba.com', '".sha1("cochecitos")."', '1', NULL)";

$insert_user3 = mysqli_query($db, $sql);

$sql = "INSERT INTO users VALUES (NULL, 'Tata', 'Zorongo', 'Gardener', 'tata@zorongo.com', '".sha1("tata")."', '1', NULL)";

$insert_user4 = mysqli_query($db, $sql);


echo mysqli_error($db); //Nos muestra los errores de base de datos para ver que pasa, por si habiamos hecho la consulta SQL mal

/*
if($insert_user)
{
	echo "Usuario ingresado en la BBDD correctamente";
}else
{
	echo "No se ha hecho una mierda";
}*/




?>