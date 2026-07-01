<?php
$msg = '';
$error = '';
if (isset($_POST['submit'])) {
    $password = md5($_POST['password']);
    $newpassword = md5($_POST['newpassword']);
    $username = $_SESSION['alogin'];
    $sql = "SELECT Password FROM admin WHERE UserName=:username and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        $con = "update admin set Password=:newpassword where UserName=:username";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1->bindParam(':username', $username, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();
        $msg = "Tu contraseña se cambió correctamente";
    } else {
        $error = "Tu contraseña actual no es válida.";
    }
}
?>
<script type="text/javascript">
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("Los campos de nueva contraseña y confirmar contraseña no coinciden!!");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>
<h2 class="page-title">Cambiar Contraseña</h2>

<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading">Datos del formulario</div>
			<div class="panel-body">
				<form method="post" name="chngpwd" class="form-horizontal" onSubmit="return valid();">

				<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
				else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>
					<div class="form-group">
						<label class="col-sm-4 control-label">Contraseña actual</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" name="password" id="password" required>
						</div>
					</div>
					<div class="hr-dashed"></div>

					<div class="form-group">
						<label class="col-sm-4 control-label">Nueva contraseña</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" name="newpassword" id="newpassword" required>
						</div>
					</div>
					<div class="hr-dashed"></div>

					<div class="form-group">
						<label class="col-sm-4 control-label">Confirmar contraseña</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" name="confirmpassword" id="confirmpassword" required>
						</div>
					</div>
					<div class="hr-dashed"></div>

					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-4">
							<button class="btn btn-primary" name="submit" type="submit">Guardar cambios</button>
						</div>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>
