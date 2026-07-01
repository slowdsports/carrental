<?php
$msg = '';
$error = '';
if (isset($_REQUEST['del'])) {
    $delid = intval($_GET['del']);
    $sql = "delete from tblvehicles  WHERE  id=:delid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':delid', $delid, PDO::PARAM_STR);
    $query->execute();
    $msg = "Vehículo eliminado correctamente";
}
?>
<h2 class="page-title">Editar Vehículos</h2>

<div class="panel panel-default">
	<div class="panel-heading">Detalle de vehículos</div>
	<div class="panel-body">
	<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
	else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>
		<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
			<thead>
				<tr>
				<th>#</th>
					<th>Modelo</th>
					<th>Marca</th>
					<th>Precio/Día</th>
					<th>Combustible</th>
					<th>Año</th>
					<th>Acción</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
				<th>#</th>
				<th>Modelo</th>
					<th>Marca</th>
					<th>Precio/Día</th>
					<th>Combustible</th>
					<th>Año</th>
					<th>Acción</th>
				</tr>
			</tfoot>
			<tbody>

<?php $sql = "SELECT tblvehicles.VehiclesTitle,tblbrands.BrandName,tblvehicles.PricePerDay,tblvehicles.FuelType,tblvehicles.ModelYear,tblvehicles.id from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
				<tr>
					<td><?= htmlentities($cnt); ?></td>
					<td><?= htmlentities($result->VehiclesTitle); ?></td>
					<td><?= htmlentities($result->BrandName); ?></td>
					<td><?= htmlentities($result->PricePerDay); ?></td>
					<td><?= htmlentities($result->FuelType); ?></td>
						<td><?= htmlentities($result->ModelYear); ?></td>
		<td><a href="?p=edit-vehicle&id=<?= $result->id; ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
<a href="?p=manage-vehicles&del=<?= $result->id; ?>" data-confirm="¿Desea eliminar este vehículo?"><i class="fa fa-close"></i></a></td>
				</tr>
				<?php $cnt = $cnt + 1; }
} ?>

			</tbody>
		</table>

	</div>
</div>
