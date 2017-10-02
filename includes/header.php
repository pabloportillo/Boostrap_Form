<?php 

require_once 'connect.php';

?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Formulario</title>

  <!--Incluir los links y scripts de abajo para integrar Bootstrap y JQuery -->

  <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap-theme.min.css" />
  <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/jquery/jquery.min.js"></script>


 <div align="center"> 
  <font face="Comic Sans MS,arial,verdana" size=8 color="teal" >Welcome to the application Form</font>
 </div>

  <hr> <!--Añade una linea, para separar -->

  <div class="container"> <!-- Abrimos un div que cerramos en el footer, para que Boostrap haga un pequeño margen al contenido del body -->
  <?php if (isset($_SESSION["logged"])) { ?> <!--Si existe la session "logged" muestra los botones de abajo -->

    <div class="col-lg-10">
      <a href="index.php" class="btn btn-primary">Home</a>
      <a href="crear.php" class="btn btn-primary">Crear nuevo usuario</a>
    </div>

    <div class="col-lg-2">
      <!-- <?php echo "Bienvenido ".$_SESSION["logged"]["name"]." ".$_SESSION["logged"]["surname"];?> -->
      <a href="logout.php" class="btn btn-primary">Cerrar Sesión</a>
    </div>
    <div class="clearfix"></div>
    <br/> 
  <?php }?>
  <?php $variabe = "Contenido"; ?>

</head>
