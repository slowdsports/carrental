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
                    <div class="sorting-count">
                        <?php
                        // Contar vehículos
                        $sql = "SELECT id FROM tblvehicles";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $cnt = $query->rowCount();
                        ?>
                        <p><span><?= htmlentities($cnt); ?> Vehículos</span></p>
                    </div>
                </div>

                <?php
                // Listado de vehículos
                $sql = "SELECT v.*, b.BrandName, b.id AS bid  
                FROM tblvehicles v 
                JOIN tblbrands b ON b.id = v.VehiclesBrand";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                if ($query->rowCount() > 0) {
                    foreach ($results as $result) { ?>
                        <div class="product-listing-m gray-bg">
                            <div class="product-listing-img">
                                <a href="?p=vehiculo&vhid=<?= htmlentities($result->id); ?>">
                                    <img src="admin/img/vehicleimages/<?= htmlentities($result->Vimage1); ?>"
                                        class="img-responsive" alt="Imagen del vehículo">
                                </a>
                            </div>
                            <div class="product-listing-content">
                                <h5>
                                    <a href="?p=vehiculo&vhid=<?= htmlentities($result->id); ?>">
                                        <?= htmlentities($result->BrandName); ?> , <?= htmlentities($result->VehiclesTitle); ?>
                                    </a>
                                </h5>
                                <p class="list-price">HNL <?= htmlentities($result->PricePerDay); ?> Por Día</p>
                                <ul>
                                    <li><i class="fa fa-user"></i> <?= htmlentities($result->SeatingCapacity); ?> asientos</li>
                                    <li><i class="fa fa-calendar"></i> <?= htmlentities($result->ModelYear); ?></li>
                                    <li><i class="fa fa-car"></i> <?= htmlentities($result->FuelType); ?></li>
                                </ul>
                                <a href="?p=vehiculo&vhid=<?= htmlentities($result->id); ?>" class="btn">
                                    Ver Detalles <span class="angle_arrow"><i class="fa fa-angle-right"></i></span>
                                </a>
                            </div>
                        </div>
                    <?php }
                } ?>
            </div>

            <!-- Side-Bar -->
            <aside class="col-md-3 col-md-pull-9">
                <!-- Filtro -->
                <div class="sidebar_widget">
                    <div class="widget_heading">
                        <h5><i class="fa fa-filter"></i> ¡Encuentra tu vehículo!</h5>
                    </div>
                    <div class="sidebar_filter">
                        <form action="search-carresult.php" method="post">
                            <div class="form-group select">
                                <select class="form-control" name="brand">
                                    <option>Marca</option>
                                    <?php
                                    $sql = "SELECT * FROM tblbrands";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $brands = $query->fetchAll(PDO::FETCH_OBJ);

                                    if ($query->rowCount() > 0) {
                                        foreach ($brands as $brand) { ?>
                                            <option value="<?= htmlentities($brand->id); ?>">
                                                <?= htmlentities($brand->BrandName); ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>

                            <div class="form-group select">
                                <select class="form-control" name="fueltype">
                                    <option>Combustible</option>
                                    <option value="Gasolina">Gasolina</option>
                                    <option value="Diesel">Diesel</option>
                                    <option value="Electrico">Eléctrico</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-block">
                                    <i class="fa fa-search"></i> Buscar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

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
                                            <p class="widget_price">HNL <?= htmlentities($result->PricePerDay); ?> Por Día</p>
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