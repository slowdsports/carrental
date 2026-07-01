<h2 class="page-title">Reservas Canceladas</h2>

<div class="panel panel-default">
	<div class="panel-heading">Detalles de reserva</div>
	<div class="panel-body">

		<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
			<thead>
				<tr>
				<th>#</th>
					<th>Nombre</th>
					<th># Reserva</th>
					<th>Vehículo</th>
					<th>Desde</th>
					<th>Hasta</th>
					<th>Estado</th>
					<th>Fecha</th>
					<th>Acción</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
				<th>#</th>
					<th>Nombre</th>
					<th># Reserva</th>
					<th>Vehículo</th>
					<th>Desde</th>
					<th>Hasta</th>
					<th>Estado</th>
					<th>Fecha</th>
					<th>Acción</th>
				</tr>
			</tfoot>
			<tbody>

			<?php
$status = 2;
$sql = "SELECT tblusers.FullName,tblbooking.GuestName,tblbooking.userEmail,tblbrands.BrandName,tblvehicles.VehiclesTitle,tblbooking.FromDate,tblbooking.ToDate,tblbooking.message,tblbooking.VehicleId as vid,tblbooking.Status,tblbooking.PostingDate,tblbooking.id,tblbooking.BookingNumber FROM tblbooking JOIN tblvehicles ON tblvehicles.id=tblbooking.VehicleId LEFT JOIN tblusers ON tblusers.EmailId=tblbooking.userEmail JOIN tblbrands ON tblvehicles.VehiclesBrand=tblbrands.id WHERE tblbooking.Status=:status";
$query = $dbh->prepare($sql);
$query->bindParam(':status', $status, PDO::PARAM_STR);
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
					<td><?= htmlentities($result->BookingNumber); ?></td>
					<td><a href="?p=edit-vehicle&id=<?= htmlentities($result->vid); ?>"><?= htmlentities($result->BrandName); ?> <?= htmlentities($result->VehiclesTitle); ?></a></td>
					<td><?= htmlentities($result->FromDate); ?></td>
					<td><?= htmlentities($result->ToDate); ?></td>
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
				<td>
<a href="?p=bookig-details&bid=<?= htmlentities($result->id); ?>"> Detalles</a>
</td>
				</tr>
				<?php $cnt = $cnt + 1; }
} ?>

			</tbody>
		</table>

	</div>
</div>
