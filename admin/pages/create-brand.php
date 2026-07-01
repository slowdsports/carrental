<?php
$msg = '';
$error = '';
if (isset($_POST['submit'])) {
    $brand = $_POST['brand'];
    $sql = "INSERT INTO  tblbrands(BrandName) VALUES(:brand)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':brand', $brand, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        $msg = "Marca creada con éxito";
    } else {
        $error = "Algo no funcionó bien. Por favor inténtalo nuevamente";
    }
}
?>
<h2 class="page-title">Crear Marca</h2>

<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading">Crear marca</div>
			<div class="panel-body">
				<form method="post" name="chngpwd" class="form-horizontal">

				<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
				else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>
					<div class="form-group">
						<label class="col-sm-4 control-label">Nombre</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="brand" id="brand" required>
						</div>
					</div>
					<div class="hr-dashed"></div>

					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-4">
							<button class="btn btn-primary" name="submit" type="submit">Agregar</button>
						</div>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>
