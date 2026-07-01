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
                        <a href="?p=edit-feature&id=<?= $result->id; ?>" class="btn btn-primary btn-xs">
                            <i class="fa fa-edit"></i> Editar
                        </a>
                    </td>
                </tr>
                <?php $cnt++; endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
