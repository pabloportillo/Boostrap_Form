
<?php //require_once 'includes/header.php'; ?>

<?php 


	/* EJERCICIO 25: Recoge los datos de las variables POST y muéstralos por pantalla en el caso de que existan y no estén vacíos */

	/* Aqui se van a recoger los datos del formulario mediante la variable superglobal $_POST[] */

	/* + EJERCICIO 26: 

		Nombre: Solo puede estar formado por letras y tener una longitud máxima de 20 caracteres.
		Apellidos: Solo puede estar formado por letras.
		Biografía: No puede estar vacío.
		Email: Tiene que ser un email válido.
		Contraseña: Debe tener una longitud mayor que 6 caracteres.
		Imagen: No puede estar vacía.

	*/


	if (isset($_POST["enviar"])) //SI existe el POST de enviar, es que le han dado al boton de enviar. (El input del boton se llama "enviar")
	{
		if (!empty($_POST["name"])) 
		{
			$name = $_POST["name"];

			if (preg_match("/^[a-zA-Z ]*$/",$name) && strlen($name) <= 20) 
			// Comprueba que sean caracteres alfabeticos, incluyendo el espacio, y que sea menor que 20 caracteres
			{
				echo $name . "<br />";  
			}else
			{
				echo "Su Nombre contiene caracteres no validos o excede el número de caracteres <br />"; 
			}
		}else 
		{
			$name = ""; // esto es para la base de datos para que introduzca algun valor cuando haga la conexion.
		}

		if (!empty($_POST["surname"])) 
		{
			$surname = $_POST["surname"];

			if (preg_match("/^[a-zA-Z ]*$/",$surname))
			{
				echo $surname . "<br />";  
			}else
			{
				echo "Su Apellido contiene caracteres no validos <br />"; 
			}
		}else 
		{
			$surname = ""; // esto es para la base de datos para que introduzca algun valor cuando haga la conexion.
		}

		if (!empty($_POST["bio"])) 
		{
			$bio = $_POST["bio"]; // esto es para la base de datos para que introduzca algun valor cuando haga la conexion.
		}else
		{
			$bio = ""; // esto es para la base de datos para que introduzca algun valor cuando haga la conexion.
			echo "El campo Biografía no puede estar vació.  <br />"; // No puede estar vacío.
		}

		if (!empty($_POST["email"])) 
		{
			//$email = $_POST["email"]; // esto es para la base de datos para que introduzca algun valor cuando haga la conexion.

			$email = $_POST["email"];

			if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) //Comprueba que el email es válido.
			{
			  echo "email {$email} válido <br />"; 
			}else
			{
				$email = "";
				echo "Formato de email valido <br />"; 
			}
		}else
		{
			$email = "";
		}

		if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) // Si existe la variable super global $_FILES con el nombre del input de imagen "image", y NO está vacía (porque esta variable super global siempre va a contener algo aunque sean espacios en blanco),(tmp_name es el nombre del campo del array de $_FILES que no puede estar vacío) entonces:
		{
			$image = addslashes(file_get_contents($_FILES['image']['tmp_name'])); // guarda el valor en binario (o la mierda que sea) de la imagen en la variable $image
			echo "La imagen nos ha llegado <br />";
		}else
		{
			$image = "nulo";
			echo "Debes introducir una imagen <br />";
		}


		if (!empty($_POST["password"])) 
		{
			$password = $_POST["password"];

			if (strlen($password) < 6)
			{
				echo "Su password debe de disponer al menos de 6 caracteres <br />";
			}else
			{
				echo sha1($password) . "<br />"; //sha1 muestra la password cifrada!!
			}
		}else
		{
			$password = "";
		}

		if (!empty($_POST["role"])) 
		{
			$role = $_POST["role"];
			echo $_POST["role"] . "<br />";
		}else
		{
			$role = "";
		}

	}

?>

<?php //require_once 'includes/footer.php';?>