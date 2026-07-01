<?php
$msg = '';
$error = '';
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    $sql = "delete from tblpickuplocations  WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $msg = "Ubicación eliminada correctamente";
}

if (isset($_GET['toggle'])) {
    $id = $_GET['toggle'];
    $sql = "UPDATE tblpickuplocations SET IsActive = 1 - IsActive WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $msg = "Estado actualizado correctamente";
}
?>
<h2 class="page-title">Ubicaciones de Recogida
	<a href="?p=create-pickup-location" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Agregar Ubicación</a>
</h2>

<div class="panel panel-default">
	<div class="panel-heading">Lista de ubicaciones de recogida</div>
	<div class="panel-body">
	<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
	else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>
		<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
			<thead>
				<tr>
				<th>#</th>
					<th>Nombre</th>
					<th>Orden</th>
					<th>Visible</th>
					<th>Creación</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
				<th>#</th>
					<th>Nombre</th>
					<th>Orden</th>
					<th>Visible</th>
					<th>Creación</th>
					<th>Acción</th>
				</tr>
			</tfoot>
			<tbody>

			<?php $sql = "SELECT * from tblpickuplocations ORDER BY SortOrder ASC";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
				<tr>
					<td><?= htmlentities($cnt); ?></td>
					<td><?= htmlentities($result->LocationName); ?></td>
					<td><?= htmlentities($result->SortOrder); ?></td>
					<td>
						<a href="?p=manage-pickup-locations&toggle=<?= $result->id; ?>">
						<?php if ($result->IsActive) { ?><span class="label label-success">Sí</span><?php } else { ?><span class="label label-default">No</span><?php } ?>
						</a>
					</td>
					<td><?= htmlentities($result->CreationDate); ?></td>
<td><a href="?p=edit-pickup-location&id=<?= $result->id; ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
<a href="?p=manage-pickup-locations&del=<?= $result->id; ?>" data-confirm="¿Desea eliminar esta ubicación?"><i class="fa fa-close"></i></a></td>
				</tr>
				<?php $cnt = $cnt + 1; }
} ?>

			</tbody>
		</table>

	</div>
</div>
