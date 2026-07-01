<?php
$msg = '';
$error = '';
if ($_POST['submit'] == "Update") {
    $pagetype = $_GET['type'];
    $pagedetails = $_POST['pgedetails'];
    $sql = "UPDATE tblpages SET detail=:pagedetails WHERE type=:pagetype";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
    $query->bindParam(':pagedetails', $pagedetails, PDO::PARAM_STR);
    $query->execute();
    $msg = "Información de página actualizada correctamente";
}
?>
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script type="text/javascript" src="nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<h2 class="page-title">Administrar páginas</h2>

<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading">Páginas</div>
			<div class="panel-body">
				<form method="post" name="chngpwd" class="form-horizontal">

				<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?= htmlentities($error); ?> </div><?php }
				else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?= htmlentities($msg); ?> </div><?php } ?>
					<div class="form-group">
						<label class="col-sm-4 control-label">Seleccionar</label>
						<div class="col-sm-8">
							   <select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
              <option value="" selected="selected" class="form-control">***Seleccionar***</option>
              <option value="?p=manage-pages&type=terms">Términos y Condiciones</option>
              <option value="?p=manage-pages&type=privacy">Privacidad y Política</option>
              <option value="?p=manage-pages&type=aboutus">Acerca de</option>
              <option value="?p=manage-pages&type=faqs">Preguntas Frecuentes</option>
            </select>
						</div>
					</div>
					<div class="hr-dashed"></div>

					<div class="form-group">
						<label class="col-sm-4 control-label">Editando:</label>
						<div class="col-sm-8">
		<?php

		switch ($_GET['type']) {
			case "terms":
								echo "Términos y Condiciones";
								break;

			case "privacy":
								echo "Privacidad y Política";
								break;

			case "aboutus":
								echo "Acerca de";
								break;

			case "faqs":
								echo "Preguntas Frecuentes";
								break;

			default:
							echo "";
							break;

		}

		?>
						</div>
					</div>

				<div class="form-group">
						<label class="col-sm-4 control-label">Contenido de la página </label>
						<div class="col-sm-8">
		<textarea class="form-control" rows="5" cols="50" name="pgedetails" id="pgedetails" placeholder="Package Details" required>
									<?php
$pagetype = $_GET['type'];
$sql = "SELECT detail from tblpages where type=:pagetype";
$query = $dbh->prepare($sql);
$query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
    foreach ($results as $result) {
        echo htmlentities($result->detail);
    }
}
?>

									</textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-4">
						<button type="submit" name="submit" value="Update" id="submit" class="btn-primary btn">Actualizar</button>
						</div>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>
