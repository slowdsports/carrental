<?php
if (isset($_REQUEST['eid'])) {
    $eid = intval($_GET['eid']);
    $status = 1;
    $sql = "UPDATE tblcontactusquery SET status=:status WHERE  id=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();
}
?>
<h2 class="page-title">Preguntas de Contacto</h2>

<div class="panel panel-default">
	<div class="panel-heading">Consultas de usuarios</div>
	<div class="panel-body">

		<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
			<thead>
				<tr>
				<th>#</th>
					<th>Nombre</th>
					<th>Correo</th>
					<th>Teléfono</th>
					<th>Mensaje</th>
					<th>Fecha</th>
					<th>Acción</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
				<th>#</th>
					<th>Nombre</th>
					<th>Correo</th>
					<th>Teléfono</th>
					<th>Mensaje</th>
					<th>Fecha</th>
					<th>Acción</th>
				</tr>
			</tfoot>
			<tbody>

			<?php $sql = "SELECT * from  tblcontactusquery ";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
				<tr>
					<td><?= htmlentities($cnt); ?></td>
					<td><?= htmlentities($result->name); ?></td>
					<td><?= htmlentities($result->EmailId); ?></td>
					<td><?= htmlentities($result->ContactNumber); ?></td>
					<td><?= htmlentities($result->Message); ?></td>
					<td><?= htmlentities($result->PostingDate); ?></td>
								<?php if ($result->status == 1) { ?><td>Leído</td>
<?php } else { ?>

<td><a href="?p=manage-conactusquery&eid=<?= htmlentities($result->id); ?>" data-confirm="¿Desea marcarlo como leído?">Pendiente</a>
</td>
<?php } ?>
				</tr>
				<?php $cnt = $cnt + 1; }
} ?>

			</tbody>
		</table>

	</div>
</div>
