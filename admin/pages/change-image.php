<?php
$msg = '';
$slot = intval($_GET['slot'] ?? 0);
if (!in_array($slot, [1, 2, 3, 4, 5], true)) {
    echo '<div class="alert alert-warning">Imagen inválida.</div>';
    return;
}
$column = 'Vimage' . $slot;
$fileField = 'img' . $slot;

if (isset($_POST['update'])) {
    $vimage = $_FILES[$fileField]["name"];
    $id = intval($_GET['imgid']);
    move_uploaded_file($_FILES[$fileField]["tmp_name"], ADMIN_ROOT . "img/vehicleimages/" . $vimage);
    $sql = "update tblvehicles set {$column}=:vimage where id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':vimage', $vimage, PDO::PARAM_STR);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();

    $msg = "Imagen actualizada correctamente";
}
?>
<h2 class="page-title">Imagen de Vehículo <?= $slot; ?></h2>

<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading">Detalle de Imagen <?= $slot; ?></div>
			<div class="panel-body">
				<form method="post" class="form-horizontal" enctype="multipart/form-data">

				<?php if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>

<div class="form-group">
					<label class="col-sm-4 control-label">Imagen actual <?= $slot; ?></label>
<?php
$id = intval($_GET['imgid']);
$sql = "SELECT {$column} as vimage from tblvehicles where tblvehicles.id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>

<div class="col-sm-8">
<img src="img/vehicleimages/<?= htmlentities($result->vimage); ?>" width="300" height="200" style="border:solid 1px #000">
</div>
<?php }
} ?>
</div>

					<div class="form-group">
						<label class="col-sm-4 control-label">Subir nueva imagen <?= $slot; ?><span style="color:red">*</span></label>
						<div class="col-sm-8">
					<input type="file" name="<?= $fileField; ?>" required>
						</div>
					</div>
					<div class="hr-dashed"></div>

					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-4">
							<button class="btn btn-primary" name="update" type="submit">Actualizar</button>
						</div>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>
