<?php
$rcBookingNo = isset($_GET['bookingno']) ? trim($_GET['bookingno']) : '';
$rcName      = isset($_GET['name']) ? trim($_GET['name']) : '';
$rcEmail     = isset($_GET['email']) ? trim($_GET['email']) : '';
$rcOriginal  = isset($_GET['original']) ? trim($_GET['original']) : '';
$rcSimilar   = isset($_GET['similar']) ? trim($_GET['similar']) : '';
$rcCategory  = isset($_GET['category']) ? trim($_GET['category']) : '';
$rcSubstituted = ($rcOriginal !== '' && $rcSimilar !== '');
$rcLoggedIn  = !empty($_SESSION['login']);
?>
<!--Page Header-->
<section class="page-header listing_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>¡Reserva realizada!</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="?p=home">Inicio</a></li>
        <li>Reserva Confirmada</li>
      </ul>
    </div>
  </div>
  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>
<!-- /Page Header-->

<!--Booking Confirmation-->
<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="booking-confirmation-box text-center">
          <i class="fa fa-check-circle booking-confirmation-icon" aria-hidden="true"></i>
          <h3>¡Gracias<?= $rcName ? ', ' . htmlentities($rcName) : ''; ?>!</h3>
          <p>
            Tu reserva se realizó con éxito.
            <?php if ($rcBookingNo) { ?>Tu número de reserva es <strong>#<?= htmlentities($rcBookingNo); ?></strong>.<?php } ?>
            Te contactaremos pronto para confirmar los detalles.
          </p>

          <?php if ($rcSubstituted) { ?>
          <div class="booking-substitution-note">
            <p>
              <i class="fa fa-info-circle" aria-hidden="true"></i>
              El <strong><?= htmlentities($rcOriginal); ?></strong> que buscabas ya no estaba disponible para esas fechas,
              así que te reservamos otro vehículo de la misma categoría<?= $rcCategory ? ' (' . htmlentities($rcCategory) . ')' : ''; ?>:
              <strong><?= htmlentities($rcSimilar); ?></strong>. Tendrás la misma experiencia de manejo, sin contratiempos.
            </p>
          </div>
          <?php } ?>

          <?php if ($rcLoggedIn) { ?>
          <div class="booking-confirmation-cta">
            <a href="?p=my-booking" class="btn">Ver mis reservas</a>
            <a href="?p=vehiculos" class="btn btn-default">Seguir explorando</a>
          </div>
          <?php } else { ?>
          <div class="booking-confirmation-cta">
            <h4>¿Quieres crear una cuenta?</h4>
            <p>Regístrate para ver el estado de tus reservas y agilizar tu próxima renta.</p>
            <a href="#signupform" id="rcRegisterBtn" data-toggle="modal" class="btn">Sí, registrarme</a>
            <a href="?p=vehiculos" class="btn btn-default">No, gracias, seguir explorando</a>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /Booking Confirmation-->

<script>
document.addEventListener("DOMContentLoaded", function () {
    var rcName = <?= json_encode($rcName); ?>;
    var rcEmail = <?= json_encode($rcEmail); ?>;
    var registerBtn = document.getElementById('rcRegisterBtn');
    if (registerBtn) {
        registerBtn.addEventListener('click', function () {
            var fullnameInput = document.querySelector('#signupform input[name="fullname"]');
            var emailInput = document.querySelector('#signupform input[name="emailid"]');
            if (fullnameInput && rcName) { fullnameInput.value = rcName; }
            if (emailInput && rcEmail) { emailInput.value = rcEmail; }
        });
    }
});
</script>
