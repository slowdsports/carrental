<?php
$msg = '';
$error = '';
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
    $vimage1 = $_FILES["img1"]["name"];
    $vimage2 = $_FILES["img2"]["name"];
    $vimage3 = $_FILES["img3"]["name"];
    $vimage4 = $_FILES["img4"]["name"];
    $vimage5 = $_FILES["img5"]["name"];
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
    move_uploaded_file($_FILES["img1"]["tmp_name"], ADMIN_ROOT . "img/vehicleimages/" . $_FILES["img1"]["name"]);
    move_uploaded_file($_FILES["img2"]["tmp_name"], ADMIN_ROOT . "img/vehicleimages/" . $_FILES["img2"]["name"]);
    move_uploaded_file($_FILES["img3"]["tmp_name"], ADMIN_ROOT . "img/vehicleimages/" . $_FILES["img3"]["name"]);
    move_uploaded_file($_FILES["img4"]["tmp_name"], ADMIN_ROOT . "img/vehicleimages/" . $_FILES["img4"]["name"]);
    move_uploaded_file($_FILES["img5"]["tmp_name"], ADMIN_ROOT . "img/vehicleimages/" . $_FILES["img5"]["name"]);

    $sql = "INSERT INTO tblvehicles(VehiclesTitle,VehiclesBrand,VehiclesOverview,PricePerDay,FuelType,ModelYear,SeatingCapacity,TransmissionType,VehicleCategory,Vimage1,Vimage2,Vimage3,Vimage4,Vimage5,AirConditioner,StabilityControl,AntiLockBrakingSystem,BrakeAssist,PowerSteering,DriverAirbag,PassengerAirbag,PowerWindows,CarplayAndroidAuto,RearCamera,ParkingSensor,LeatherSeats) VALUES(:vehicletitle,:brand,:vehicleoverview,:priceperday,:fueltype,:modelyear,:seatingcapacity,:transmissiontype,:vehiclecategory,:vimage1,:vimage2,:vimage3,:vimage4,:vimage5,:airconditioner,:stabilitycontrol,:antilockbrakingsys,:brakeassist,:powersteering,:driverairbag,:passengerairbag,:powerwindow,:carplayandroidauto,:rearcamera,:parkingsensor,:leatherseats)";
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
    $query->bindParam(':vimage1', $vimage1, PDO::PARAM_STR);
    $query->bindParam(':vimage2', $vimage2, PDO::PARAM_STR);
    $query->bindParam(':vimage3', $vimage3, PDO::PARAM_STR);
    $query->bindParam(':vimage4', $vimage4, PDO::PARAM_STR);
    $query->bindParam(':vimage5', $vimage5, PDO::PARAM_STR);
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
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        $msg = "Vehículo agregado satisfactoriamente";
    } else {
        $error = "Algo no funcionó bien. Por favor inténtalo nuevamente";
    }
}
?>
<h2 class="page-title">Agregar vehículo</h2>

<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>

<form method="post" class="form-horizontal" enctype="multipart/form-data">

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Información básica</div>
			<div class="panel-body">
<div class="form-group">
<label class="col-sm-2 control-label">Modelo del vehículo<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="vehicletitle" class="form-control" required>
</div>
<label class="col-sm-2 control-label">Seleccionar marca<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="brandname" required>
<option value=""> Seleccionar </option>
<?php $ret = "select id,BrandName from tblbrands";
$query = $dbh->prepare($ret);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
    foreach ($results as $result) {
?>
<option value="<?= htmlentities($result->id); ?>"><?= htmlentities($result->BrandName); ?></option>
<?php }
} ?>

</select>
</div>
</div>

<div class="hr-dashed"></div>
<div class="form-group">
<label class="col-sm-2 control-label">Detalles del vehículo<span style="color:red">*</span></label>
<div class="col-sm-10">
<textarea class="form-control" name="vehicalorcview" rows="3" required></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Precio por día<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="priceperday" class="form-control" required>
</div>
<label class="col-sm-2 control-label">Tipo de combustible<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="fueltype" required>
<option value=""> Seleccionar </option>

