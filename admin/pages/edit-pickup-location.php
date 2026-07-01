<?php
$msg = '';
$error = '';
if (isset($_POST['submit'])) {
    $locationname = trim($_POST['locationname']);
    $sortorder = intval($_POST['sortorder']);
    $isactive = isset($_POST['isactive']) ? 1 : 0;
    $id = $_GET['id'];
    $sql = "update tblpickuplocations set LocationName=:locationname, SortOrder=:sortorder, IsActive=:isactive where id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':locationname', $locationname, PDO::PARAM_STR);
    $query->bindParam(':sortorder', $sortorder, PDO::PARAM_INT);
    $query->bindParam(':isactive', $isactive, PDO::PARAM_INT);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();

    $msg = "Actualizado correctamente";
}
?>
<h2 class="page-title">Actualizar Ubicación de Recogida</h2>

<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading">Actualizar ubicación</div>
			<div class="panel-body">
				<form method="post" class="form-horizontal">

				<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
				else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>

<?php
$id = $_GET['id'];
$ret = "select * from tblpickuplocations where id=:id";
$query = $dbh->prepare($ret);
$query->bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
    foreach ($results as $result) {
?>

					<div class="form-group">
						<label class="col-sm-3 control-label">Nombre <span style="color:red">*</span></label>
						<div class="col-sm-9">
							<input type="text" class="form-control" value="<?= htmlentities($result->LocationName); ?>" name="locationname" id="locationname" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Orden</label>
						<div class="col-sm-3">
							<input type="number" class="form-control" name="sortorder" value="<?= htmlentities($result->SortOrder); ?>" min="1">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Visible en el sitio</label>
						<div class="col-sm-9">
							<input type="checkbox" name="isactive" <?= ($result->IsActive) ? 'checked' : ''; ?>> Mostrar esta ubicación en el selector de la página de inicio
						</div>
					</div>
					<div class="hr-dashed"></div>

				<?php }
} ?>

					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3">
							<a href="?p=manage-pickup-locations" class="btn btn-default">Volver</a>
							<button class="btn btn-primary" name="submit" type="submit">Editar</button>
						</div>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>
