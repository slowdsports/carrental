<?php
// Obtener reservas activas del vehículo actual
$vhid = $_GET['vhid'];
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


// Mostrar reservas si existen
if ($queryBookings->rowCount() > 0) {
    //echo "<h4>Reservas actuales para este vehículo:</h4><ul>";
    foreach ($bookings as $bk) {
        //echo "<li>Reserva #{$bk->BookingNumber} desde {$bk->FromDate} hasta {$bk->ToDate}</li>";
    }
    echo "</ul>";
} else {
    //echo "<p style='color:green'>Este vehículo no tiene reservas activas. ¡Disponible!</p>";
}

if (isset($_POST['submit'])) {
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $message = $_POST['message'];
    $useremail = $_SESSION['login'];
    $status = 0;
    $vhid = $_GET['vhid'];
    $bookingno = mt_rand(100000000, 999999999);
    //$ret = "SELECT * FROM tblbooking where (:fromdate BETWEEN date(FromDate) and date(ToDate) || :todate BETWEEN date(FromDate) and date(ToDate) || date(FromDate) BETWEEN :fromdate and :todate) and VehicleId=:vhid";
    $ret = "SELECT * FROM tblbooking WHERE VehicleId=:vhid AND (Status=0 OR Status=1) AND (:fromdate BETWEEN date(FromDate) AND date(ToDate) OR :todate BETWEEN date(FromDate) AND date(ToDate) OR date(FromDate) BETWEEN :fromdate AND :todate
          )";
    $query1 = $dbh->prepare($ret);
    $query1->bindParam(':vhid', $vhid, PDO::PARAM_STR);
    $query1->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query1->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query1->execute();
    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);

    if ($query1->rowCount() == 0) {

        $sql = "INSERT INTO  tblbooking(BookingNumber,userEmail,VehicleId,FromDate,ToDate,message,Status) VALUES(:bookingno,:useremail,:vhid,:fromdate,:todate,:message,:status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bookingno', $bookingno, PDO::PARAM_STR);
        $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
        $query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
        $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
        $query->bindParam(':todate', $todate, PDO::PARAM_STR);
        $query->bindParam(':message', $message, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            echo "<script>alert('¡Reserva realizada!.');</script>";
            echo "<script type='text/javascript'> document.location = '?p=my-booking'; </script>";
        } else {
            echo "<script>alert('¡Algo no funcionó bien. NO se pudo realizar la reserva!');</script>";
            echo "<script type='text/javascript'> document.location = '?p=vehiculos'; </script>";
        }
    } else {
        echo "<script>alert('Vehículo no disponible para este día');</script>";
        //echo "<script type='text/javascript'> document.location = '?p=contactus'; </script>";
    }

}
$vhid = intval($_GET['vhid']);
$sql = "SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id as bid  from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand where tblvehicles.id=:vhid";
$query = $dbh->prepare($sql);
$query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if ($query->rowCount() > 0) {
    foreach ($results as $result) {
        $_SESSION['brndid'] = $result->bid;
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