<?php
$msg = '';
if (isset($_POST['submit'])) {
    $vehicletitle = $_POST['vehicletitle'];
    $brand = $_POST['brandname'];
    $vehicleoverview = $_POST['vehicalorcview'];
    $priceperday = $_POST['priceperday'];
    $fueltype = $_POST['fueltype'];
    $modelyear = $_POST['modelyear'];
    $seatingcapacity = $_POST['seatingcapacity'];
    $transmissiontype = $_POST['transmissiontype'];
    $vehiclecategory = $_POST['vehiclecategory'];
    $airconditioner = $_POST['airconditioner'];
    $stabilitycontrol = $_POST['stabilitycontrol'];
    $antilockbrakingsys = $_POST['antilockbrakingsys'];
    $brakeassist = $_POST['brakeassist'];
    $powersteering = $_POST['powersteering'];
    $driverairbag = $_POST['driverairbag'];
    $passengerairbag = $_POST['passengerairbag'];
    $powerwindow = $_POST['powerwindow'];
    $carplayandroidauto = $_POST['carplayandroidauto'];
    $rearcamera = $_POST['rearcamera'];
    $parkingsensor = $_POST['parkingsensor'];
    $leatherseats = $_POST['leatherseats'];
    $id = intval($_GET['id']);

    $sql = "update tblvehicles set VehiclesTitle=:vehicletitle,VehiclesBrand=:brand,VehiclesOverview=:vehicleoverview,PricePerDay=:priceperday,FuelType=:fueltype,ModelYear=:modelyear,SeatingCapacity=:seatingcapacity,TransmissionType=:transmissiontype,VehicleCategory=:vehiclecategory,AirConditioner=:airconditioner,StabilityControl=:stabilitycontrol,AntiLockBrakingSystem=:antilockbrakingsys,BrakeAssist=:brakeassist,PowerSteering=:powersteering,DriverAirbag=:driverairbag,PassengerAirbag=:passengerairbag,PowerWindows=:powerwindow,CarplayAndroidAuto=:carplayandroidauto,RearCamera=:rearcamera,ParkingSensor=:parkingsensor,LeatherSeats=:leatherseats where id=:id ";
    $query = $dbh->prepare($sql);
    $query->bindParam(':vehicletitle', $vehicletitle, PDO::PARAM_STR);
    $query->bindParam(':brand', $brand, PDO::PARAM_STR);
    $query->bindParam(':vehicleoverview', $vehicleoverview, PDO::PARAM_STR);
    $query->bindParam(':priceperday', $priceperday, PDO::PARAM_STR);
    $query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
    $query->bindParam(':modelyear', $modelyear, PDO::PARAM_STR);
    $query->bindParam(':seatingcapacity', $seatingcapacity, PDO::PARAM_STR);
    $query->bindParam(':transmissiontype', $transmissiontype, PDO::PARAM_STR);
    $query->bindParam(':vehiclecategory', $vehiclecategory, PDO::PARAM_STR);
    $query->bindParam(':airconditioner', $airconditioner, PDO::PARAM_STR);
    $query->bindParam(':stabilitycontrol', $stabilitycontrol, PDO::PARAM_STR);
    $query->bindParam(':antilockbrakingsys', $antilockbrakingsys, PDO::PARAM_STR);
    $query->bindParam(':brakeassist', $brakeassist, PDO::PARAM_STR);
    $query->bindParam(':powersteering', $powersteering, PDO::PARAM_STR);
    $query->bindParam(':driverairbag', $driverairbag, PDO::PARAM_STR);
    $query->bindParam(':passengerairbag', $passengerairbag, PDO::PARAM_STR);
    $query->bindParam(':powerwindow', $powerwindow, PDO::PARAM_STR);
    $query->bindParam(':carplayandroidauto', $carplayandroidauto, PDO::PARAM_STR);
    $query->bindParam(':rearcamera', $rearcamera, PDO::PARAM_STR);
    $query->bindParam(':parkingsensor', $parkingsensor, PDO::PARAM_STR);
    $query->bindParam(':leatherseats', $leatherseats, PDO::PARAM_STR);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();

    $msg = "Actualizado correctamente";
}
?>
<h2 class="page-title">Editar Vehículo</h2>

