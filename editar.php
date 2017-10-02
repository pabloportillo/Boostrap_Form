<?php include 'includes/redirect.php';?>
<?php require_once 'includes/header.php';?>

<?php

function showError($errors, $field)
{
		if(isset($errors[$field]) && !empty($field)) 
		{
			$alert = '<div class="alert alert-danger" style="margin-top:5px;">' . $errors[$field] . '</div> <!--Muestra en una clase de boostrap el mensaje de errors de "name" -->';
		}else
		{
			$alert = '';
		}
		return $alert;

}

function setValueField($data, $field, $textarea = false)
{
	if(isset($data) && count($data)>=1)
	{
		if($textarea != false)
		{
			echo $data[$field];
		}else
		{
			echo "value='{$data[$field]}'";
		}
		
	}

} 

//Conseguir Usuario

if(!isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"]))
{
	header("Location:index.php"); 
	// Si $_GET["id"] No existe, ó está vacío, ó no es numérico --> redirecciona a index.php
}

$id = $_GET["id"]; 

$user_query = mysqli_query($db, "SELECT * FROM users WHERE user_id= {$id}");

$user = mysqli_fetch_assoc($user_query);

//Si user_id no existe ó está vacío (ejemplo: ver.php?id=111111)
if (!isset($user["user_id"]) || empty($user["user_id"]))
{
	header("Location:index.php"); 
}


	//Validar el formulario

	$errors = array(); // Creamos la variable errors vacía para que cuando llame a la función de showErrors no pete por no existir la variable (en caso de que no haya errores)


	if (isset($_POST["enviar"])) //SI existe el POST de enviar, es que le han dado al boton de enviar. (El input del boton se llama "enviar")
	{

		if (!empty($_POST["name"])) 
		{
			$name = $_POST["name"];

			if (preg_match("/^[a-zA-Z ]*$/",$name) && strlen($name) <= 20) 
			// Comprueba que sean caracteres alfabeticos, incluyendo el espacio, y que sea menor que 20 caracteres
			{
				$name_valildate = true;
			}else
			{
				$name_valildate = false;
				$errors["name"] = "El nombre no es válido.";
			}
		}else 
		{
			$name_valildate = false;
			$errors["name"] = "No se ha introducido nombre.";
		}

		if (!empty($_POST["surname"])) 
		{
			$surname = $_POST["surname"];

			if (preg_match("/^[a-zA-Z ]*$/",$surname))
			{
				$surname_valildate = true;
			}else
			{
				$surname_valildate = false;
				$errors["surname"] = "Su Apellido contiene caracteres no validos <br />"; 
			}
		}else 
		{
			$surname_valildate = false;
			$errors["surname"] = "No se ha introducido Apellido.";
		}

		if (!empty($_POST["bio"]))  
		{
			$bio_validate = true; 

		}else
		{
			$bio_validate = false; 
			$errors["bio"] = "La biografia no puede estar vacía.";
		}

		if (!empty($_POST["email"])) 
		{

			if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) //Comprueba que el email es válido.
			{
			  $email_validate = true;
			}else
			{

				$email_validate = false;
				$errors["email"] = "Formato de email inválido";
				
			}
		}else
		{
			$email_validate = false;
			$errors["email"] = "El email no puede estar vacío";
		}

		$image = null;

		if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) // Si existe la variable super global $_FILES con el nombre del input de imagen "image", y NO está vacía (porque esta variable super global siempre va a contener algo aunque sean espacios en blanco),(tmp_name es el nombre del campo del array de $_FILES que no puede estar vacío) entonces:
		{
			if(!is_dir("uploads")) //si no existe el directorio uploads
			{
				$dir = mkdir("uploads",0777,true); //lo crea y le da permisos y que sea recursivo
			}else
			{
				$dir = true;
			}

			if ($dir) // si $dir es true
			{
				$filename = time() . "-" . $_FILES["image"]["name"]; // a la variable filename la llamamos con el nombre de la imagen mas el tiempo delante para que no se sobreescriban archivos en caso de que se manden con el mismo nombre.

				$muf = move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/".$filename); //el fichero que está temporalmente subido en el servidor, lo vamos a mover al directorio "uploads" con nombre $filename

				$image = $filename; // $image se va a insertar en la base de datos así que hay que actualizarla con un nombre para que no sea "null" y no se quede a null 

				if ($muf) // si muf da true no genera ningun error 
				{
					$image_upload = true;
					
				}else
				{
					$image_upload = false;
					$errors["image"] = "La imagen no se ha subido correctamente";
				}
			}
		}


		/*if (!empty($_POST["password"])) 
		{
			$password = $_POST["password"];

			if (strlen($password) < 6)
			{
				$password_validate = false;
				$errors["password"] = "La password debe ser mayor de 6 caracteres.";
			}else
			{
				$password_validate = true;
				//echo sha1($password) . "<br />"; //sha1 muestra la password cifrada!!
			}
		}else
		{
			$password_validate = false;
			$errors["password"] = "La password no se ha introducido";
		}*/

		if (isset($_POST["role"]) && ($_POST["role"] != "none")) 
		{
			$role_validate = true;
		}else
		{
			$role_validate = false;
			$errors["role"] = "No has selecionado ningun rol";
		}

	}

	/* Esto de abajo ya no hace falta pero lo dejo para que te acuerdes de como debuguear
	echo "<pre>";
	print_r($errors);
	echo "</pre>";
	*/

	// ACTUALIZAMOS LOS USUARIOS EN LA BBDD

	//echo "<br>" . count($errors);
	
	if (isset($_POST["enviar"]) && count($errors)==0)
	{
		$sql = "UPDATE users set name = '" . $_POST["name"] . "', surname = '" . $_POST["surname"] . "', bio = '" . $_POST["bio"] . "', email = '" . $_POST["email"] . "'";

		if(isset($_POST["password"]) && !empty($_POST["password"]))
		{
			$sql.= ", password = '".sha1($_POST["password"])."'";
		}

		if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"]))
		{
			$sql.= ", image = '" . $image . "'";
		}

		$sql.= ", role = '" . $_POST["role"] . "' WHERE user_id =" . $user["user_id"] . ";";

		$update_user = mysqli_query($db, $sql);

		if ($update_user) //si update_users da true saca la consulta con los datos actualizados en la pantalla(no hace falta refrescar la pagina para que aparezca)
		{
			$user_query = mysqli_query($db, "SELECT * FROM users WHERE user_id= {$id}");
			$user = mysqli_fetch_assoc($user_query);
		}

	}else
	{
		$update_user = false;
	}
	

