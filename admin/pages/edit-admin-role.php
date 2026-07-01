<?php
if (($_SESSION['arolename'] ?? '') !== 'Super Admin') {
    echo '<div class="alert alert-warning">No tienes permiso para acceder a esta sección.</div>';
    return;
}

$msg = '';
$error = '';
$id = intval($_GET['id']);

$query = $dbh->prepare("SELECT * FROM tbladminroles WHERE id=:id");
$query->bindParam(':id', $id, PDO::PARAM_INT);
$query->execute();
$role = $query->fetch(PDO::FETCH_OBJ);

if (!$role) {
    echo "<script type='text/javascript'> document.location = 'index.php?p=manage-admin-roles'; </script>";
    return;
}

if (isset($_POST['submit'])) {
    if ($role->RoleName === 'Super Admin') {
        $error = "El rol 'Super Admin' no se puede renombrar.";
    } else {
        $rolename = trim($_POST['rolename']);
        $sql = "UPDATE tbladminroles SET RoleName=:rolename WHERE id=:id";
        $upd = $dbh->prepare($sql);
        $upd->bindParam(':rolename', $rolename, PDO::PARAM_STR);
        $upd->bindParam(':id', $id, PDO::PARAM_INT);
        $upd->execute();
        $role->RoleName = $rolename;
        $msg = "Actualizado correctamente";
    }
}
?>
<h2 class="page-title">Editar Rol</h2>

<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading">Actualizar rol</div>
			<div class="panel-body">
				<form method="post" class="form-horizontal">

				<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
				else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nombre del rol <span style="color:red">*</span></label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="rolename" value="<?= htmlentities($role->RoleName); ?>" <?= ($role->RoleName === 'Super Admin') ? 'disabled' : ''; ?> required>
						</div>
					</div>
					<div class="hr-dashed"></div>

					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3">
							<a href="?p=manage-admin-roles" class="btn btn-default">Volver</a>
							<?php if ($role->RoleName !== 'Super Admin') { ?>
							<button class="btn btn-primary" name="submit" type="submit">Guardar cambios</button>
							<?php } ?>
						</div>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>
