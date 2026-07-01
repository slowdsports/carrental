<?php
if (($_SESSION['arolename'] ?? '') !== 'Super Admin') {
    echo '<div class="alert alert-warning">No tienes permiso para acceder a esta sección.</div>';
    return;
}

$msg = '';
$error = '';
if (isset($_POST['submit'])) {
    $rolename = trim($_POST['rolename']);
    $sql = "INSERT INTO tbladminroles(RoleName) VALUES(:rolename)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rolename', $rolename, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        $msg = "Rol creado con éxito";
    } else {
        $error = "Algo no funcionó bien. Por favor inténtalo nuevamente";
    }
}
?>
<h2 class="page-title">Crear Rol</h2>

<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading">Nuevo rol</div>
			<div class="panel-body">
				<form method="post" class="form-horizontal">

				<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
				else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nombre del rol <span style="color:red">*</span></label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="rolename" placeholder="Ej: Soporte, Editor de contenido" required>
						</div>
					</div>
					<div class="hr-dashed"></div>

					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3">
							<a href="?p=manage-admin-roles" class="btn btn-default">Volver</a>
							<button class="btn btn-primary" name="submit" type="submit">Agregar</button>
						</div>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>
