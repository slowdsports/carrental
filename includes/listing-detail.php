<!--Listing-detail-->
<section class="listing-detail">
  <div class="container">
    <div class="listing_detail_head row">
      <div class="col-md-9">
        <h2><?= htmlentities($result->BrandName); ?> , <?= htmlentities($result->VehiclesTitle); ?></h2>
      </div>
      <div class="col-md-3">
        <div class="price_info">
          <p>HNL <?= htmlentities($result->PricePerDay); ?></p>Por día
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-9">
        <!-- Características principales -->
        <div class="main_features">
          <ul>
            <li><i class="fa fa-calendar"></i><h5><?= htmlentities($result->ModelYear); ?></h5><p>Año</p></li>
            <li><i class="fa fa-cogs"></i><h5><?= htmlentities($result->FuelType); ?></h5><p>Combustible</p></li>
            <li><i class="fa fa-user-plus"></i><h5><?= htmlentities($result->SeatingCapacity); ?></h5><p>Asientos</p></li>
          </ul>
        </div>

        <!-- Tabs -->
        <div class="listing_more_info">
          <div class="listing_detail_wrap">
            <ul class="nav nav-tabs gray-bg" role="tablist">
              <li role="presentation" class="active">
                <a href="#vehicle-overview" aria-controls="vehicle-overview" role="tab" data-toggle="tab">Resumen de vehículo</a>
              </li>
              <li role="presentation">
                <a href="#accessories" aria-controls="accessories" role="tab" data-toggle="tab">Accesorios</a>
              </li>
            </ul>

            <div class="tab-content">
              <!-- Resumen -->
              <div role="tabpanel" class="tab-pane active" id="vehicle-overview">
                <p><?= htmlentities($result->VehiclesOverview); ?></p>
              </div>

              <!-- Accesorios -->
              <div role="tabpanel" class="tab-pane" id="accessories">
                <table>
                  <thead>
                    <tr><th colspan="2">Accesorios</th></tr>
                  </thead>
                  <tbody>
                    <?php
                    // Lista de accesorios con su campo en la BD
                    $accesorios = [
                      "Aire acondicionado" => $result->AirConditioner,
                      "AntiLock Braking System (ABS)" => $result->AntiLockBrakingSystem,
                      "Power Steering (EPS)" => $result->PowerSteering,
                      "Ventanas eléctricas" => $result->PowerWindows,
                      "Carplay y/o Android Auto" => $result->CDPlayer,
                      "Asientos de cuero" => $result->LeatherSeats,
                      "Cámara de reversa" => $result->CentralLocking,
                      "Control de Estabilidad (ESP / VSC)" => $result->PowerDoorLocks,
                      "Brake Assist" => $result->BrakeAssist,
                      "Bolsa de aire de conductor" => $result->DriverAirbag,
                      "Bolsa de aire de pasajeros" => $result->PassengerAirbag,
                      "Sensor de parqueo" => $result->CrashSensor
                    ];

                    foreach ($accesorios as $nombre => $valor) {
                      echo "<tr><td>{$nombre}</td><td>";
                      echo ($valor == 1) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>';
                      echo "</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <aside class="col-md-3">
        <div class="share_vehicle">
          <img src="admin/img/promo/1.jpeg" alt="Destiny Car Rental - No compre, rente!" class="img-responsive">
        </div>

        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-envelope"></i> ¡Reservar Ahora!</h5>
          </div>
          <form method="post">
            <div class="form-group">
              <label>Desde:</label>
              <input class="form-control flatpickr flatpickr-input active" type="text" placeholder="Fecha inicio" name="fromdate" required>
            </div>
            <div class="form-group">
              <label>Hasta:</label>
              <input class="form-control flatpickr flatpickr-input active" type="text" placeholder="Fecha final" name="todate" required>
            </div>
            <div class="form-group">
              <textarea rows="4" class="form-control" name="message" placeholder="Mensaje" required></textarea>
            </div>
            <?php if ($_SESSION['login']) { ?>
              <div class="form-group">
                <input type="submit" class="btn" name="submit" value="Hacer Reserva">
              </div>
            <?php } else { ?>
              <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Iniciar sesión para reservar</a>
            <?php } ?>
          </form>
          <script>
            var reservas = <?php echo json_encode($reservas); ?>;
            document.addEventListener("DOMContentLoaded", function() {
            // Convertir reservas a rangos para flatpickr
            let rangosBloqueados = reservas.map(r => {
                return { from: r.from, to: r.to };
            });

            flatpickr("input[name='fromdate']", {
                dateFormat: "Y-m-d",
                disable: rangosBloqueados
            });

            flatpickr("input[name='todate']", {
                dateFormat: "Y-m-d",
                disable: rangosBloqueados
            });
        });

          </script>

        </div>
      </aside>
    </div>

    <div class="space-20"></div>
    <div class="divider"></div>

    <!-- Vehículos similares -->
    <div class="similar_cars">
      <h3>Vehículos similares</h3>
      <div class="row">
        <?php
        $bid = $_SESSION['brndid'];
        $sql = "SELECT v.VehiclesTitle, b.BrandName, v.PricePerDay, v.FuelType, v.ModelYear, v.id, v.SeatingCapacity, v.VehiclesOverview, v.Vimage1
                FROM tblvehicles v
                JOIN tblbrands b ON b.id = v.VehiclesBrand
                WHERE v.VehiclesBrand = :bid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bid', $bid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
          foreach ($results as $result) { ?>
            <div class="col-md-3 grid_listing">
              <div class="product-listing-m gray-bg">
                <div class="product-listing-img">
                  <a href="vehical-details.php?vhid=<?= htmlentities($result->id); ?>">
                    <img src="admin/img/vehicleimages/<?= htmlentities($result->Vimage1); ?>" class="img-responsive" alt="image">
                  </a>
                </div>
                <div class="product-listing-content">
                  <h5>
                    <a href="vehical-details.php?vhid=<?= htmlentities($result->id); ?>">
                      <?= htmlentities($result->BrandName); ?> , <?= htmlentities($result->VehiclesTitle); ?>
                    </a>
                  </h5>
                  <p class="list-price">HNL <?= htmlentities($result->PricePerDay); ?></p>
                  <ul class="features_list">
                    <li><i class="fa fa-user"></i> <?= htmlentities($result->SeatingCapacity); ?> asientos</li>
                    <li><i class="fa fa-calendar"></i> <?= htmlentities($result->ModelYear); ?></li>
                    <li><i class="fa fa-car"></i> <?= htmlentities($result->FuelType); ?></li>
                  </ul>
                </div>
              </div>
            </div>
          <?php }
        } ?>
      </div>
    </div>
  </div>
</section>
<!--/Listing-detail-->
