<h2 class="page-title">Usuarios Registrados</h2>

<div class="panel panel-default">
	<div class="panel-heading">Tabla de usuarios</div>
	<div class="panel-body">
		<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
			<thead>
				<tr>
				<th>#</th>
					<th> Nombre</th>
					<th>Correo</th>
					<th>Número</th>
				<th>Fecha Nacimiento</th>
				<th>Dirección</th>
				<th>Ciudad</th>
				<th>País</th>
				<th>Fecha Registro</th>

				</tr>
			</thead>
			<tfoot>
				<tr>
				<th>#</th>
					<th> Nombre</th>
					<th>Correo</th>
					<th>Número</th>
				<th>Fecha Nacimiento</th>
				<th>Dirección</th>
				<th>Ciudad</th>
				<th>País</th>
				<th>Fecha Registro</th>
				</tr>
			</tfoot>
			<tbody>

			<?php $sql = "SELECT * from  tblusers ";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
				<tr>
					<td><?= htmlentities($cnt); ?></td>
					<td><?= htmlentities($result->FullName); ?></td>
					<td><?= htmlentities($result->EmailId); ?></td>
					<td><?= htmlentities($result->ContactNo); ?></td>
	<td><?= htmlentities($result->dob); ?></td>
					<td><?= htmlentities($result->Address); ?></td>
					<td><?= htmlentities($result->City); ?></td>
					<td><?= htmlentities($result->Country); ?></td>
					<td><?= htmlentities($result->RegDate); ?></td>
				</tr>
				<?php $cnt = $cnt + 1; }
} ?>

			</tbody>
		</table>

	</div>
</div>