<option value="Gasolina">Gasolina</option>
<option value="Diesel">Diesel</option>
<option value="Electrico">Electrico</option>
</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Año<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="modelyear" class="form-control" required>
</div>
<label class="col-sm-2 control-label">Capacidad de pasajeros<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="seatingcapacity" class="form-control" required>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Tipo de transmisión<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="transmissiontype" required>
<option value="">Seleccionar</option>
<option value="Automatico">Automático</option>
<option value="Manual">Manual</option>
</select>
</div>
<label class="col-sm-2 control-label">Categoría<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="vehiclecategory" required>
<option value="">Seleccionar</option>
<option value="Sedán">Sedán</option>
<option value="Hatchback">Hatchback</option>
<option value="SUV">SUV</option>
<option value="Pickup">Pickup</option>
<option value="Furgón">Furgón</option>
<option value="Lujo">Lujo</option>
</select>
</div>
</div>
<div class="hr-dashed"></div>


<div class="form-group">
<div class="col-sm-12">
<h4><b>Subir imágenes</b></h4>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
Imagen 1 <span style="color:red">*</span><input type="file" name="img1" required>
</div>
<div class="col-sm-4">
Imagen 2<span style="color:red">*</span><input type="file" name="img2" required>
</div>
<div class="col-sm-4">
Imagen 3<span style="color:red">*</span><input type="file" name="img3" required>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
Imagen 4<span style="color:red">*</span><input type="file" name="img4" required>
</div>
<div class="col-sm-4">
Imagen 5<input type="file" name="img5">
</div>

</div>
			</div>
		</div>
	</div>
</div>


<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
<div class="panel-heading">Accesorios</div>
<div class="panel-body">


<div class="form-group">
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="airconditioner" name="airconditioner" value="1">
<label for="airconditioner"> Aire acondicionado </label>
</div>
</div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="stabilitycontrol" name="stabilitycontrol" value="1">
<label for="stabilitycontrol"> Control de Estabilidad (ESP / VSC) </label>
</div></div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="antilockbrakingsys" name="antilockbrakingsys" value="1">
<label for="antilockbrakingsys"> AntiLock Braking System (ABS) </label>
</div></div>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="brakeassist" name="brakeassist" value="1">
<label for="brakeassist"> Brake Assist </label>
</div>
</div>



<div class="form-group">
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="powersteering" name="powersteering" value="1">
<label for="powersteering"> Power Steering </label>
</div>
</div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="driverairbag" name="driverairbag" value="1">
<label for="driverairbag">Bolsa de aire conductor</label>
</div>
</div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="passengerairbag" name="passengerairbag" value="1">
<label for="passengerairbag">Bolsa de aire pasajero</label>
</div></div>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="powerwindow" name="powerwindow" value="1">
<label for="powerwindow">Ventas eléctricas</label>
</div>
</div>


<div class="form-group">
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="carplayandroidauto" name="carplayandroidauto" value="1">
<label for="carplayandroidauto"> Carplay y/o Android Auto </label>
</div>
</div>
<div class="col-sm-3">
<div class="checkbox h checkbox-inline">
<input type="checkbox" id="rearcamera" name="rearcamera" value="1">
<label for="rearcamera">Cámara de reversa</label>
</div></div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="parkingsensor" name="parkingsensor" value="1">
<label for="parkingsensor">Sensor de parqueo</label>
</div></div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="leatherseats" name="leatherseats" value="1">
<label for="leatherseats">Asientos de cuero</label>
</div>
</div>
</div>


			<div class="form-group">
				<div class="col-sm-8 col-sm-offset-2">
					<button class="btn btn-default" type="reset">Cancelar</button>
					<button class="btn btn-primary" name="submit" type="submit">Guardar</button>
				</div>
			</div>

	</div>
	</div>
</div>
</div>

</form>
