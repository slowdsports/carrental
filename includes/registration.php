<?php
//error_reporting(0);
if(isset($_POST['signup']))
{
$fname=$_POST['fullname'];
$email=$_POST['emailid'];
$mobile=isset($_POST['mobileno']) ? trim($_POST['mobileno']) : '';
$password=md5($_POST['password']);
$sql="INSERT INTO  tblusers(FullName,EmailId,ContactNo,Password) VALUES(:fname,:email,:mobile,:password)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':mobile',$mobile,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
// ¿Esta persona ya había reservado como invitado antes de registrarse?
$sqlPrev = "SELECT BookingNumber FROM tblbooking WHERE userEmail=:email ORDER BY PostingDate DESC";
$queryPrev = $dbh->prepare($sqlPrev);
$queryPrev->bindParam(':email', $email, PDO::PARAM_STR);
$queryPrev->execute();
$prevBookings = $queryPrev->fetchAll(PDO::FETCH_OBJ);

$welcomeBody = '<p>Hola ' . htmlspecialchars($fname) . ',</p>'
    . '<p>¡Gracias por registrarte en Destiny Rent a Car! Ya puedes iniciar sesión para ver el estado de tus reservas y agilizar tu próxima renta.</p>';
if (count($prevBookings) > 0) {
    $welcomeBody .= '<p>Vimos que ya tenías reserva(s) con nosotros antes de registrarte:</p><ul>';
    foreach ($prevBookings as $pb) {
        $welcomeBody .= '<li>Reserva #' . htmlspecialchars($pb->BookingNumber) . '</li>';
    }
    $welcomeBody .= '</ul><p>Ahora podrás verlas directamente desde tu cuenta.</p>';
}
send_app_email($email, '¡Bienvenido a Destiny Rent a Car!', render_email_template('¡Registro exitoso!', $welcomeBody));

echo "<script>alert('¡Registro exitoso! Ya puedes iniciar sesión.');</script>";
}
else
{
echo "<script>alert('Algo no funcionó bien. Por favor inténtalo nuevamente.');</script>";
}
}

?>


<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#emailid").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>

<div class="modal fade" id="signupform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Regístrate</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="signup_wrap">
            <div class="col-md-12 col-sm-6">
              <form  method="post" name="signup">
                <div class="form-group">
                  <input type="text" class="form-control" name="fullname" placeholder="Nombre Completo" required="required">
                </div>
                      <div class="form-group">
                  <input type="text" class="form-control" name="mobileno" placeholder="Número de celular (opcional)" maxlength="10">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="emailid" id="emailid" onBlur="checkAvailability()" placeholder="Correo Electrónico" required="required">
                   <span id="user-availability-status" style="font-size:12px;"></span> 
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required="required">
                </div>
          
                <div class="form-group checkbox">
                  <input type="checkbox" id="terms_agree" required="required" checked="">
                  <label for="terms_agree">Acepto <a href="#">los términos y condiciones</a></label>
                </div>
                <div class="form-group">
                  <input type="submit" value="Registrarse" name="signup" id="submit" class="btn btn-block">
                </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <p>¿Ya tienes una cuenta? <a href="#loginform" data-toggle="modal" data-dismiss="modal">Iniciar sesión</a></p>
      </div>
    </div>
  </div>
</div>