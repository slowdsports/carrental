<?php
$pagetype = $_GET['type'];
$sql = "SELECT type,detail,PageName from tblpages where type=:pagetype";
$query = $dbh->prepare($sql);
$query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
        <section class="page-header aboutus_page">
            <div class="container">
                <div class="page-header_wrap">
                    <div class="page-heading">
                        <h1><?php echo htmlentities($result->PageName); ?></h1>
                    </div>
                    <ul class="coustom-breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li><?php echo htmlentities($result->PageName); ?></li>
                    </ul>
                </div>
            </div>
            <!-- Dark Overlay-->
            <div class="dark-overlay"></div>
        </section>
        <section class="about_us section-padding">
            <div class="container">
                <div class="section-header text-center">


                    <h2><?php echo htmlentities($result->PageName); ?></h2>
                    <p><?php echo $result->detail; ?> </p>
                </div>
            <?php }
} ?>
    </div>
</section>
<!-- /About-us-->