<?php if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>

<?php
$id = intval($_GET['id']);
$sql = "SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id as bid from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand where tblvehicles.id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
    foreach ($results as $result) {
?>

<form method="post" class="form-horizontal" enctype="multipart/form-data">

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Basic Info</div>
			<div class="panel-body">
<div class="form-group">
<label class="col-sm-2 control-label">Vehicle Title<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="vehicletitle" class="form-control" value="<?= htmlentities($result->VehiclesTitle) ?>" required>
</div>
<label class="col-sm-2 control-label">Select Brand<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="brandname" required>
<option value="<?= htmlentities($result->bid); ?>"><?= htmlentities($bdname = $result->BrandName); ?> </option>
<?php $ret = "select id,BrandName from tblbrands";
$query = $dbh->prepare($ret);
$query->execute();
$resultss = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
    foreach ($resultss as $results) {
        if ($results->BrandName == $bdname) {
            continue;
        } else {
?>
<option value="<?= htmlentities($results->id); ?>"><?= htmlentities($results->BrandName); ?></option>
<?php }
    }
} ?>

</select>
</div>
</div>

<div class="hr-dashed"></div>
<div class="form-group">
<label class="col-sm-2 control-label">Vehical Overview<span style="color:red">*</span></label>
<div class="col-sm-10">
<textarea class="form-control" name="vehicalorcview" rows="3" required><?= htmlentities($result->VehiclesOverview); ?></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Price Per Day(in USD)<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="priceperday" class="form-control" value="<?= htmlentities($result->PricePerDay); ?>" required>
</div>
<label class="col-sm-2 control-label">Select Fuel Type<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="fueltype" required>
<option value="<?= htmlentities($result->FuelType); ?>"> <?= htmlentities($result->FuelType); ?> </option>

<option value="Gasolina">Gasolina</option>
<option value="Diesel">Diesel</option>
<option value="Electrico">Electrico</option>
</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Model Year<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="modelyear" class="form-control" value="<?= htmlentities($result->ModelYear); ?>" required>
</div>
<label class="col-sm-2 control-label">Seating Capacity<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="seatingcapacity" class="form-control" value="<?= htmlentities($result->SeatingCapacity); ?>" required>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Tipo de transmisión<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="transmissiontype" required>
<option value="Automatico" <?= ($result->TransmissionType == 'Automatico') ? 'selected' : ''; ?>>Automático</option>
<option value="Manual" <?= ($result->TransmissionType == 'Manual') ? 'selected' : ''; ?>>Manual</option>
</select>
</div>
<label class="col-sm-2 control-label">Categoría<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="vehiclecategory" required>
<option value="">Seleccionar</option>
<?php foreach (['Sedán', 'Hatchback', 'SUV', 'Pickup', 'Furgón', 'Lujo'] as $cat) { ?>
<option value="<?= htmlentities($cat); ?>" <?= ($result->VehicleCategory == $cat) ? 'selected' : ''; ?>><?= htmlentities($cat); ?></option>
<?php } ?>
</select>
</div>
</div>
<div class="hr-dashed"></div>
<div class="form-group">
<div class="col-sm-12">
<h4><b>Vehicle Images</b></h4>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
Image 1 <img src="img/vehicleimages/<?= htmlentities($result->Vimage1); ?>" width="300" height="200" style="border:solid 1px #000">
<a href="?p=change-image&slot=1&imgid=<?= htmlentities($result->id) ?>">Change Image 1</a>
</div>
<div class="col-sm-4">
Image 2<img src="img/vehicleimages/<?= htmlentities($result->Vimage2); ?>" width="300" height="200" style="border:solid 1px #000">
<a href="?p=change-image&slot=2&imgid=<?= htmlentities($result->id) ?>">Change Image 2</a>
</div>
<div class="col-sm-4">
Image 3<img src="img/vehicleimages/<?= htmlentities($result->Vimage3); ?>" width="300" height="200" style="border:solid 1px #000">
<a href="?p=change-image&slot=3&imgid=<?= htmlentities($result->id) ?>">Change Image 3</a>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
Image 4<img src="img/vehicleimages/<?= htmlentities($result->Vimage4); ?>" width="300" height="200" style="border:solid 1px #000">
<a href="?p=change-image&slot=4&imgid=<?= htmlentities($result->id) ?>">Change Image 4</a>
</div>
<div class="col-sm-4">
Image 5
<?php if ($result->Vimage5 == "") {
    echo htmlentities("File not available");
} else { ?>
<img src="img/vehicleimages/<?= htmlentities($result->Vimage5); ?>" width="300" height="200" style="border:solid 1px #000">
<a href="?p=change-image&slot=5&imgid=<?= htmlentities($result->id) ?>">Change Image 5</a>
<?php } ?>
</div>

