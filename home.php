<!-- Car Search Widget -->
<section class="car-search-widget-section">
    <div class="container">
        <div class="car-finder-box">
            <form class="find-car-form" action="?p=vehiculos" method="get">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fa fa-map-marker" aria-hidden="true"></i> Lugar de recogida</label>
                            <select class="form-control" name="pickup_location">
                                <?php
                                $sqlLoc = "SELECT * FROM tblpickuplocations WHERE IsActive=1 ORDER BY SortOrder ASC";
                                $queryLoc = $dbh->prepare($sqlLoc);
                                $queryLoc->execute();
                                $locations = $queryLoc->fetchAll(PDO::FETCH_OBJ);
                                foreach ($locations as $loc) { ?>
                                    <option value="<?= htmlentities($loc->id); ?>"><?= htmlentities($loc->LocationName); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><i class="fa fa-calendar" aria-hidden="true"></i> Recogida</label>
                            <input type="text" class="form-control flatpickr" id="searchFromDate" name="fromdate" placeholder="Fecha y hora" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><i class="fa fa-calendar" aria-hidden="true"></i> Entrega</label>
                            <input type="text" class="form-control flatpickr" id="searchToDate" name="todate" placeholder="Fecha y hora" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-block"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
document.addEventListener("DOMContentLoaded", function () {
    var flatpickrTimeOptions = {
        enableTime: true,
        time_24hr: false,
        minuteIncrement: 30,
        defaultHour: 10,
        dateFormat: "Y-m-d H:i",
        altInput: true,
        altFormat: "d M Y, h:i K",
        minDate: "today"
    };
    var fromPicker = flatpickr("#searchFromDate", Object.assign({}, flatpickrTimeOptions, {
        onChange: function (selectedDates, dateStr) {
            toPicker.set("minDate", dateStr);
        }
    }));
    var toPicker = flatpickr("#searchToDate", flatpickrTimeOptions);
});
</script>
<!-- /Car Search Widget -->
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
                    v.TransmissionType,
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
                                <div class="recent-vehicle-card">
                                    <div class="recent-vehicle-img">
                                        <a href="?p=vehiculo&vhid=<?= htmlentities($result->id); ?>">
                                            <img src="admin/img/vehicleimages/<?= htmlentities($result->Vimage1); ?>"
                                                class="img-responsive" alt="Imagen del vehículo">
                                        </a>
                                    </div>
                                    <div class="recent-vehicle-body">
                                        <h6>
                                            <a href="?p=vehiculo&vhid=<?= htmlentities($result->id); ?>">
                                                <?= htmlentities($result->VehiclesTitle); ?>
                                            </a>
                                        </h6>
                                        <span class="recent-vehicle-price">USD $<?= htmlentities($result->PricePerDay); ?> / Día</span>
                                        <ul class="recent-vehicle-meta">
                                            <li><i class="fa fa-cogs" aria-hidden="true"></i>
                                                <?= htmlentities($result->TransmissionType); ?></li>
                                            <li><i class="fa fa-user" aria-hidden="true"></i>
                                                <?= htmlentities($result->SeatingCapacity); ?> asientos</li>
                                        </ul>
                                        <p class="recent-vehicle-desc"><?= htmlentities(substr($result->VehiclesOverview, 0, 70)); ?>...</p>
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
<!-- Features -->
<section class="features-section">
  <div class="container">
    <div class="section-header text-center">
      <h2>¿Por qué elegirnos?</h2>
      <p>Descubre los beneficios que nos hacen la mejor opción para tu renta de vehículos.</p>
    </div>
    <div class="row">
      <?php
      $sqlF = "SELECT * FROM tblfeatures ORDER BY SortOrder ASC";
      $queryF = $dbh->prepare($sqlF);
      $queryF->execute();
      $features = $queryF->fetchAll(PDO::FETCH_OBJ);
      foreach ($features as $feat): ?>
        <div class="col-md-4">
          <div class="feature-item">
            <div class="feature-icon-wrap">
              <i class="fa <?= htmlentities($feat->Icon); ?>"></i>
            </div>
            <h4 class="feature-title"><?= htmlentities($feat->Title); ?></h4>
            <p class="feature-subtitle"><?= htmlentities($feat->Subtitle); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- /Features -->