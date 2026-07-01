<?php
// Filtros de búsqueda recibidos desde el selector del inicio (formato "Y-m-d H:i")
$filterFromDateTime = isset($_GET['fromdate']) ? trim($_GET['fromdate']) : '';
$filterToDateTime   = isset($_GET['todate']) ? trim($_GET['todate']) : '';
$filterLocation     = isset($_GET['pickup_location']) ? intval($_GET['pickup_location']) : 0;
$dateTimePattern    = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/';
$dateFilterActive   = (preg_match($dateTimePattern, $filterFromDateTime) && preg_match($dateTimePattern, $filterToDateTime));

// La tabla de reservas solo guarda el día (sin hora), así que la disponibilidad se compara por fecha
$filterFromDate = $dateFilterActive ? substr($filterFromDateTime, 0, 10) : '';
$filterToDate   = $dateFilterActive ? substr($filterToDateTime, 0, 10) : '';

$filterLocationName = '';
if ($filterLocation) {
    $sqlLoc = "SELECT LocationName FROM tblpickuplocations WHERE id=:id";
    $queryLoc = $dbh->prepare($sqlLoc);
    $queryLoc->bindParam(':id', $filterLocation, PDO::PARAM_INT);
    $queryLoc->execute();
    $locRow = $queryLoc->fetch(PDO::FETCH_OBJ);
    $filterLocationName = $locRow ? $locRow->LocationName : '';
}

$availabilitySubquery = " v.id NOT IN (
                SELECT VehicleId FROM tblbooking
                WHERE (Status=0 OR Status=1)
                AND (:fromdate BETWEEN DATE(FromDate) AND DATE(ToDate)
                     OR :todate BETWEEN DATE(FromDate) AND DATE(ToDate)
                     OR DATE(FromDate) BETWEEN :fromdate AND :todate)
            ) ";

// Orden de los resultados
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'recommended';
if ($sortOption === 'price_asc') {
    $orderBySql = ' ORDER BY v.PricePerDay ASC';
} elseif ($sortOption === 'price_desc') {
    $orderBySql = ' ORDER BY v.PricePerDay DESC';
} else {
    $sortOption = 'recommended';
    $orderBySql = ' ORDER BY v.id DESC';
}
?>
<!--Page Header-->
<section class="page-header listing_page">
    <div class="container">
        <div class="page-header_wrap">
            <div class="page-heading">
                <h1>Vehículos Disponibles</h1>
            </div>
            <ul class="coustom-breadcrumb">
                <li><a href="#">Inicio</a></li>
                <li>Vehículos Disponibles</li>
            </ul>
        </div>
    </div>
    <!-- Dark Overlay-->
    <div class="dark-overlay"></div>
