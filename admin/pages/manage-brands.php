<?php
$msg = '';
$error = '';
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    $sql = "delete from tblbrands  WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $msg = "Marca eliminada correctamente";
}
?>
<h2 class="page-title">Marcas</h2>

<div class="panel panel-default">
	<div class="panel-heading">Lista de marcas</div>
	<div class="panel-body">
	<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
	else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>
		<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
			<thead>
				<tr>
				<th>#</th>
					<th>Nombre</th>
					<th>Creación</th>
					<th>Actualización</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
				<th>#</th>
					<th>Nombre</th>
					<th>Creación</th>
					<th>Actualización</th>
					<th>Acción</th>
				</tr>
			</tfoot>
			<tbody>

			<?php $sql = "SELECT * from  tblbrands ";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
				<tr>
					<td><?= htmlentities($cnt); ?></td>
					<td><?= htmlentities($result->BrandName); ?></td>
					<td><?= htmlentities($result->CreationDate); ?></td>
					<td><?= htmlentities($result->UpdationDate); ?></td>
<td><a href="?p=edit-brand&id=<?= $result->id; ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
<a href="?p=manage-brands&del=<?= $result->id; ?>" data-confirm="¿Desea eliminar esta marca?"><i class="fa fa-close"></i></a></td>
				</tr>
				<?php $cnt = $cnt + 1; }
} ?>

			</tbody>
		</table>

	</div>
</div>