?>

<!-- ___________________________________________________ FORMULARIO EN HTML ___________________________________________________ -->

<h2>Editar Usuario <?php echo $user["user_id"] . " - " . $user["name"] . " - " . $user["surname"]; ?></h2>
<?php if(isset($_POST["enviar"]) && count($errors)==0 && $update_user != false){ ?>
	<div class="alert alert-success">
		El usuario se ha actualizado correctamente!!
	</div>
<?php } elseif(isset($_POST["enviar"])) {?>
	<div class="alert alert-danger">
		El usuario NO se ha actualizado !!
	</div>
<?php } ?>
<form action="" method="POST" enctype="multipart/form-data"> <!--action en recibir.php porque se va a llevar los datos recogidos aquí a esa página. Importante, va a abrir una nueva página en el navegador con los datos que aparezan. Nota: el enctype"="multipart/form-data" hay que incluirlo siempre que se quiera subir ficheros desde un formulario --> 

	
	<label for="name"> 
		Nombre:
		<input 		type="text" 	name="name"  	class="form-control" <?php setValueField($user, "name");?>/> 			<!--type = email -->
		<?php echo showError($errors, "name");?>
	</label>
	</br>																				<!--salto abajo -->

	<label for="surmane"> 
		Apellidos:
		<input 		type="text" 	name="surname" 	class="form-control" <?php setValueField($user, "surname");?>/>
		<?php echo showError($errors, "surname");?>
	</label>
	</br>

	<label for="bio"> 
		Biografia:
		<textarea 					name="bio" 		class="form-control"><?php setValueField($user, "bio", true);?></textarea> 	<!-- textarea -->
		<?php echo showError($errors, "bio");?>
	</label>
	</br>

	<label for="email"> 
		Email:
		<input 		type="email"	name="email"	class="form-control" <?php setValueField($user, "email");?>/> 			 <!--type = email -->
		<?php echo showError($errors, "email");?>
	</label>
	</br>

	<label for="image"> 
	<?php if ($user["image"] != null) {  ?> <!--Si existe user[image] -->
	Imagen de Perfil:<br><img src="uploads/<?php echo $user["image"] ?>" width="140"/> <!--Muestrala -->
	<?php }?> <br>
		Actualizar imagen de perfil:
		<input 		type="file" 	name="image"	class="form-control" /> 
	</label>
	</br>

	<label for="password"> 
		Password:
		<input 		type="password" name="password"	class="form-control" />				 <!--type = password -->
		<?php echo showError($errors, "password");?>
	</label>
	</br>

	<label for="role"> 
		Rol:
		<select 					name="role"		class="form-control">				 <!-- Select -->

			<option value="none" <?php if($user["role"] == "none"){ echo "selected='selected'";} ?>> 		   None		 	 </option>
			<option value="Normal" <?php if($user["role"] == "Normal"){ echo "selected='selected'";} ?>>  	   Normal 		 </option>			
			<option value="Administrador" <?php if($user["role"] == "Administrador"){ echo "selected='selected'";} ?>>  Administrador </option>

		</select>
		<?php echo showError($errors, "role");?>
	</label>
	</br>
	<input type="submit" value="Enviar" name="enviar" class="btn btn-success">

<!-- N O T A S : 
	1. Los names de los inputs y demas se utilizaran despues para recoger los datos del formulario, es importante ponerselo 
	2. Los label como que agrupa. Buscar para qué sirve label
	3. form-control es para rendondear el campo del texto y que quede mas estilizado -->

</form>

<?php require_once 'includes/footer.php';?>