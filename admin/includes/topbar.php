<div class="brand clearfix">
	<a href="?p=dashboard" style="font-size: 25px;">Destiny Rent a Car | Administración</a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		<ul class="ts-profile-nav">

			<li class="ts-account">
				<a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt="">
					<?= htmlentities($_SESSION['alogin'] ?? ''); ?>
					<?php if (!empty($_SESSION['arolename'])) { ?><span class="label label-info"><?= htmlentities($_SESSION['arolename']); ?></span><?php } ?>
					<i class="fa fa-angle-down hidden-side"></i></a>
				<ul>
					<li><a href="?p=change-password">Cambiar contraseña</a></li>
					<li><a href="?p=logout">Salir</a></li>
				</ul>
			</li>
		</ul>
	</div>
