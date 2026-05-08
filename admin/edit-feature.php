<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
}

$msg = '';
$error = '';

if (isset($_POST['submit'])) {
    $id = intval($_GET['id']);
    $icon = trim($_POST['icon']);
    $title = trim($_POST['title']);
    $subtitle = trim($_POST['subtitle']);
    $sortorder = intval($_POST['sortorder']);

    $sql = "UPDATE tblfeatures SET Icon=:icon, Title=:title, Subtitle=:subtitle, SortOrder=:sortorder WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':icon', $icon, PDO::PARAM_STR);
    $query->bindParam(':title', $title, PDO::PARAM_STR);
    $query->bindParam(':subtitle', $subtitle, PDO::PARAM_STR);
    $query->bindParam(':sortorder', $sortorder, PDO::PARAM_INT);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();

    if ($query->rowCount() >= 0) {
        $msg = "Característica actualizada correctamente.";
    } else {
        $error = "Algo no funcionó bien. Intenta nuevamente.";
    }
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM tblfeatures WHERE id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(':id', $id, PDO::PARAM_INT);
$query->execute();
$feature = $query->fetch(PDO::FETCH_OBJ);

if (!$feature) {
    header('location:manage-features.php');
    exit;
}
?>
<!doctype html>
<html lang="es" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>Destiny | Editar Característica</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .errorWrap { padding:10px; margin:0 0 20px; background:#fff; border-left:4px solid #dd3d36; box-shadow:0 1px 1px rgba(0,0,0,.1); }
        .succWrap  { padding:10px; margin:0 0 20px; background:#fff; border-left:4px solid #5cb85c; box-shadow:0 1px 1px rgba(0,0,0,.1); }
        .icon-preview { font-size:48px; display:inline-block; margin:10px 0; vertical-align:middle; }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h2 class="page-title">Editar Característica</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading">Información de la característica</div>
                            <div class="panel-body">
                                <?php if ($error): ?>
                                    <div class="errorWrap"><strong>ERROR:</strong> <?= htmlentities($error); ?></div>
                                <?php elseif ($msg): ?>
                                    <div class="succWrap"><strong>OK:</strong> <?= htmlentities($msg); ?></div>
                                <?php endif; ?>

                                <form method="post" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Ícono <span style="color:red">*</span></label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i id="iconPreview" class="fa <?= htmlentities($feature->Icon); ?>"></i>
                                                </span>
                                                <input type="text" name="icon" id="iconInput"
                                                       class="form-control"
                                                       value="<?= htmlentities($feature->Icon); ?>"
                                                       placeholder="Ej: fa-heart, fa-car, fa-gift"
                                                       required>
                                            </div>
                                            <p class="help-block">
                                                Usa clases de <a href="https://fontawesome.com/v4/icons/" target="_blank">Font Awesome 4</a>.
                                                Ejemplos: <code>fa-heart</code>, <code>fa-car</code>, <code>fa-gift</code>, <code>fa-star</code>, <code>fa-trophy</code>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Título <span style="color:red">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="title" class="form-control"
                                                   value="<?= htmlentities($feature->Title); ?>"
                                                   placeholder="Título de la característica" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Subtítulo <span style="color:red">*</span></label>
                                        <div class="col-sm-9">
                                            <textarea name="subtitle" class="form-control" rows="3"
                                                      placeholder="Descripción breve" required><?= htmlentities($feature->Subtitle); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Orden</label>
                                        <div class="col-sm-3">
                                            <input type="number" name="sortorder" class="form-control"
                                                   value="<?= htmlentities($feature->SortOrder); ?>" min="1">
                                        </div>
                                    </div>

                                    <div class="hr-dashed"></div>

                                    <div class="form-group">
                                        <div class="col-sm-9 col-sm-offset-3">
                                            <a href="manage-features.php" class="btn btn-default">
                                                <i class="fa fa-arrow-left"></i> Volver
                                            </a>
                                            <button class="btn btn-primary" name="submit" type="submit">
                                                <i class="fa fa-save"></i> Guardar cambios
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        document.getElementById('iconInput').addEventListener('input', function() {
            var preview = document.getElementById('iconPreview');
            preview.className = 'fa ' + this.value.trim();
        });
    </script>
</body>
</html>
