<!--Listing-detail-->
<section class="listing-detail">
  <div class="container">
    <div class="listing_detail_head row">
      <div class="col-md-9">
        <h2><?= htmlentities($result->BrandName); ?> , <?= htmlentities($result->VehiclesTitle); ?></h2>
      </div>
      <div class="col-md-3">
        <div class="price_info">
          <p>USD $<?= htmlentities($result->PricePerDay); ?></p>Por día
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-9">
        <!-- Características principales -->
        <div class="main_features">
          <ul>
            <li><i class="fa fa-cogs"></i><h5><?= htmlentities($result->TransmissionType); ?></h5><p>Transmisión</p></li>
            <li><i class="fa fa-user-plus"></i><h5><?= htmlentities($result->SeatingCapacity); ?></h5><p>Asientos</p></li>
            <li><i class="fa fa-road"></i><h5>Ilimitados</h5><p>Kilómetros</p></li>
            <li><i class="fa fa-plane"></i><h5>Terminal</h5><p>Retiro en aeropuerto</p></li>
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
                      "Carplay y/o Android Auto" => $result->CarplayAndroidAuto,
                      "Asientos de cuero" => $result->LeatherSeats,
                      "Cámara de reversa" => $result->RearCamera,
                      "Control de Estabilidad (ESP / VSC)" => $result->StabilityControl,
                      "Brake Assist" => $result->BrakeAssist,
                      "Bolsa de aire de conductor" => $result->DriverAirbag,
                      "Bolsa de aire de pasajeros" => $result->PassengerAirbag,
                      "Sensor de parqueo" => $result->ParkingSensor
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
              <input class="form-control" type="text" id="bookFromDate" placeholder="Fecha inicio" name="fromdate"
                <?= $preFromDate ? 'value="' . htmlentities($preFromDate) . '"' : ''; ?> required>
            </div>
            <div class="form-group">
              <label>Hasta:</label>
              <input class="form-control" type="text" id="bookToDate" placeholder="Fecha final" name="todate"
                <?= $preToDate ? 'value="' . htmlentities($preToDate) . '"' : ''; ?> required>
            </div>
            <div class="form-group">
              <textarea rows="4" class="form-control" name="message" placeholder="Mensaje" required></textarea>
            </div>
            <?php if (!$_SESSION['login']): ?>
              <div class="form-group">
                <input type="text" class="form-control" name="guestname" placeholder="Tu nombre completo" required>
              </div>
              <div class="form-group">
                <input type="email" class="form-control" name="guestemail" placeholder="Tu correo electrónico" required>
              </div>
            <?php endif; ?>
            <div class="form-group">
              <input type="submit" class="btn" name="submit" value="Hacer Reserva">
            </div>
          </form>
          <script>
          (function () {
            var reservas = <?= json_encode($reservas); ?>;
            var preFrom  = <?= json_encode($preFromDate); ?>;
            var preTo    = <?= json_encode($preToDate); ?>;

            var rangosBloqueados = reservas.map(function(r) {
                return { from: r.from, to: r.to };
            });

            var fpTo = flatpickr("#bookToDate", {
                dateFormat: "Y-m-d",
                minDate: preFrom || "today",
                defaultDate: preTo  || null,
                disable: rangosBloqueados
            });

            flatpickr("#bookFromDate", {
                dateFormat: "Y-m-d",
                minDate: "today",
                defaultDate: preFrom || null,
                disable: rangosBloqueados,
                onChange: function(selectedDates, dateStr) {
                    // El "Hasta" no puede ser anterior al "Desde"
                    fpTo.set("minDate", dateStr);
                    if (fpTo.selectedDates[0] && fpTo.selectedDates[0] < selectedDates[0]) {
                        fpTo.clear();
                    }
                }
            });
          }());
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
        $sql = "SELECT v.VehiclesTitle, b.BrandName, v.PricePerDay, v.TransmissionType, v.id, v.SeatingCapacity, v.VehiclesOverview, v.Vimage1
                FROM tblvehicles v
                JOIN tblbrands b ON b.id = v.VehiclesBrand
                WHERE v.VehiclesBrand = :bid AND v.id != :vid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bid', $bid, PDO::PARAM_STR);
        $query->bindParam(':vid', $vhid, PDO::PARAM_INT);
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
                  <p class="list-price">USD $<?= htmlentities($result->PricePerDay); ?></p>
                  <ul class="features_list">
                    <li><i class="fa fa-user"></i> <?= htmlentities($result->SeatingCapacity); ?> asientos</li>
                    <li><i class="fa fa-cogs"></i> <?= htmlentities($result->TransmissionType); ?></li>
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
