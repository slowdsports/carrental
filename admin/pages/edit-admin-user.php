<?php
if (($_SESSION['arolename'] ?? '') !== 'Super Admin') {
    echo '<div class="alert alert-warning">No tienes permiso para acceder a esta sección.</div>';
    return;
}

$msg = '';
$error = '';
$id = intval($_GET['id']);

if (isset($_POST['submit'])) {
    $fullname = trim($_POST['fullname']);
    $roleid = intval($_POST['roleid']);
    $newpassword = trim($_POST['newpassword']);

    $sql = "UPDATE admin SET FullName=:fullname, RoleId=:roleid WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
    $query->bindParam(':roleid', $roleid, PDO::PARAM_INT);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();

    if ($newpassword !== '') {
        $hashed = md5($newpassword);
        $pwQuery = $dbh->prepare("UPDATE admin SET Password=:password WHERE id=:id");
        $pwQuery->bindParam(':password', $hashed, PDO::PARAM_STR);
        $pwQuery->bindParam(':id', $id, PDO::PARAM_INT);
        $pwQuery->execute();
    }

    $msg = "Actualizado correctamente";
}

$query = $dbh->prepare("SELECT * FROM admin WHERE id=:id");
$query->bindParam(':id', $id, PDO::PARAM_INT);
$query->execute();
$adminUser = $query->fetch(PDO::FETCH_OBJ);

if (!$adminUser) {
    echo "<script type='text/javascript'> document.location = 'index.php?p=manage-admin-users'; </script>";
    return;
}
?>
<h2 class="page-title">Editar Usuario: <?= htmlentities($adminUser->UserName); ?></h2>

<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading">Datos del usuario</div>
			<div class="panel-body">
				<form method="post" class="form-horizontal">

				<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
				else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>
					<div class="form-group">
						<label class="col-sm-3 control-label">Usuario</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" value="<?= htmlentities($adminUser->UserName); ?>" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nombre completo</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="fullname" value="<?= htmlentities($adminUser->FullName); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Rol <span style="color:red">*</span></label>
						<div class="col-sm-9">
							<select class="selectpicker" name="roleid" required>
								<?php $roles = $dbh->query("SELECT * FROM tbladminroles ORDER BY id ASC")->fetchAll(PDO::FETCH_OBJ);
								foreach ($roles as $role) { ?>
								<option value="<?= $role->id; ?>" <?= ($adminUser->RoleId == $role->id) ? 'selected' : ''; ?>><?= htmlentities($role->RoleName); ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nueva contraseña</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="newpassword" placeholder="Dejar en blanco para no cambiarla">
						</div>
					</div>
					<div class="hr-dashed"></div>

					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3">
							<a href="?p=manage-admin-users" class="btn btn-default">Volver</a>
							<button class="btn btn-primary" name="submit" type="submit">Guardar cambios</button>
						</div>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>
