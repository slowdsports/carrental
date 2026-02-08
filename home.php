<!-- Banner Promo -->
<section id="banner" class="banner-section">
    <div class="container">
        <div class="div_zindex">
            <div class="row">
                <div class="col-md-5 col-md-push-7">
                    <div class="banner_content">
                        <h1>&nbsp;</h1>
                        <p>&nbsp; </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Banner Promo -->
<!-- Resent Cat-->
<section class="section-padding gray-bg">
    <div class="container">
        <div class="section-header text-center">
            <h2>¡Encuentra el mejor auto para ti!</h2>
            <p>En Destiny puedes elegir en una amplia variación de vehículos de distintas categorías y precios.</p>
        </div>
        <div class="row">
            <!-- Nav tabs -->
            <div class="recent-tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#resentnewcar" role="tab"
                            data-toggle="tab">¡Nuevo!</a></li>
                </ul>
            </div>
            <!-- Recently Listed New Cars -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="resentnewcar">
                    <?php
                    $sql = "SELECT 
                    v.VehiclesTitle,
                    b.BrandName,
                    v.PricePerDay,
                    v.FuelType,
                    v.ModelYear,
                    v.id,
                    v.SeatingCapacity,
                    v.VehiclesOverview,
                    v.Vimage1
                FROM tblvehicles v
                JOIN tblbrands b ON b.id = v.VehiclesBrand
                ORDER BY RAND()
                LIMIT 9";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) { ?>
                            <div class="col-list-3">
                                <div class="recent-car-list">
                                    <div class="car-info-box">
                                        <a href="?p=vehiculo&vhid=<?= htmlentities($result->id); ?>">
                                            <img src="admin/img/vehicleimages/<?= htmlentities($result->Vimage1); ?>"
                                                class="img-responsive" alt="Imagen del vehículo">
                                        </a>
                                        <ul>
                                            <li><i class="fa fa-car" aria-hidden="true"></i>
                                                <?= htmlentities($result->FuelType); ?></li>
                                            <li><i class="fa fa-calendar" aria-hidden="true"></i> Año
                                                <?= htmlentities($result->ModelYear); ?>
                                            </li>
                                            <li><i class="fa fa-user" aria-hidden="true"></i>
                                                <?= htmlentities($result->SeatingCapacity); ?> Asientos</li>
                                        </ul>
                                    </div>
                                    <div class="car-title-m">
                                        <h6>
                                            <a href="?p=vehiculo&vhid=<?= htmlentities($result->id); ?>">
                                                <?= htmlentities($result->VehiclesTitle); ?>
                                            </a>
                                        </h6>
                                        <span class="price">HNL <?= htmlentities($result->PricePerDay); ?> / Día</span>
                                    </div>
                                    <div class="inventory_info_m">
                                        <p><?= htmlentities(substr($result->VehiclesOverview, 0, 70)); ?>...</p>
                                    </div>
                                </div>
                            </div>

                        <?php }
                    } ?>
                </div>
            </div>
        </div>
</section>
<!-- /Resent Cat -->
 <!-- Fun Facts-->
<section class="fun-facts-section">
  <div class="container div_zindex">
    <div class="row">
      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-calendar" aria-hidden="true"></i>5+</h2>
            <p>Años en el negocio</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-car" aria-hidden="true"></i>300+</h2>
            <p>Rentas por año</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-car" aria-hidden="true"></i>10+</h2>
            <p>Modelos</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-user-circle-o" aria-hidden="true"></i>600+</h2>
            <p>Clientes satisfechos</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>
<!-- /Fun Facts--> 