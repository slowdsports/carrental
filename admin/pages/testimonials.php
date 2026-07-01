<?php
if (isset($_REQUEST['eid'])) {
    $eid = intval($_GET['eid']);
    $status = "0";
    $sql = "UPDATE tbltestimonial SET status=:status WHERE  id=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();
}

if (isset($_REQUEST['aeid'])) {
    $aeid = intval($_GET['aeid']);
    $status = 1;
    $sql = "UPDATE tbltestimonial SET status=:status WHERE  id=:aeid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
    $query->execute();
}
?>
<h2 class="page-title">Reseñas</h2>

<div class="panel panel-default">
	<div class="panel-heading">Reseñas de usuarios</div>
	<div class="panel-body">

		<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
			<thead>
				<tr>
				<th>#</th>
					<th>Nombre</th>
					<th>Correo</th>
					<th>Reseña</th>
					<th>Fecha</th>
					<th>Acción</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
				<th>#</th>
					<th>Nombre</th>
					<th>Correo</th>
					<th>Reseña</th>
					<th>Fecha</th>
					<th>Acción</th>
				</tr>
			</tfoot>
			<tbody>

			<?php $sql = "SELECT tblusers.FullName,tbltestimonial.UserEmail,tbltestimonial.Testimonial,tbltestimonial.PostingDate,tbltestimonial.status,tbltestimonial.id from tbltestimonial join tblusers on tblusers.Emailid=tbltestimonial.UserEmail";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
				<tr>
					<td><?= htmlentities($cnt); ?></td>
					<td><?= htmlentities($result->FullName); ?></td>
					<td><?= htmlentities($result->UserEmail); ?></td>
					<td><?= htmlentities($result->Testimonial); ?></td>
					<td><?= htmlentities($result->PostingDate); ?></td>
								<?php if ($result->status == "" || $result->status == 0) {
    ?><td><a href="?p=testimonials&aeid=<?= htmlentities($result->id); ?>" data-confirm="¿Desea activarla?"> Inactiva</a>
</td>
<?php } else { ?>

<td><a href="?p=testimonials&eid=<?= htmlentities($result->id); ?>" data-confirm="¿Desea desactivarla?"> Activa</a>
</td>
<?php } ?>
				</tr>
				<?php $cnt = $cnt + 1; }
} ?>

			</tbody>
		</table>

	</div>
</div>
