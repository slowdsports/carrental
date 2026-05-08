<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
}
?>
<!doctype html>
<html lang="es" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>Destiny | Características del inicio</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Características del inicio</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading">Lista de características</div>
                            <div class="panel-body">
                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ícono</th>
                                            <th>Título</th>
                                            <th>Subtítulo</th>
                                            <th>Orden</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Ícono</th>
                                            <th>Título</th>
                                            <th>Subtítulo</th>
                                            <th>Orden</th>
                                            <th>Acción</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM tblfeatures ORDER BY SortOrder ASC";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        foreach ($results as $result): ?>
                                        <tr>
                                            <td><?= $cnt; ?></td>
                                            <td>
                                                <i class="fa <?= htmlentities($result->Icon); ?> fa-lg" style="margin-right:6px;"></i>
                                                <code><?= htmlentities($result->Icon); ?></code>
                                            </td>
                                            <td><?= htmlentities($result->Title); ?></td>
                                            <td><?= htmlentities($result->Subtitle); ?></td>
                                            <td><?= htmlentities($result->SortOrder); ?></td>
                                            <td>
                                                <a href="edit-feature.php?id=<?= $result->id; ?>" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-edit"></i> Editar
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $cnt++; endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
