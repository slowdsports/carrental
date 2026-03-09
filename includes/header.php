<!DOCTYPE HTML>
<html lang="es">

<head>

    <title>Destiny Rent a Car</title>
    <!--Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <link href="assets/css/slick.css" rel="stylesheet">
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <!--<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">-->
    <link rel="shortcut icon" href="assets/images/destinyw.jpeg">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!--Date Picker-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <?php if (isset($_GET["p"]) && $_GET["p"] == "profile") { ?>
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
    <?php } ?>
</head>

<body>
    <header>
        <div class="default-header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 col-md-2">
                        <div class="logo"> <a href="index.php"><img src="assets/images/logob.png" alt="image" /></a>
                        </div>
                    </div>
                    <div class="col-sm-9 col-md-10">
                        <div class="header_info">
                            <?php
                            $sql = "SELECT EmailId,ContactNo from tblcontactusinfo";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            foreach ($results as $result) {
                                $email = $result->EmailId;
                                $contactno = $result->ContactNo;
                            }
                            ?>

                            <div class="header_widgets">
                                <div class="circle_icon"> <i class="fa fa-envelope" aria-hidden="true"></i> </div>
                                <p class="uppercase_text">Contáctanos: </p>
                                <a
                                    href="mailto:<?php echo htmlentities($email); ?>"><?php echo htmlentities($email); ?></a>
                            </div>
                            <div class="header_widgets">
                                <div class="circle_icon"> <i class="fa fa-phone" aria-hidden="true"></i> </div>
                                <p class="uppercase_text">Llámanos por ayuda: </p>
                                <a href="https://api.whatsapp.com/send?phone=504<?php echo htmlentities($contactno); ?>"
                                    target="_blank"><?php echo htmlentities($contactno); ?></a>
                            </div>
                            <div class="social-follow">

                            </div>
                            <?php echo (strlen($_SESSION['login']) == 0) ? '<div class="login_btn"><a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Entrar / Registrarse</a></div>' : ''; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav id="navigation_bar" class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button id="menu_slide" data-target="#navigation" aria-expanded="false" data-toggle="collapse"
                        class="navbar-toggle collapsed" type="button"> <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="header_wrap">
                    <div class="user_login">
                        <ul>
                            <li class="dropdown"> <a href="#" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="fa fa-user-circle" aria-hidden="true"></i>
                                    <?php
                                    $email = $_SESSION['login'];
                                    $sql = "SELECT FullName FROM tblusers WHERE EmailId=:email ";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':email', $email, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) {

                                            echo htmlentities($result->FullName);
                                        }
                                    } ?>
                                    <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <ul class="dropdown-menu">
                                    <?php if ($_SESSION['login']) { ?>
                                        <li><a href="?p=profile">Configuración de cuenta</a></li>
                                        <li><a href="?p=my-booking">Rentas</a></li>
                                        <li><a href="?p=logout">Cerrar sesión</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="header_search">
                        <div id="search_toggle"><i class="fa fa-search" aria-hidden="true"></i></div>
                        <form action="?p=search" method="post" id="header-search-form">
                            <input type="text" placeholder="Buscar..." name="searchdata" class="form-control"
                                required="true">
                            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="navigation">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Inicio</a> </li>

                        <li><a href="page.php?type=aboutus">Acerca de</a></li>
                        <li><a href="?p=vehiculos">Vehículos</a>
                        <li><a href="page.php?type=faqs">FAQs</a></li>
                        <li><a href="contact-us.php">Contacto</a></li>

                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navigation end -->
    </header>