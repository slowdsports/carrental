<?php
$pageTitles = [
    'dashboard'                  => 'Administración',
    'create-brand'               => 'Crear marca',
    'manage-brands'               => 'Editar marcas',
    'edit-brand'                  => 'Editar marca',
    'post-avehical'               => 'Agregar vehículo',
    'manage-vehicles'             => 'Editar vehículos',
    'edit-vehicle'                => 'Editar vehículo',
    'change-image'                => 'Cambiar imagen de vehículo',
    'new-bookings'                => 'Reservas pendientes',
    'confirmed-bookings'          => 'Reservas confirmadas',
    'canceled-bookings'           => 'Reservas canceladas',
    'manage-bookings'             => 'Reservas',
    'bookig-details'              => 'Detalles de reserva',
    'create-pickup-location'      => 'Crear ubicación de recogida',
    'manage-pickup-locations'     => 'Ubicaciones de recogida',
    'edit-pickup-location'        => 'Editar ubicación de recogida',
    'manage-conactusquery'        => 'Preguntas',
    'reg-users'                   => 'Usuarios registrados',
    'manage-subscribers'          => 'Suscriptores',
    'testimonials'                => 'Reseñas',
    'manage-features'             => 'Características',
    'edit-feature'                => 'Editar característica',
    'manage-pages'                => 'Páginas',
    'update-contactinfo'          => 'Información de contacto',
    'change-password'             => 'Cambiar contraseña',
    'manage-admin-users'          => 'Usuarios del panel admin',
    'create-admin-user'           => 'Crear usuario del panel admin',
    'edit-admin-user'             => 'Editar usuario del panel admin',
    'manage-admin-roles'          => 'Roles de usuario',
    'create-admin-role'           => 'Crear rol',
    'edit-admin-role'             => 'Editar rol',
];
$pageTitle = $pageTitles[$p] ?? 'Administración';
?>
<!doctype html>
<html lang="es" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#0c0c0d">

	<title>Destiny Rent a Car | <?= htmlspecialchars($pageTitle) ?></title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Style -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Linear-inspired dark theme -->
	<link rel="stylesheet" href="css/linear-theme.css">
	<style>
		.errorWrap { padding:10px; margin:0 0 20px; background:#fff; border-left:4px solid #dd3d36; box-shadow:0 1px 1px rgba(0,0,0,.1); }
		.succWrap  { padding:10px; margin:0 0 20px; background:#fff; border-left:4px solid #5cb85c; box-shadow:0 1px 1px rgba(0,0,0,.1); }
	</style>
	<!-- SweetAlert2 en el <head> para que Swal esté disponible antes de cualquier script inline del body -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
	window.alert = function (message) {
	    Swal.fire({ text: String(message), confirmButtonText: 'Aceptar', confirmButtonColor: '#5e6ad2' });
	};
	</script>
</head>

<body>
<?php include('includes/topbar.php'); ?>
	<div class="ts-main-content">
<?php include('includes/leftbar.php'); ?>
		<div class="content-wrapper">
			<div class="container-fluid">
