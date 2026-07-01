<?php
$p = $p ?? 'dashboard';
function navActive($page, $current) {
    return $page === $current ? ' class="active"' : '';
}
function navOpen($pages, $current) {
    return in_array($current, $pages, true) ? ' open' : '';
}
?>
	<nav class="ts-sidebar">
			<ul class="ts-sidebar-menu">

				<li class="ts-label">PRINCIPAL</li>
				<li><a href="?p=dashboard"<?= navActive('dashboard', $p) ?>><i class="fa fa-dashboard"></i> Administración</a></li>

<li class="<?= trim(navOpen(['create-brand', 'manage-brands'], $p)) ?>"><a href="#"><i class="fa fa-files-o"></i> Marcas</a>
<ul>
<li><a href="?p=create-brand"<?= navActive('create-brand', $p) ?>>Crear marca</a></li>
<li><a href="?p=manage-brands"<?= navActive('manage-brands', $p) ?>>Editar marcas</a></li>
</ul>
</li>

<li class="<?= trim(navOpen(['post-avehical', 'manage-vehicles', 'edit-vehicle', 'change-image'], $p)) ?>"><a href="#"><i class="fa fa-car"></i> Vehículos</a>
					<ul>
						<li><a href="?p=post-avehical"<?= navActive('post-avehical', $p) ?>>Agregar vehículo</a></li>
						<li><a href="?p=manage-vehicles"<?= navActive('manage-vehicles', $p) ?>>Editar vehículos</a></li>
					</ul>
				</li>

<li class="<?= trim(navOpen(['new-bookings', 'confirmed-bookings', 'canceled-bookings', 'manage-bookings', 'bookig-details'], $p)) ?>"><a href="#"><i class="fa fa-sitemap"></i> Reservas</a>
					<ul>
						<li><a href="?p=new-bookings"<?= navActive('new-bookings', $p) ?>>Pendientes</a></li>
						<li><a href="?p=confirmed-bookings"<?= navActive('confirmed-bookings', $p) ?>>Confirmadas</a></li>
						<li><a href="?p=canceled-bookings"<?= navActive('canceled-bookings', $p) ?>>Canceladas</a></li>
					</ul>
				</li>

<li class="<?= trim(navOpen(['create-pickup-location', 'manage-pickup-locations', 'edit-pickup-location'], $p)) ?>"><a href="#"><i class="fa fa-map-marker"></i> Ubicaciones de Recogida</a>
<ul>
<li><a href="?p=create-pickup-location"<?= navActive('create-pickup-location', $p) ?>>Crear ubicación</a></li>
<li><a href="?p=manage-pickup-locations"<?= navActive('manage-pickup-locations', $p) ?>>Editar ubicaciones</a></li>
</ul>
</li>

<li><a href="?p=manage-conactusquery"<?= navActive('manage-conactusquery', $p) ?>><i class="fa fa-desktop"></i> Preguntas</a></li>
<li><a href="?p=reg-users"<?= navActive('reg-users', $p) ?>><i class="fa fa-users"></i> Usuarios</a></li>
<li><a href="?p=manage-subscribers"<?= navActive('manage-subscribers', $p) ?>><i class="fa fa-envelope"></i> Suscriptores</a></li>
<li><a href="?p=testimonials"<?= navActive('testimonials', $p) ?>><i class="fa fa-comments"></i> Reseñas</a></li>
<li><a href="?p=manage-features"<?= navActive('manage-features', $p) ?>><i class="fa fa-star"></i> Características</a></li>
<li><a href="?p=manage-pages"<?= navActive('manage-pages', $p) ?>><i class="fa fa-files-o"></i> Páginas</a></li>
<li><a href="?p=update-contactinfo"<?= navActive('update-contactinfo', $p) ?>><i class="fa fa-files-o"></i> Actualizar información de contacto</a></li>

<?php if (($_SESSION['arolename'] ?? '') === 'Super Admin') { ?>
				<li class="ts-label">ADMINISTRACIÓN</li>
				<li class="<?= trim(navOpen(['create-admin-user', 'manage-admin-users', 'edit-admin-user'], $p)) ?>"><a href="#"><i class="fa fa-user-circle-o"></i> Usuarios Admin</a>
<ul>
<li><a href="?p=create-admin-user"<?= navActive('create-admin-user', $p) ?>>Crear usuario</a></li>
<li><a href="?p=manage-admin-users"<?= navActive('manage-admin-users', $p) ?>>Editar usuarios</a></li>
</ul>
</li>
				<li class="<?= trim(navOpen(['create-admin-role', 'manage-admin-roles', 'edit-admin-role'], $p)) ?>"><a href="#"><i class="fa fa-shield"></i> Roles de Usuario</a>
<ul>
<li><a href="?p=create-admin-role"<?= navActive('create-admin-role', $p) ?>>Crear rol</a></li>
<li><a href="?p=manage-admin-roles"<?= navActive('manage-admin-roles', $p) ?>>Editar roles</a></li>
</ul>
</li>
<?php } ?>

			</ul>
		</nav>
