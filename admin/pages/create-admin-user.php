<?php
if (($_SESSION['arolename'] ?? '') !== 'Super Admin') {
    echo '<div class="alert alert-warning">No tienes permiso para acceder a esta sección.</div>';
    return;
}

$msg = '';
$error = '';
if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $fullname = trim($_POST['fullname']);
    $password = md5($_POST['password']);
    $roleid = intval($_POST['roleid']);

    $check = $dbh->prepare("SELECT id FROM admin WHERE UserName=:username");
    $check->bindParam(':username', $username, PDO::PARAM_STR);
    $check->execute();
    if ($check->rowCount() > 0) {
        $error = "Ya existe un usuario con ese nombre de usuario.";
    } else {
        $sql = "INSERT INTO admin(UserName,FullName,Password,RoleId) VALUES(:username,:fullname,:password,:roleid)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':roleid', $roleid, PDO::PARAM_INT);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $msg = "Usuario creado con éxito";
        } else {
            $error = "Algo no funcionó bien. Por favor inténtalo nuevamente";
        }
    }
}
?>
<h2 class="page-title">Crear Usuario del Panel Admin</h2>

<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading">Nuevo usuario</div>
			<div class="panel-body">
				<form method="post" class="form-horizontal">

				<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
				else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nombre completo</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="fullname" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Usuario <span style="color:red">*</span></label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="username" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Contraseña <span style="color:red">*</span></label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="password" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Rol <span style="color:red">*</span></label>
						<div class="col-sm-9">
							<select class="selectpicker" name="roleid" required>
								<option value="">Seleccionar</option>
								<?php $roles = $dbh->query("SELECT * FROM tbladminroles ORDER BY id ASC")->fetchAll(PDO::FETCH_OBJ);
								foreach ($roles as $role) { ?>
								<option value="<?= $role->id; ?>"><?= htmlentities($role->RoleName); ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="hr-dashed"></div>

					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3">
							<a href="?p=manage-admin-users" class="btn btn-default">Volver</a>
							<button class="btn btn-primary" name="submit" type="submit">Agregar</button>
						</div>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>
