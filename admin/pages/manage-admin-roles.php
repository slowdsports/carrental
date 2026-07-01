<?php
if (($_SESSION['arolename'] ?? '') !== 'Super Admin') {
    echo '<div class="alert alert-warning">No tienes permiso para acceder a esta sección.</div>';
    return;
}

$msg = '';
$error = '';
if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $roleRow = $dbh->prepare("SELECT RoleName FROM tbladminroles WHERE id=:id");
    $roleRow->bindParam(':id', $id, PDO::PARAM_INT);
    $roleRow->execute();
    $roleName = $roleRow->fetchColumn();

    $inUse = $dbh->prepare("SELECT COUNT(*) FROM admin WHERE RoleId=:id");
    $inUse->bindParam(':id', $id, PDO::PARAM_INT);
    $inUse->execute();

    if ($roleName === 'Super Admin') {
        $error = "El rol 'Super Admin' no se puede eliminar.";
    } elseif ($inUse->fetchColumn() > 0) {
        $error = "No se puede eliminar: hay usuarios asignados a este rol.";
    } else {
        $sql = "DELETE FROM tbladminroles WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $msg = "Rol eliminado correctamente";
    }
}
?>
<h2 class="page-title">Roles de Usuario
	<a href="?p=create-admin-role" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Agregar Rol</a>
</h2>

<div class="panel panel-default">
	<div class="panel-heading">Lista de roles</div>
	<div class="panel-body">
	<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
	else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>
		<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
			<thead>
				<tr>
				<th>#</th>
					<th>Nombre</th>
					<th>Usuarios asignados</th>
					<th>Creación</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
				<th>#</th>
					<th>Nombre</th>
					<th>Usuarios asignados</th>
					<th>Creación</th>
					<th>Acciones</th>
				</tr>
			</tfoot>
			<tbody>

			<?php $sql = "SELECT tbladminroles.*, (SELECT COUNT(*) FROM admin WHERE admin.RoleId = tbladminroles.id) as UserCount
                          FROM tbladminroles ORDER BY id ASC";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
				<tr>
					<td><?= htmlentities($cnt); ?></td>
					<td><?= htmlentities($result->RoleName); ?></td>
					<td><?= htmlentities($result->UserCount); ?></td>
					<td><?= htmlentities($result->CreationDate); ?></td>
<td><a href="?p=edit-admin-role&id=<?= $result->id; ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
<a href="?p=manage-admin-roles&del=<?= $result->id; ?>" data-confirm="¿Desea eliminar este rol?"><i class="fa fa-close"></i></a></td>
				</tr>
				<?php $cnt = $cnt + 1; }
} ?>

			</tbody>
		</table>

	</div>
</div>
