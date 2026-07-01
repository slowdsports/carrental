<?php
$msg = '';
$error = '';
if (isset($_REQUEST['eid'])) {
    $eid = intval($_GET['eid']);
    $status = "2";
    $sql = "UPDATE tblbooking SET Status=:status WHERE  id=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();
    $msg = "Reserva cancelada correctamente";
}

if (isset($_REQUEST['aeid'])) {
    $aeid = intval($_GET['aeid']);
    $status = 1;
    $sql = "UPDATE tblbooking SET Status=:status WHERE  id=:aeid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
    $query->execute();
    $msg = "Reserva confirmada correctamente";
}
?>
<h2 class="page-title">Reservas</h2>

<div class="panel panel-default">
	<div class="panel-heading">Información de reservas</div>
	<div class="panel-body">
	<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
	else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>
		<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
			<thead>
				<tr>
				<th>#</th>
					<th>Nombre</th>
					<th>Vehículo</th>
					<th>Desde</th>
					<th>Hasta</th>
					<th>Mensaje</th>
					<th>Estado</th>
					<th>Fecha</th>
					<th>Acción</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
				<th>#</th>
				<th>Nombre</th>
					<th>Vehículo</th>
					<th>Desde</th>
					<th>Hasta</th>
					<th>Mensaje</th>
					<th>Estado</th>
					<th>Fecha</th>
					<th>Acción</th>
				</tr>
			</tfoot>
			<tbody>

			<?php $sql = "SELECT tblusers.FullName,tblbooking.GuestName,tblbooking.userEmail,tblbrands.BrandName,tblvehicles.VehiclesTitle,tblbooking.FromDate,tblbooking.ToDate,tblbooking.message,tblbooking.VehicleId as vid,tblbooking.Status,tblbooking.PostingDate,tblbooking.id FROM tblbooking JOIN tblvehicles ON tblvehicles.id=tblbooking.VehicleId LEFT JOIN tblusers ON tblusers.EmailId=tblbooking.userEmail JOIN tblbrands ON tblvehicles.VehiclesBrand=tblbrands.id";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
				<tr>
					<td><?= htmlentities($cnt); ?></td>
					<td><?php
$displayName = $result->FullName ?: ($result->GuestName ?: $result->userEmail);
echo htmlentities($displayName);
if (!$result->FullName) echo ' <span class="label label-info">Invitado</span>';
?></td>
					<td><a href="?p=edit-vehicle&id=<?= htmlentities($result->vid); ?>"><?= htmlentities($result->BrandName); ?> , <?= htmlentities($result->VehiclesTitle); ?></a></td>
					<td><?= htmlentities($result->FromDate); ?></td>
					<td><?= htmlentities($result->ToDate); ?></td>
					<td><?= htmlentities($result->message); ?></td>
					<td><?php
if ($result->Status == 0) {
    echo htmlentities('Not Confirmed yet');
} else if ($result->Status == 1) {
    echo htmlentities('Confirmed');
} else {
    echo htmlentities('Cancelled');
}
?></td>
					<td><?= htmlentities($result->PostingDate); ?></td>
				<td><a href="?p=manage-bookings&aeid=<?= htmlentities($result->id); ?>" data-confirm="¿Desea confirmar esta reserva?"> Confirmar</a> /
<a href="?p=manage-bookings&eid=<?= htmlentities($result->id); ?>" data-confirm="¿Desea cancelar esta reserva?"> Cancelar</a>
</td>
				</tr>
				<?php $cnt = $cnt + 1; }
} ?>

			</tbody>
		</table>

	</div>
</div>
