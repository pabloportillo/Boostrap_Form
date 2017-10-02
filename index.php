<?php 
include 'includes/redirect.php';
include 'includes/header.php';

//Realizamos la consulta para mostrar en la tabla de abajo

$users = mysqli_query($db, "SELECT * FROM users");

//Para la paginación
$num_total_users = mysqli_num_rows($users);

if ($num_total_users > 0) 
{
	$rows_per_page = 3;
	$page = false; //en el caso de que no exista la page

	if (isset($_GET["page"])) // si nos llega por la URL "page" 
	{
		$page = $_GET["page"];
	}

	if (!$page) //si "page" da false o no existe
 	{
		$start = 0;
		$page = 1;
	}else
	{
		$start = ($page-1) * $rows_per_page;
	}

	$total_pages = ceil($num_total_users / $rows_per_page); // ceil redondea

	//consulta para paginar con los límites que hemos sacado hasta ahora

	$sql="SELECT * FROM users ORDER BY user_id DESC LIMIT {$start}, {$rows_per_page};";
	$users = mysqli_query($db, $sql);


}else
{
	echo "No hay usuarios";
}

?>

<table class="table">

	<tr>
		<th>Nombre</th>
		<th>Apellidos</th>
		<th>Email</th>
		<th>Ver/Editar</th>
	</tr>

	<!-- este while abajo recorre todas las filas que nos devuelve la query "$users" que son todos los usuarios de la base de datos (la consulta)-->
	<?php while ($user = mysqli_fetch_assoc($users)) { ?>

		<tr>
			<td><?php echo $user["name"] 	?></td>
			<td><?php echo $user["surname"]	?></td>
			<td><?php echo $user["email"] 	?></td>
			<td>
				<a href="ver.php?id=<?php echo $user["user_id"]?>" class="btn btn-success">Ver</a> 
				<!-- A la página ver.php se le pasa por parametro el user_id -->
				<?php if (isset($_SESSION["logged"]) && $_SESSION["logged"]["role"] == "Administrador") {  ?>
					<a href="editar.php?id=<?php echo $user["user_id"]?>" class="btn btn-warning">Editar</a> <!-- A la página editar.php se le pasa por parametro el user_id. La clase de boostrap btn-warning solo la cambiamos para cambiarle el color (Success->verde, warning->rojo) -->
					<a href="borrar.php?id=<?php echo $user["user_id"]?>" class="btn btn-danger">Borrar</a> 
				<?php } ?>
			</td>
		</tr>
	<?php } ?>	<!--Cierre del bucle while -->

</table>

<!--Imprimir los links para paginar (ie. pag1, pag2, pag3 .....) -->
<?php if($num_total_users >=1) { ?>

	<ul class="pagination">
		<li><a href="?page=<?=$page-1?>"><</a></li>
		<?php for($i=1; $i <=$total_pages; $i++){?>

			<?php if($page == $i) { ?>
				<li class="disabled"><a href="#"><?=$i?></a></li>

			<?php }else { ?>
				<li><a href="?page=<?=$i?>"><?=$i?></a></li>

			<?php } ?>

		<?php }?>
		<li><a href="?page=<?php $show_page=($page+1); if($show_page <= $total_pages){ echo $show_page; }else{ echo $total_pages;};?>">></a></li>
	</ul>

<?php } ?>

<?php include 'includes/footer.php'; ?>