<?php
$msg = '';
$error = '';
if (isset($_POST['submit'])) {
    $address = $_POST['address'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $sql = "update tblcontactusinfo set Address=:address,EmailId=:email,ContactNo=:contactno";
    $query = $dbh->prepare($sql);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':contactno', $contactno, PDO::PARAM_STR);
    $query->execute();
    $msg = "Actualizado correctamente";
}
?>
<h2 class="page-title">Actualizar Información de Contacto</h2>

<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading">Contacto</div>
			<div class="panel-body">
				<form method="post" name="chngpwd" class="form-horizontal">

				<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
				else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>
				<?php $sql = "SELECT * from  tblcontactusinfo ";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>

				<div class="form-group">
						<label class="col-sm-4 control-label"> Dirección</label>
						<div class="col-sm-8">
							<textarea class="form-control" name="address" id="address" required><?= htmlentities($result->Address); ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label"> Correo</label>
						<div class="col-sm-8">
							<input type="email" class="form-control" name="email" id="email" value="<?= htmlentities($result->EmailId); ?>" required>
						</div>
					</div>
<div class="form-group">
						<label class="col-sm-4 control-label"> Celular </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?= htmlentities($result->ContactNo); ?>" name="contactno" id="contactno" required>
						</div>
					</div>
<?php }
} ?>
					<div class="hr-dashed"></div>

					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-4">
							<button class="btn btn-primary" name="submit" type="submit">Actualizar</button>
						</div>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>
