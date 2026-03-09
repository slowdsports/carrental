<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
  header('location:index.php');
} else {
  if (isset($_POST['updateprofile'])) {
    $name = $_POST['fullname'];
    $mobileno = $_POST['mobilenumber'];
    $dob = $_POST['dob'];
    $adress = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $email = $_SESSION['login'];
    $sql = "update tblusers set FullName=:name,ContactNo=:mobileno,dob=:dob,Address=:adress,City=:city,Country=:country where EmailId=:email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
    $query->bindParam(':adress', $adress, PDO::PARAM_STR);
    $query->bindParam(':city', $city, PDO::PARAM_STR);
    $query->bindParam(':country', $country, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $msg = "Tu perfil se actualizó satisfactoriamente";
  } ?>
  <!--Page Header-->
  <section class="page-header profile_page">
    <div class="container">
      <div class="page-header_wrap">
        <div class="page-heading">
          <h1>Perfil</h1>
        </div>
        <ul class="coustom-breadcrumb">
          <li><a href="?p=home">Inicio</a></li>
          <li>Perfil</li>
        </ul>
      </div>
    </div>
    <!-- Dark Overlay-->
    <div class="dark-overlay"></div>
  </section>
  <!-- /Page Header-->


  <?php
  $useremail = $_SESSION['login'];
  $sql = "SELECT * from tblusers where EmailId=:useremail";
  $query = $dbh->prepare($sql);
  $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  $cnt = 1;
  if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
      <section class="user_profile inner_pages">
        <div class="container">
          <div class="user_profile_info gray-bg padding_4x4_40">
            <div class="upload_user_logo"> <img src="assets/images/dealer-logo.jpg" alt="image">
            </div>

            <div class="dealer_info">
              <h5><?php echo htmlentities($result->FullName); ?></h5>
              <p><?php echo htmlentities($result->Address); ?><br>
                <?php echo htmlentities($result->City); ?>&nbsp;<?php echo htmlentities($result->Country); ?></p>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3 col-sm-3">
              <?php include('includes/sidebar.php'); ?>
              <div class="col-md-6 col-sm-8">
                <div class="profile_wrap">
                  <h5 class="uppercase underline">Generales</h5>
                  <?php
                  if ($msg) { ?>
                    <div class="succWrap"><?php echo htmlentities($msg); ?> </div><?php } ?>
                  <form method="post">
                    <div class="form-group">
                      <label class="control-label">Fecha de registro -</label>
                      <?php echo htmlentities($result->RegDate); ?>
                    </div>
                    <?php if ($result->UpdationDate != "") { ?>
                      <div class="form-group">
                        <label class="control-label">Última actualización -</label>
                        <?php echo htmlentities($result->UpdationDate); ?>
                      </div>
                    <?php } ?>
                    <div class="form-group">
                      <label class="control-label">Nombre completo</label>
                      <input class="form-control white_bg" name="fullname"
                        value="<?php echo htmlentities($result->FullName); ?>" id="fullname" type="text" required>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Correo electrónico</label>
                      <input class="form-control white_bg" value="<?php echo htmlentities($result->EmailId); ?>"
                        name="emailid" id="email" type="email" required readonly>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Celular</label>
                      <input class="form-control white_bg" name="mobilenumber"
                        value="<?php echo htmlentities($result->ContactNo); ?>" id="phone-number" type="text" required>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Fecha de nacimiento&nbsp;(dd/mm/yyyy)</label>
                      <input class="form-control white_bg" value="<?php echo htmlentities($result->dob); ?>" name="dob"
                        placeholder="dd/mm/yyyy" id="birth-date" type="text">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Dirección</label>
                      <textarea class="form-control white_bg" name="address"
                        rows="4"><?php echo htmlentities($result->Address); ?></textarea>
                    </div>
                    <div class="form-group">
                      <label class="control-label">País</label>
                      <input class="form-control white_bg" id="country" name="country"
                        value="<?php echo htmlentities($result->Country); ?>" type="text">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Ciudad</label>
                      <input class="form-control white_bg" id="city" name="city"
                        value="<?php echo htmlentities($result->City); ?>" type="text">
                    </div>
                  <?php }
  } ?>

                <div class="form-group">
                  <button type="submit" name="updateprofile" class="btn">Guardar cambios <span class="angle_arrow"><i
                        class="fa fa-angle-right" aria-hidden="true"></i></span></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
  </section>
  <!--/Profile-setting-->
<?php } ?>