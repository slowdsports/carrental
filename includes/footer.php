<?php
if (isset($_POST['emailsubscibe'])) {
  $subscriberemail = $_POST['subscriberemail'];
  $sql = "SELECT SubscriberEmail FROM tblsubscribers WHERE SubscriberEmail=:subscriberemail";
  $query = $dbh->prepare($sql);
  $query->bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  $cnt = 1;
  if ($query->rowCount() > 0) {
    echo "<script>alert('¡Ya estás registrado!.');</script>";
  } else {
    $sql = "INSERT INTO  tblsubscribers(SubscriberEmail) VALUES(:subscriberemail)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
      echo "<script>alert('¡Registro exitoso!');</script>";
    } else {
      echo "<script>alert('¡Algo no funcionó bien. Por favor inténtalo nuevamente');</script>";
    }
  }
}
?>

<footer>
  <div class="footer-top">
    <div class="container">
      <div class="row">

        <div class="col-md-6">
          <h6>Acerca de</h6>
          <ul>


            <li><a href="page.php?type=aboutus">Acerca de</a></li>
            <li><a href="page.php?type=faqs">FAQs</a></li>
            <li><a href="page.php?type=privacy">Privacidad</a></li>
            <li><a href="page.php?type=terms">Terminos de uso</a></li>
          </ul>
        </div>

        <div class="col-md-3 col-sm-6">
          <h6>Suscríbete al Newsletter</h6>
          <div class="newsletter-form">
            <form method="post">
              <div class="form-group">
                <input type="email" name="subscriberemail" class="form-control newsletter-input" required
                  placeholder="Introduce correo" />
              </div>
              <button type="submit" name="emailsubscibe" class="btn btn-block">¡Suscribirse! <span
                  class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
            </form>
            <p class="subscribed-text">*Enviamos buenas ofertas a nuestros suscriptores cada semana.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-push-6 text-right">
          <div class="footer_widget">
            <p>Contáctanos:</p>
            <ul>
              <li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-6 col-md-pull-6">
          <p class="copy-right">Destiny Rent a Car</p>
        </div>
      </div>
    </div>
  </div>
</footer>
<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top-->

<!--Login-Form -->
<?php include('includes/login.php'); ?>
<!--/Login-Form -->

<!--Register-Form -->
<?php include('includes/registration.php'); ?>

<!--/Register-Form -->

<!--Forgot-password-Form -->
<?php include('includes/forgotpassword.php'); ?>
<!--/Forgot-password-Form -->

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
<!--Switcher-->
<script src="assets/switcher/js/switcher.js"></script>
<!--bootstrap-slider-JS-->
<script src="assets/js/bootstrap-slider.min.js"></script>
<!--Slider-JS-->
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<!--Date Picker-->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>

</html>