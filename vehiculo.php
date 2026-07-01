<?php
$vhid = intval($_GET['vhid']);

// Datos del vehículo solicitado (se usa para mostrar la página y para la lógica de reserva)
$sql = "SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id as bid  from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand where tblvehicles.id=:vhid";
$query = $dbh->prepare($sql);
$query->bindParam(':vhid', $vhid, PDO::PARAM_INT);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);
if ($result) {
    $_SESSION['brndid'] = $result->bid;
}

// Obtener reservas activas del vehículo actual
$sqlBookings = "SELECT BookingNumber, FromDate, ToDate
                FROM tblbooking
                WHERE VehicleId=:vhid
                  AND (Status=0 OR Status=1)"; // solo reservas confirmadas
$queryBookings = $dbh->prepare($sqlBookings);
$queryBookings->bindParam(':vhid', $vhid, PDO::PARAM_INT);
$queryBookings->execute();
$bookings = $queryBookings->fetchAll(PDO::FETCH_OBJ);
// Convertir a array para JS
$reservas = [];
foreach ($bookings as $bk) {
    $reservas[] = [
        "from" => $bk->FromDate,
        "to" => $bk->ToDate
    ];
}

if (isset($_POST['submit'])) {
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $message = $_POST['message'];
    if ($_SESSION['login']) {
        $useremail = $_SESSION['login'];
        $guestname = null;
    } else {
        $useremail = trim($_POST['guestemail']);
        $guestname = trim($_POST['guestname']);
    }
    $status = 0;
    $bookingno = mt_rand(100000000, 999999999);
    $bookingVehicleId = $vhid;
    $substituted = false;
    $similarVehicle = null;

    $ret = "SELECT * FROM tblbooking WHERE VehicleId=:vhid AND (Status=0 OR Status=1) AND (:fromdate BETWEEN date(FromDate) AND date(ToDate) OR :todate BETWEEN date(FromDate) AND date(ToDate) OR date(FromDate) BETWEEN :fromdate AND :todate
          )";
    $query1 = $dbh->prepare($ret);
    $query1->bindParam(':vhid', $vhid, PDO::PARAM_STR);
    $query1->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query1->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query1->execute();

    if ($query1->rowCount() > 0 && $result && $result->VehicleCategory) {
        // El vehículo solicitado no está disponible: buscamos uno similar (misma categoría) que sí lo esté
        $sqlSimilar = "SELECT v.id, v.VehiclesTitle, v.PricePerDay, b.BrandName
                        FROM tblvehicles v
                        JOIN tblbrands b ON b.id = v.VehiclesBrand
                        WHERE v.VehicleCategory = :category AND v.id != :vhid
                        AND v.id NOT IN (
                            SELECT VehicleId FROM tblbooking
                            WHERE (Status=0 OR Status=1)
                            AND (:fromdate2 BETWEEN DATE(FromDate) AND DATE(ToDate)
                                 OR :todate2 BETWEEN DATE(FromDate) AND DATE(ToDate)
                                 OR DATE(FromDate) BETWEEN :fromdate2 AND :todate2)
                        )
                        ORDER BY ABS(v.PricePerDay - :origprice) ASC
                        LIMIT 1";
        $querySimilar = $dbh->prepare($sqlSimilar);
        $querySimilar->bindParam(':category', $result->VehicleCategory, PDO::PARAM_STR);
        $querySimilar->bindParam(':vhid', $vhid, PDO::PARAM_INT);
        $querySimilar->bindParam(':fromdate2', $fromdate, PDO::PARAM_STR);
        $querySimilar->bindParam(':todate2', $todate, PDO::PARAM_STR);
        $querySimilar->bindParam(':origprice', $result->PricePerDay, PDO::PARAM_INT);
        $querySimilar->execute();
        $similarVehicle = $querySimilar->fetch(PDO::FETCH_OBJ);

        if ($similarVehicle) {
            $bookingVehicleId = $similarVehicle->id;
            $substituted = true;
        }
    }

    if ($query1->rowCount() == 0 || $substituted) {

        $sql = "INSERT INTO tblbooking(BookingNumber,userEmail,GuestName,VehicleId,FromDate,ToDate,message,Status) VALUES(:bookingno,:useremail,:guestname,:vhid,:fromdate,:todate,:message,:status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bookingno', $bookingno, PDO::PARAM_STR);
        $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
        $query->bindParam(':guestname', $guestname, PDO::PARAM_STR);
        $query->bindParam(':vhid', $bookingVehicleId, PDO::PARAM_STR);
        $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
        $query->bindParam(':todate', $todate, PDO::PARAM_STR);
        $query->bindParam(':message', $message, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $bookedVehicleName = $substituted
                ? ($similarVehicle->BrandName . ' ' . $similarVehicle->VehiclesTitle)
                : ($result->BrandName . ' ' . $result->VehiclesTitle);
            $emailBody = '<p>Hola' . ($guestname ? ' ' . htmlspecialchars($guestname) : '') . ',</p>'
                . '<p>Gracias por tu reserva en Destiny Rent a Car. Aquí están los detalles:</p>'
                . '<table style="width:100%;border-collapse:collapse;margin:12px 0;">'
                . '<tr><td style="padding:6px 0;color:#777;">Número de reserva</td><td style="padding:6px 0;font-weight:bold;">#' . htmlspecialchars($bookingno) . '</td></tr>'
                . '<tr><td style="padding:6px 0;color:#777;">Vehículo</td><td style="padding:6px 0;font-weight:bold;">' . htmlspecialchars($bookedVehicleName) . '</td></tr>'
                . '<tr><td style="padding:6px 0;color:#777;">Desde</td><td style="padding:6px 0;">' . htmlspecialchars($fromdate) . '</td></tr>'
                . '<tr><td style="padding:6px 0;color:#777;">Hasta</td><td style="padding:6px 0;">' . htmlspecialchars($todate) . '</td></tr>'
                . '</table>'
                . ($substituted ? '<p>El vehículo que buscabas (' . htmlspecialchars($result->BrandName . ' ' . $result->VehiclesTitle) . ') no estaba disponible para esas fechas, así que te reservamos uno similar de la misma categoría.</p>' : '')
                . '<p>Te contactaremos pronto para confirmar los detalles de tu reserva.</p>';
            send_app_email($useremail, 'Confirmación de tu reserva #' . $bookingno, render_email_template('¡Reserva recibida!', $emailBody));

            $redirectUrl = '?p=reserva-confirmada&bookingno=' . urlencode($bookingno)
                . '&name=' . urlencode($guestname ?? '')
                . '&email=' . urlencode($useremail);
            if ($substituted) {
                $redirectUrl .= '&original=' . urlencode($result->BrandName . ' ' . $result->VehiclesTitle)
                    . '&similar=' . urlencode($similarVehicle->BrandName . ' ' . $similarVehicle->VehiclesTitle)
                    . '&category=' . urlencode($result->VehicleCategory);
            }
            echo "<script type='text/javascript'> document.location = '" . $redirectUrl . "'; </script>";
        } else {
            echo "<script>Swal.fire('¡Algo no funcionó bien. NO se pudo realizar la reserva!').then(function(){ document.location = '?p=vehiculos'; });</script>";
        }
    } else {
        echo "<script>alert('Lo sentimos, este vehículo no está disponible para esas fechas y no encontramos uno similar disponible. Por favor intenta con otras fechas.');</script>";
    }

}
?>
<!--Listing-Image-Slider-->
<section id="listing_img_slider">
    <div>
        <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive"
            alt="image" width="900" height="560">
    </div>
    <div>
        <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage2); ?>" class="img-responsive"
            alt="image" width="900" height="560">
    </div>
    <div>
        <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage3); ?>" class="img-responsive"
            alt="image" width="900" height="560">
    </div>
    <div>
        <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage4); ?>" class="img-responsive"
            alt="image" width="900" height="560">
    </div>
    <?php if ($result->Vimage5 == "") {
    } else { ?>
        <div>
            <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage5); ?>" class="img-responsive"
                alt="image" width="900" height="560">
        </div>
    <?php } ?>
</section>
<!--/Listing-Image-Slider-->
<!--Listing-detail-->
<?php include('includes/listing-detail.php'); ?>
<!--/Listing-detail-->