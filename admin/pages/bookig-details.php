<?php
if (isset($_REQUEST['eid'])) {
    $eid = intval($_GET['eid']);
    $status = "2";
    $sql = "UPDATE tblbooking SET Status=:status WHERE  id=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();
    echo "<script>Swal.fire('Reserva cancelada correctamente').then(function(){ document.location = 'index.php?p=canceled-bookings'; });</script>";
    return;
}

if (isset($_REQUEST['aeid'])) {
    $aeid = intval($_GET['aeid']);
    $status = 1;
    $sql = "UPDATE tblbooking SET Status=:status WHERE  id=:aeid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
    $query->execute();
    echo "<script>Swal.fire('Se ha confirmado la reserva').then(function(){ document.location = 'index.php?p=confirmed-bookings'; });</script>";
    return;
}
?>
<h2 class="page-title">Detalles de Reserva</h2>

<div class="panel panel-default">
	<div class="panel-heading">Información de Reserva</div>
	<div class="panel-body">

<div id="print">
		<table border="1" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">

			<tbody>

			<?php
$bid = intval($_GET['bid']);
$sql = "SELECT tblusers.FullName,tblusers.ContactNo,tblusers.Address,tblusers.City,tblusers.Country,
tblbooking.GuestName,tblbooking.userEmail,tblbooking.message,tblbooking.VehicleId as vid,tblbooking.Status,tblbooking.PostingDate,tblbooking.id,tblbooking.BookingNumber,tblbooking.LastUpdationDate,
tblbrands.BrandName,tblvehicles.VehiclesTitle,tblbooking.FromDate,tblbooking.ToDate,
DATEDIFF(tblbooking.ToDate,tblbooking.FromDate) as totalnodays,tblvehicles.PricePerDay
FROM tblbooking JOIN tblvehicles ON tblvehicles.id=tblbooking.VehicleId LEFT JOIN tblusers ON tblusers.EmailId=tblbooking.userEmail JOIN tblbrands ON tblvehicles.VehiclesBrand=tblbrands.id WHERE tblbooking.id=:bid";
$query = $dbh->prepare($sql);
$query->bindParam(':bid', $bid, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
	<h3 style="text-align:center; color:red">Reserva #<?= htmlentities($result->BookingNumber); ?> </h3>

		<?php $isGuest = empty($result->FullName); ?>
					<tr>
						<th colspan="4" style="text-align:center;color:blue">
							Detalles de <?= $isGuest ? 'Invitado' : 'Usuario'; ?>
							<?php if ($isGuest): ?><span class="label label-info" style="font-size:12px;margin-left:6px">Invitado</span><?php endif; ?>
						</th>
					</tr>
					<tr>
						<th># Reserva</th>
						<td>#<?= htmlentities($result->BookingNumber); ?></td>
						<th>Nombre</th>
						<td><?= htmlentities($isGuest ? ($result->GuestName ?: '—') : $result->FullName); ?></td>
					</tr>
					<tr>
						<th>Correo</th>
						<td><?= htmlentities($result->userEmail); ?></td>
						<th>Celular</th>
						<td><?= htmlentities($isGuest ? '—' : ($result->ContactNo ?: '—')); ?></td>
					</tr>
					<?php if (!$isGuest): ?>
					<tr>
						<th>Dirección</th>
						<td><?= htmlentities($result->Address ?: '—'); ?></td>
						<th>Ciudad</th>
						<td><?= htmlentities($result->City ?: '—'); ?></td>
					</tr>
					<tr>
						<th>País</th>
						<td colspan="3"><?= htmlentities($result->Country ?: '—'); ?></td>
					</tr>
					<?php endif; ?>

					<tr>
						<th colspan="4" style="text-align:center;color:blue">Detalles de Reserva</th>
					</tr>
						<tr>
						<th>Vehículo</th>
						<td><a href="?p=edit-vehicle&id=<?= htmlentities($result->vid); ?>"><?= htmlentities($result->BrandName); ?> <?= htmlentities($result->VehiclesTitle); ?></a></td>
						<th>Fecha de Reserva</th>
						<td><?= htmlentities($result->PostingDate); ?></td>
					</tr>
					<tr>
						<th>Desde</th>
						<td><?= htmlentities($result->FromDate); ?></td>
						<th>Hasta</th>
						<td><?= htmlentities($result->ToDate); ?></td>
					</tr>
<tr>
	<th>Total</th>
	<td><?= htmlentities($tdays = $result->totalnodays); ?></td>
	<th>Valor Diario</th>
	<td><?= htmlentities($ppdays = $result->PricePerDay); ?></td>
</tr>
<tr>
	<th colspan="3" style="text-align:center">Total</th>
	<td><?= htmlentities($tdays * $ppdays); ?></td>
</tr>
<tr>
<th>Estado de Reserva</th>
<td><?php
if ($result->Status == 0) {
    echo htmlentities('Not Confirmed yet');
} else if ($result->Status == 1) {
    echo htmlentities('Confirmed');
} else {
    echo htmlentities('Cancelled');
}
?></td>
					<th>Fecha de actualización</th>
					<td><?= htmlentities($result->LastUpdationDate); ?></td>
				</tr>

				<?php if ($result->Status == 0) { ?>
					<tr>
					<td style="text-align:center" colspan="4">
<a href="?p=bookig-details&aeid=<?= htmlentities($result->id); ?>" data-confirm="¿Desea confirmar esta reserva?" class="btn btn-primary"> Confirmar Reserva</a>

<a href="?p=bookig-details&eid=<?= htmlentities($result->id); ?>" data-confirm="¿Desea cancelar esta reserva?" class="btn btn-danger"> Cancelar Reserva</a>
</td>
</tr>
<?php } ?>
				<?php }
} ?>

			</tbody>
		</table>
		<form method="post">
   <input name="Submit2" type="submit" class="txtbox4" value="Imprimir" onClick="return f3();" style="cursor: pointer;" />
</form>

	</div>
</div>
</div>
<script language="javascript" type="text/javascript">
function f3()
{
window.print();
}
</script>
