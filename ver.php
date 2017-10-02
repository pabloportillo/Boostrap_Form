<?php include 'includes/redirect.php';?>
<?php require_once 'includes/header.php';?>

<?php 

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

?>
	<?php if ($user["image"] != null) {  ?> <!--Si existe user[image] -->
	<div class="col-lg-2">
		<img src="uploads/<?php echo $user["image"] ?>" width="140"/> <!--Muestrala -->
	</div>
	<?php }?>

	<div class="col-lg-7">
		<h3><strong><?php echo $user["name"]." ". $user["surname"]; ?></strong></h3>
		<p>	Email: 		<?php echo $user["email"]; ?>	</p>
		<p>	Biografia:  <?php echo $user["bio"];   ?>	</p>
		<p>	Role:  <?php echo $user["role"];   ?>	</p>
	</div>
	<div class="clearfix"></div> <!--Limpia los flotados de divs -->
	<!-- <a href="index.php" class="btn btn-success">Volver al listado</a> -->

<?php require_once 'includes/footer.php';?>