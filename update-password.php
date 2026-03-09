<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
  header('location:index.php');
} else {
  if (isset($_POST['updatepass'])) {
    $password = md5($_POST['password']);
    $newpassword = md5($_POST['newpassword']);
    $email = $_SESSION['login'];
    $sql = "SELECT Password FROM tblusers WHERE EmailId=:email and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
      $con = "update tblusers set Password=:newpassword where EmailId=:email";
      $chngpwd1 = $dbh->prepare($con);
      $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
      $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
      $chngpwd1->execute();
      $msg = "Se cambió la contraseña";
    } else {
      $error = "Contraseña actual es incorrecta";
    }
  }

  ?>
  <script type="text/javascript">
    function valid() {
      if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
        alert("Nueva contraseña y confirmar contraseña no coinciden!");
        document.chngpwd.confirmpassword.focus();
        return false;
      }
      return true;
    }
  </script>
  <style>
    .errorWrap {
      padding: 10px;
      margin: 0 0 20px 0;
      background: #fff;
      border-left: 4px solid #dd3d36;
      -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
      box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }

    .succWrap {
      padding: 10px;
      margin: 0 0 20px 0;
      background: #fff;
      border-left: 4px solid #5cb85c;
      -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
      box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }
  </style>
  </head>

  <body>
    <!--Page Header-->
    <section class="page-header profile_page">
      <div class="container">
        <div class="page-header_wrap">
          <div class="page-heading">
            <h1>Actualización de contraseña</h1>
          </div>
          <ul class="coustom-breadcrumb">
            <li><a href="?p=home">Inicio</a></li>
            <li>Actualizar contraseña</li>
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
                  <?php echo htmlentities($result->City); ?>&nbsp;<?php echo htmlentities($result->Country);
      }
    } ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-3">
            <?php include('includes/sidebar.php'); ?>
            <div class="col-md-6 col-sm-8">
              <div class="profile_wrap">
                <form name="chngpwd" method="post" onSubmit="return valid();">

                  <div class="gray-bg field-title">
                    <h6>Actualizar contraseña</h6>
                  </div>
                  <?php if ($error) { ?>
                    <div class="errorWrap"><strong></strong><?php echo htmlentities($error); ?> </div>
                  <?php } else if ($msg) { ?>
                      <div class="succWrap"><strong></strong><?php echo htmlentities($msg); ?> </div><?php } ?>
                  <div class="form-group">
                    <label class="control-label">Contraseña actual</label>
                    <input class="form-control white_bg" id="password" name="password" type="password" required>
                  </div>
                  <div cl <div class="form-group">
                    <label class="control-label">Nueva contraseña</label>
                    <input class="form-control white_bg" id="newpassword" type="password" name="newpassword" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Confirmar nueva contraseña</label>
                    <input class="form-control white_bg" id="confirmpassword" type="password" name="confirmpassword"
                      required>
                  </div>

                  <div class="form-group">
                    <input type="submit" value="Actualizar" name="updatepass" id="submit" class="btn btn-block">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </section>
    <!--/Profile-setting-->
  <?php } ?>