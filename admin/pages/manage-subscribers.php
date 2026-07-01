<?php
$msg = '';
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    $sql = "delete from  tblsubscribers  WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $msg = "Suscriptor eliminado";
}
?>
<h2 class="page-title">Suscriptores</h2>

<div class="panel panel-default">
	<div class="panel-heading">Detalle de suscriptores</div>
	<div class="panel-body">
	<?php if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>
		<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
			<thead>
				<tr>
				<th>#</th>
						<th>Correo</th>
					<th>Fecha de suscripción</th>
					<th>Acción</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
				<th>#</th>
				<th>Correo</th>
				<th>Fecha de suscripción</th>
					<th>Acción</th>
				</tr>
			</tfoot>
			<tbody>

			<?php $sql = "SELECT * from tblsubscribers";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
				<tr>
					<td><?= htmlentities($cnt); ?></td>
					<td><?= htmlentities($result->SubscriberEmail); ?></td>

					<td><?= htmlentities($result->PostingDate); ?></td>

				<td>
<a href="?p=manage-subscribers&del=<?= $result->id; ?>" data-confirm="¿Desea eliminar este suscriptor?"><i class="fa fa-close"></i></a>
</td>

				</tr>
				<?php $cnt = $cnt + 1; }
} ?>

			</tbody>
		</table>

	</div>
</div>
