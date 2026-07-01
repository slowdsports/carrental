			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>

	<!-- Swal ya está cargado desde el <head>; aquí sólo registramos el manejador de data-confirm -->
	<script>
	document.addEventListener('click', function (e) {
	    var el = e.target.closest('[data-confirm]');
	    if (!el) return;
	    e.preventDefault();
	    Swal.fire({
	        title: el.getAttribute('data-confirm'),
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonText: 'Sí',
	        cancelButtonText: 'Cancelar',
	        confirmButtonColor: '#5e6ad2',
	        cancelButtonColor: '#3a3a3f'
	    }).then(function (result) {
	        if (result.isConfirmed) {
	            window.location.href = el.getAttribute('href');
	        }
	    });
	});
	</script>
</body>
</html>
