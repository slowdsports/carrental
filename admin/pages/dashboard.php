<h2 class="page-title">Dashboard</h2>

<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body bk-primary text-light">
						<div class="stat-panel text-center">
<?php
$sql = "SELECT id from tblusers ";
$query = $dbh->prepare($sql);
$query->execute();
$regusers = $query->rowCount();
?>
							<div class="stat-panel-number h1"><?= htmlentities($regusers); ?></div>
							<div class="stat-panel-title text-uppercase">Usuarios</div>
						</div>
					</div>
					<a href="?p=reg-users" class="block-anchor panel-footer">Entrar <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body bk-success text-light">
						<div class="stat-panel text-center">
<?php
$sql1 = "SELECT id from tblvehicles ";
$query1 = $dbh->prepare($sql1);
$query1->execute();
$totalvehicle = $query1->rowCount();
?>
							<div class="stat-panel-number h1"><?= htmlentities($totalvehicle); ?></div>
							<div class="stat-panel-title text-uppercase">Vehículos</div>
						</div>
					</div>
					<a href="?p=manage-vehicles" class="block-anchor panel-footer text-center">Entrar &nbsp; <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body bk-info text-light">
						<div class="stat-panel text-center">
<?php
$sql2 = "SELECT id from tblbooking ";
$query2 = $dbh->prepare($sql2);
$query2->execute();
$bookings = $query2->rowCount();
?>
							<div class="stat-panel-number h1"><?= htmlentities($bookings); ?></div>
							<div class="stat-panel-title text-uppercase">Reservas</div>
						</div>
					</div>
					<a href="?p=manage-bookings" class="block-anchor panel-footer text-center">Entrar &nbsp; <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body bk-warning text-light">
						<div class="stat-panel text-center">
<?php
$sql3 = "SELECT id from tblbrands ";
$query3 = $dbh->prepare($sql3);
$query3->execute();
$brands = $query3->rowCount();
?>
							<div class="stat-panel-number h1"><?= htmlentities($brands); ?></div>
							<div class="stat-panel-title text-uppercase">Marcas</div>
						</div>
					</div>
					<a href="?p=manage-brands" class="block-anchor panel-footer text-center">Entrar &nbsp; <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body bk-primary text-light">
						<div class="stat-panel text-center">
<?php
$sql4 = "SELECT id from tblsubscribers ";
$query4 = $dbh->prepare($sql4);
$query4->execute();
$subscribers = $query4->rowCount();
?>
							<div class="stat-panel-number h1"><?= htmlentities($subscribers); ?></div>
							<div class="stat-panel-title text-uppercase">Suscriptores</div>
						</div>
					</div>
					<a href="?p=manage-subscribers" class="block-anchor panel-footer">Entrar <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body bk-success text-light">
						<div class="stat-panel text-center">
<?php
$sql6 = "SELECT id from tblcontactusquery ";
$query6 = $dbh->prepare($sql6);
$query6->execute();
$contactqueries = $query6->rowCount();
?>
							<div class="stat-panel-number h1"><?= htmlentities($contactqueries); ?></div>
							<div class="stat-panel-title text-uppercase">Preguntas</div>
						</div>
					</div>
					<a href="?p=manage-conactusquery" class="block-anchor panel-footer text-center">Entrar &nbsp; <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body bk-info text-light">
						<div class="stat-panel text-center">
<?php
$sql5 = "SELECT id from tbltestimonial ";
$query5 = $dbh->prepare($sql5);
$query5->execute();
$testimonials = $query5->rowCount();
?>
							<div class="stat-panel-number h1"><?= htmlentities($testimonials); ?></div>
							<div class="stat-panel-title text-uppercase">Reseñas</div>
						</div>
					</div>
					<a href="?p=testimonials" class="block-anchor panel-footer text-center">Entrar &nbsp; <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
		</div>
	</div>
</div>