</section>
<!-- /Page Header-->
<!--Listing-->
<section class="listing-page">
    <div class="container">
        <div class="row">
            <!-- Contenido principal -->
            <div class="col-md-9 col-md-push-3">
                <div class="result-sorting-wrapper">
                    <form method="get" action="?" class="result-sort-form">
                        <input type="hidden" name="p" value="vehiculos">
                        <?php if ($filterLocation) { ?><input type="hidden" name="pickup_location" value="<?= htmlentities($filterLocation); ?>"><?php } ?>
                        <?php if ($dateFilterActive) { ?>
                            <input type="hidden" name="fromdate" value="<?= htmlentities($filterFromDateTime); ?>">
                            <input type="hidden" name="todate" value="<?= htmlentities($filterToDateTime); ?>">
                        <?php } ?>
                        <label for="sortSelect">Ordenar por</label>
                        <select id="sortSelect" name="sort" class="form-control" onchange="this.form.submit()">
                            <option value="recommended" <?= $sortOption === 'recommended' ? 'selected' : ''; ?>>Recomendado</option>
                            <option value="price_asc" <?= $sortOption === 'price_asc' ? 'selected' : ''; ?>>Precio: menor a mayor</option>
                            <option value="price_desc" <?= $sortOption === 'price_desc' ? 'selected' : ''; ?>>Precio: mayor a menor</option>
                        </select>
                    </form>
                    <div class="sorting-count">
                        <?php
                        // Contar vehículos
                        $sql = "SELECT v.id FROM tblvehicles v";
                        if ($dateFilterActive) {
                            $sql .= " WHERE" . $availabilitySubquery;
                        }
                        $query = $dbh->prepare($sql);
                        if ($dateFilterActive) {
                            $query->bindParam(':fromdate', $filterFromDate, PDO::PARAM_STR);
                            $query->bindParam(':todate', $filterToDate, PDO::PARAM_STR);
                        }
                        $query->execute();
                        $cnt = $query->rowCount();
                        ?>
                        <?php if ($dateFilterActive) {
                            $fmtFrom = DateTime::createFromFormat('Y-m-d H:i', $filterFromDateTime);
                            $fmtTo   = DateTime::createFromFormat('Y-m-d H:i', $filterToDateTime);
                        ?>
                        <p class="search-filter-summary">
                            <i class="fa fa-filter" aria-hidden="true"></i> Disponibilidad
                            <?php if ($filterLocationName) { ?> en <strong><?= htmlentities($filterLocationName); ?></strong><?php } ?>
                            del <strong><?= htmlentities($fmtFrom ? $fmtFrom->format('d/m/Y h:i A') : $filterFromDateTime); ?></strong>
                            al <strong><?= htmlentities($fmtTo ? $fmtTo->format('d/m/Y h:i A') : $filterToDateTime); ?></strong>
                            &nbsp;<a href="?p=vehiculos" class="btn btn-xs btn-default">Quitar filtros</a>
                        </p>
                        <?php } ?>
                        <p><span><?= htmlentities($cnt); ?> Vehículos<?= $dateFilterActive ? ' disponibles' : ''; ?></span></p>
                    </div>
                </div>

                <?php
                // Listado de vehículos
                $sql = "SELECT v.*, b.BrandName, b.id AS bid
                FROM tblvehicles v
                JOIN tblbrands b ON b.id = v.VehiclesBrand";
                if ($dateFilterActive) {
                    $sql .= " WHERE" . $availabilitySubquery;
                }
                $sql .= $orderBySql;
                $query = $dbh->prepare($sql);
                if ($dateFilterActive) {
                    $query->bindParam(':fromdate', $filterFromDate, PDO::PARAM_STR);
                    $query->bindParam(':todate', $filterToDate, PDO::PARAM_STR);
                }
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                if ($query->rowCount() > 0) {
                    foreach ($results as $result) { ?>
                        <div class="vehicle-result-card">
                            <div class="vehicle-result-img">
                                <a href="?p=vehiculo&vhid=<?= htmlentities($result->id); ?>">
                                    <img src="admin/img/vehicleimages/<?= htmlentities($result->Vimage1); ?>"
                                        alt="Imagen del vehículo">
                                </a>
                            </div>
                            <div class="vehicle-result-body">
                                <h5>
                                    <a href="?p=vehiculo&vhid=<?= htmlentities($result->id); ?>">
                                        <?= htmlentities($result->BrandName); ?> <?= htmlentities($result->VehiclesTitle); ?>
                                    </a>
                                </h5>
                                <ul class="vehicle-result-meta">
                                    <li><i class="fa fa-user" aria-hidden="true"></i> <?= htmlentities($result->SeatingCapacity); ?> asientos</li>
                                    <li><i class="fa fa-cogs" aria-hidden="true"></i> <?= htmlentities($result->TransmissionType); ?></li>
                                    <li><i class="fa fa-road" aria-hidden="true"></i> Kilómetros ilimitados</li>
                                    <li><i class="fa fa-plane" aria-hidden="true"></i> Retiro en aeropuerto</li>
                                </ul>
                            </div>
                            <div class="vehicle-result-side">
                                <span class="price-note">Pago en el mostrador</span>
                                <span class="price-amount">USD $<?= htmlentities($result->PricePerDay); ?></span>
                                <span class="price-period">por día</span>
                                <a href="?p=vehiculo&vhid=<?= htmlentities($result->id); ?>" class="btn">Reservar</a>
                            </div>
                        </div>
                    <?php }
                } elseif ($dateFilterActive) { ?>
                    <div class="alert alert-warning">No hay vehículos disponibles para las fechas seleccionadas.</div>
                <?php } ?>
            </div>

            <!-- Side-Bar -->
            <aside class="col-md-3 col-md-pull-9">
                <!-- Vehículos recientes -->
                <div class="sidebar_widget">
                    <div class="widget_heading">
                        <h5><i class="fa fa-car"></i> Disponibles</h5>
                    </div>
                    <div class="recent_addedcars">
                        <ul>
                            <?php
                            $sql = "SELECT v.*, b.BrandName, b.id AS bid  
                      FROM tblvehicles v 
                      JOIN tblbrands b ON b.id = v.VehiclesBrand 
                      ORDER BY v.id DESC LIMIT 4";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $recent = $query->fetchAll(PDO::FETCH_OBJ);

                            if ($query->rowCount() > 0) {
                                foreach ($recent as $result) { ?>
                                    <li class="gray-bg">
                                        <div class="recent_post_img">
                                            <a href="?p=vehiculo&vhid=<?= htmlentities($result->id); ?>">
                                                <img src="admin/img/vehicleimages/<?= htmlentities($result->Vimage1); ?>"
                                                    alt="Imagen reciente">
                                            </a>
                                        </div>
                                        <div class="recent_post_title">
                                            <a href="?p=vehiculo&vhid=<?= htmlentities($result->id); ?>">
                                                <?= htmlentities($result->BrandName); ?> ,
                                                <?= htmlentities($result->VehiclesTitle); ?>
                                            </a>
                                            <p class="widget_price">USD $<?= htmlentities($result->PricePerDay); ?> Por Día</p>
                                        </div>
                                    </li>
                                <?php }
                            } ?>
                        </ul>
                    </div>
                </div>
            </aside>
            <!-- /Side-Bar -->
        </div>
    </div>
</section>
<!-- /Listing-->