</div>
			</div>
		</div>
	</div>
</div>


<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
<div class="panel-heading">Accessories</div>
<div class="panel-body">


<div class="form-group">
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="airconditioner" name="airconditioner" <?= ($result->AirConditioner == 1) ? 'checked' : ''; ?> value="1">
<label for="airconditioner"> Air Conditioner </label>
</div>
</div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="stabilitycontrol" name="stabilitycontrol" <?= ($result->StabilityControl == 1) ? 'checked' : ''; ?> value="1">
<label for="stabilitycontrol"> Control de Estabilidad (ESP / VSC) </label>
</div>
</div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="antilockbrakingsys" name="antilockbrakingsys" <?= ($result->AntiLockBrakingSystem == 1) ? 'checked' : ''; ?> value="1">
<label for="antilockbrakingsys"> AntiLock Braking System </label>
</div>
</div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="brakeassist" name="brakeassist" <?= ($result->BrakeAssist == 1) ? 'checked' : ''; ?> value="1">
<label for="brakeassist"> Brake Assist </label>
</div>
</div>
</div>


<div class="form-group">
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="powersteering" name="powersteering" <?= ($result->PowerSteering == 1) ? 'checked' : ''; ?> value="1">
<label for="powersteering"> Power Steering </label>
</div>
</div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="driverairbag" name="driverairbag" <?= ($result->DriverAirbag == 1) ? 'checked' : ''; ?> value="1">
<label for="driverairbag">Driver Airbag</label>
</div>
</div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="passengerairbag" name="passengerairbag" <?= ($result->PassengerAirbag == 1) ? 'checked' : ''; ?> value="1">
<label for="passengerairbag"> Passenger Airbag </label>
</div>
</div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="powerwindow" name="powerwindow" <?= ($result->PowerWindows == 1) ? 'checked' : ''; ?> value="1">
<label for="powerwindow"> Power Windows </label>
</div>
</div>
</div>


<div class="form-group">
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="carplayandroidauto" name="carplayandroidauto" <?= ($result->CarplayAndroidAuto == 1) ? 'checked' : ''; ?> value="1">
<label for="carplayandroidauto"> Carplay y/o Android Auto </label>
</div>
</div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="rearcamera" name="rearcamera" <?= ($result->RearCamera == 1) ? 'checked' : ''; ?> value="1">
<label for="rearcamera">Cámara de reversa</label>
</div>
</div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="parkingsensor" name="parkingsensor" <?= ($result->ParkingSensor == 1) ? 'checked' : ''; ?> value="1">
<label for="parkingsensor"> Sensor de parqueo </label>
</div>
</div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="leatherseats" name="leatherseats" <?= ($result->LeatherSeats == 1) ? 'checked' : ''; ?> value="1">
<label for="leatherseats"> Leather Seats </label>
</div>
</div>
</div>

			<div class="form-group">
				<div class="col-sm-8 col-sm-offset-2">
					<button class="btn btn-primary" name="submit" type="submit" style="margin-top:4%">Save changes</button>
				</div>
			</div>

	</div>
	</div>
</div>
</div>

</form>
<?php }
} ?>
