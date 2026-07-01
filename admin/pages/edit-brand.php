<?php
$msg = '';
$error = '';
if (isset($_POST['submit'])) {
    $brand = $_POST['brand'];
    $id = $_GET['id'];
    $sql = "update  tblbrands set BrandName=:brand where id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':brand', $brand, PDO::PARAM_STR);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $msg = "Actualizado correctamente";
}
?>
<h2 class="page-title">Actualizar Marca</h2>

<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading">Actualizar marca</div>
			<div class="panel-body">
				<form method="post" name="chngpwd" class="form-horizontal">

				<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
				else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>

<?php
$id = $_GET['id'];
$ret = "select * from tblbrands where id=:id";
$query = $dbh->prepare($ret);
$query->bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
    foreach ($results as $result) {
?>

					<div class="form-group">
						<label class="col-sm-4 control-label">Nombre</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?= htmlentities($result->BrandName); ?>" name="brand" id="brand" required>
						</div>
					</div>
					<div class="hr-dashed"></div>

				<?php }
} ?>

					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-4">
							<button class="btn btn-primary" name="submit" type="submit">Editar</button>
						</div>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>
