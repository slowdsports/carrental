<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$baseUrl  = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$currentUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$page = isset($_GET['p']) ? $_GET['p'] : 'home';
$type = isset($_GET['type']) ? $_GET['type'] : '';

$pageTitles = [
    'home'       => 'Destiny Rent a Car | Renta de Autos en San Pedro Sula, Honduras',
    'vehiculos'  => 'Vehículos Disponibles | Renta de Autos San Pedro Sula — Destiny',
    'contact-us' => 'Contáctanos | Destiny Rent a Car San Pedro Sula, Honduras',
    'my-booking' => 'Mis Reservas | Destiny Rent a Car',
    'profile'    => 'Mi Perfil | Destiny Rent a Car',
    'search'     => 'Buscar Vehículos | Destiny Rent a Car San Pedro Sula',
    'page'       => [
        'aboutus' => 'Acerca de Nosotros | Destiny Rent a Car San Pedro Sula',
        'faqs'    => 'Preguntas Frecuentes | Destiny Rent a Car',
        'privacy' => 'Política de Privacidad | Destiny Rent a Car',
        'terms'   => 'Términos de Uso | Destiny Rent a Car',
    ],
];
if ($page === 'page' && isset($pageTitles['page'][$type])) {
    $pageTitle = $pageTitles['page'][$type];
} else {
    $pageTitle = $pageTitles[$page] ?? 'Destiny Rent a Car | San Pedro Sula, Honduras';
}

$pageDescs = [
    'home'       => 'Renta el auto perfecto en San Pedro Sula, Honduras. Destiny Rent a Car ofrece vehículos automáticos y manuales, kilómetros ilimitados y retiro en aeropuerto. Reserva en línea hoy.',
    'vehiculos'  => 'Explora nuestra flota de vehículos para renta en San Pedro Sula. Automáticos, manuales, SUV y más. Precios accesibles con kilómetros ilimitados.',
    'contact-us' => 'Contáctanos en Destiny Rent a Car, San Pedro Sula, Honduras. Atención personalizada para tu renta de vehículo.',
];
$pageDesc = $pageDescs[$page] ?? 'Destiny Rent a Car — Tu mejor opción para renta de vehículos en San Pedro Sula, Honduras. Flota moderna, precios accesibles, kilómetros ilimitados y retiro en aeropuerto.';
?>
<!DOCTYPE HTML>
<html lang="es">

<head>
    <!-- SEO: Primary -->
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <meta name="description" content="<?= htmlspecialchars($pageDesc) ?>">
    <meta name="keywords" content="renta de autos san pedro sula, alquiler de carros honduras, rent a car san pedro sula, renta de vehiculos honduras, destiny rent a car, renta de carros san pedro sula, alquiler autos aeropuerto san pedro sula, renta autos cortés honduras">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Destiny Rent a Car">
    <link rel="canonical" href="<?= htmlspecialchars($currentUrl) ?>">

    <!-- SEO: Geo / Local -->
    <meta name="geo.region" content="HN-CR">
    <meta name="geo.placename" content="San Pedro Sula, Cortés, Honduras">
    <meta name="geo.position" content="15.5027;-88.0251">
    <meta name="ICBM" content="15.5027, -88.0251">

    <!-- SEO: Open Graph (Facebook, WhatsApp, LinkedIn) -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_HN">
    <meta property="og:site_name" content="Destiny Rent a Car">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDesc) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($currentUrl) ?>">
    <meta property="og:image" content="<?= $baseUrl ?>/admin/img/promo/1.jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Destiny Rent a Car — San Pedro Sula, Honduras">

    <!-- SEO: Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDesc) ?>">
    <meta name="twitter:image" content="<?= $baseUrl ?>/admin/img/promo/1.jpeg">
    <meta name="twitter:image:alt" content="Destiny Rent a Car — San Pedro Sula, Honduras">

    <!-- SEO: Schema.org LocalBusiness (JSON-LD) -->
    <?php
    $sqlSeo = "SELECT Address, EmailId, ContactNo FROM tblcontactusinfo LIMIT 1";
    $qSeo   = $dbh->prepare($sqlSeo);
    $qSeo->execute();
    $seoInfo = $qSeo->fetch(PDO::FETCH_OBJ);
    $seoPhone   = $seoInfo ? htmlspecialchars($seoInfo->ContactNo) : '';
    $seoEmail   = $seoInfo ? htmlspecialchars($seoInfo->EmailId)   : '';
    $seoAddress = $seoInfo ? htmlspecialchars($seoInfo->Address)   : '';
    ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "CarRental",
      "name": "Destiny Rent a Car",
      "description": "Renta de autos en San Pedro Sula, Honduras. Flota moderna, km ilimitados y retiro en aeropuerto.",
      "url": "<?= $baseUrl ?>",
      "logo": "<?= $baseUrl ?>/assets/images/destinyb.jpg",
      "image": "<?= $baseUrl ?>/admin/img/promo/1.jpeg",
      "telephone": "<?= $seoPhone ?>",
      "email": "<?= $seoEmail ?>",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?= $seoAddress ?>",
        "addressLocality": "San Pedro Sula",
        "addressRegion": "Cortés",
        "addressCountry": "HN"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": "15.5027",
        "longitude": "-88.0251"
      },
      "areaServed": {
        "@type": "Country",
        "name": "Honduras"
      },
      "priceRange": "$$",
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
        "opens": "08:00",
        "closes": "18:00"
      }
    }
    </script>

    <!--Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <link href="assets/css/slick.css" rel="stylesheet">
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/destinyw.jpeg">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <?php if ($page === 'profile'): ?>
    <style>
        .errorWrap { padding:10px; margin:0 0 20px; background:#fff; border-left:4px solid #dd3d36; box-shadow:0 1px 1px rgba(0,0,0,.1); }
        .succWrap  { padding:10px; margin:0 0 20px; background:#fff; border-left:4px solid #5cb85c; box-shadow:0 1px 1px rgba(0,0,0,.1); }
    </style>
    <?php endif; ?>
</head>

<body>
    <header>
        <div class="default-header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 col-md-2">
                        <div class="logo"> <a href="index.php"><img src="assets/images/logob.png" alt="Destiny Rent a Car" /></a>
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
                                <a href="mailto:<?php echo htmlentities($email); ?>"><?php echo htmlentities($email); ?></a>
                            </div>
                            <div class="header_widgets">
                                <div class="circle_icon"> <i class="fa fa-phone" aria-hidden="true"></i> </div>
                                <p class="uppercase_text">Llámanos por ayuda: </p>
                                <a href="https://api.whatsapp.com/send?phone=504<?php echo htmlentities($contactno); ?>"
                                    target="_blank"><?php echo htmlentities($contactno); ?></a>
                            </div>
                            <div class="social-follow"></div>
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
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="?p=page&type=aboutus">Acerca de</a></li>
                        <li><a href="?p=vehiculos">Vehículos</a></li>
                        <li><a href="?p=page&type=terms">Términos</a></li>
                        <li><a href="?p=page&type=privacy">Políticas</a></li>
                        <li><a href="?p=page&type=faqs">FAQs</a></li>
                        <li><a href="?p=contact-us">Contacto</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navigation end -->
    </header>
