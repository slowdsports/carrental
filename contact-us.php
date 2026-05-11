<?php
if (isset($_POST['send'])) {
    $name      = trim($_POST['fullname']);
    $email     = trim($_POST['email']);
    $contactno = trim($_POST['contactno']);
    $message   = trim($_POST['message']);

    $sql = "INSERT INTO tblcontactusquery(name, EmailId, ContactNumber, Message) VALUES(:name, :email, :contactno, :message)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name',      $name,      PDO::PARAM_STR);
    $query->bindParam(':email',     $email,     PDO::PARAM_STR);
    $query->bindParam(':contactno', $contactno, PDO::PARAM_STR);
    $query->bindParam(':message',   $message,   PDO::PARAM_STR);
    $query->execute();

    if ($dbh->lastInsertId()) {
        $msg = "¡Enviado! Nos pondremos en contacto contigo pronto.";
    } else {
        $error = "Algo no funcionó bien. Por favor inténtalo nuevamente.";
    }
}
?>

<style>
.errorWrap {
    padding: 10px; margin: 0 0 20px;
    background: #fff; border-left: 4px solid #dd3d36;
    box-shadow: 0 1px 1px rgba(0,0,0,.1);
}
.succWrap {
    padding: 10px; margin: 0 0 20px;
    background: #fff; border-left: 4px solid #5cb85c;
    box-shadow: 0 1px 1px rgba(0,0,0,.1);
}
</style>

<!--Page Header-->
<section class="page-header contactus_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Contacto</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="index.php">Inicio</a></li>
        <li>Contacto</li>
      </ul>
    </div>
  </div>
  <div class="dark-overlay"></div>
</section>
<!-- /Page Header-->

<!--Contact-us-->
<section class="contact_us section-padding">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3>¡Contáctanos mediante el formulario!</h3>

        <?php if (!empty($error)): ?>
          <div class="errorWrap"><strong>ERROR</strong>: <?= htmlentities($error); ?></div>
        <?php elseif (!empty($msg)): ?>
          <div class="succWrap"><strong>LISTO</strong>: <?= htmlentities($msg); ?></div>
        <?php endif; ?>

        <div class="contact_form gray-bg">
          <form method="post">
            <div class="form-group">
              <label class="control-label">Nombre Completo <span>*</span></label>
              <input type="text" name="fullname" class="form-control white_bg" required>
            </div>
            <div class="form-group">
              <label class="control-label">Correo electrónico <span>*</span></label>
              <input type="email" name="email" class="form-control white_bg" required>
            </div>
            <div class="form-group">
              <label class="control-label">Número de celular</label>
              <input type="text" name="contactno" class="form-control white_bg" maxlength="15" pattern="[0-9+\-\s]+">
            </div>
            <div class="form-group">
              <label class="control-label">Mensaje <span>*</span></label>
              <textarea class="form-control white_bg" name="message" rows="4" required></textarea>
            </div>
            <div class="form-group">
              <button class="btn" type="submit" name="send">Enviar <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
            </div>
          </form>
        </div>
      </div>

      <div class="col-md-6">
        <h3>Información de contacto</h3>
        <div class="contact_detail">
          <?php
          $sqlC = "SELECT Address, ContactNo, EmailId FROM tblcontactusinfo LIMIT 1";
          $queryC = $dbh->prepare($sqlC);
          $queryC->execute();
          $contact = $queryC->fetch(PDO::FETCH_OBJ);
          if ($contact): ?>
          <ul>
            <li>
              <div class="icon_wrap"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
              <div class="contact_info_m"><?= htmlentities($contact->Address); ?></div>
            </li>
            <li>
              <div class="icon_wrap"><i class="fa fa-phone" aria-hidden="true"></i></div>
              <div class="contact_info_m"><?= htmlentities($contact->ContactNo); ?></div>
            </li>
            <li>
              <div class="icon_wrap"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
              <div class="contact_info_m"><a href="mailto:<?= htmlentities($contact->EmailId); ?>"><?= htmlentities($contact->EmailId); ?></a></div>
            </li>
          </ul>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /Contact-us-->
