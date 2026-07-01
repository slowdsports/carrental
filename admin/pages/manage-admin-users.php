<?php
if (($_SESSION['arolename'] ?? '') !== 'Super Admin') {
    echo '<div class="alert alert-warning">No tienes permiso para acceder a esta sección.</div>';
    return;
}

$msg = '';
$error = '';
if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    if ($id === intval($_SESSION['aadminid'])) {
        $error = "No puedes eliminar tu propia cuenta.";
    } else {
        $sql = "DELETE FROM admin WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $msg = "Usuario eliminado correctamente";
    }
}
?>
<h2 class="page-title">Usuarios del Panel Admin
	<a href="?p=create-admin-user" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Agregar Usuario</a>
</h2>

<div class="panel panel-default">
	<div class="panel-heading">Lista de usuarios</div>
	<div class="panel-body">
	<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
	else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>
		<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
			<thead>
				<tr>
				<th>#</th>
					<th>Usuario</th>
					<th>Nombre</th>
					<th>Rol</th>
					<th>Última actualización</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
				<th>#</th>
					<th>Usuario</th>
					<th>Nombre</th>
					<th>Rol</th>
					<th>Última actualización</th>
					<th>Acciones</th>
				</tr>
			</tfoot>
			<tbody>

			<?php $sql = "SELECT admin.id, admin.UserName, admin.FullName, admin.updationDate, tbladminroles.RoleName
                          FROM admin
                          LEFT JOIN tbladminroles ON tbladminroles.id = admin.RoleId
                          ORDER BY admin.id ASC";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
				<tr>
					<td><?= htmlentities($cnt); ?></td>
					<td><?= htmlentities($result->UserName); ?></td>
					<td><?= htmlentities($result->FullName ?: '—'); ?></td>
					<td><span class="label label-info"><?= htmlentities($result->RoleName ?: 'Sin rol'); ?></span></td>
					<td><?= htmlentities($result->updationDate); ?></td>
<td><a href="?p=edit-admin-user&id=<?= $result->id; ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
<a href="?p=manage-admin-users&del=<?= $result->id; ?>" data-confirm="¿Desea eliminar este usuario?"><i class="fa fa-close"></i></a></td>
				</tr>
				<?php $cnt = $cnt + 1; }
} ?>

			</tbody>
		</table>

	</div>
</div>
