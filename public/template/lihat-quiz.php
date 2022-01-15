<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Management Competition - Lihat Quiz</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
	<link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
	<link href="vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	
	<link href="vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

		<?php require_once "header.php" ?>
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
                <!-- Title -->
				<div class="col-lg-12">
					<div class="d-flex justify-content-start align-items-center mb-4">
						<svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#222fb9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
							<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
							<polyline points="14 2 14 8 20 8"></polyline>
							<line x1="16" y1="13" x2="8" y2="13"></line>
							<line x1="16" y1="17" x2="8" y2="17"></line>
							<polyline points="10 9 9 9 8 9"></polyline>
						</svg>
						<h4 class="text-primary ml-2 mt-2">Submit Quiz</h4>
					</div>
				</div>
                <div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="example5" class="table display mb-4 table-responsive-xl dataTablesCard fs-14">
								<thead>
									<tr>
										<th>No</th>
										<th>User</th>
										<th>Username</th>
										<th>Password</th>
										<th>Quiz</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td><img class="rounded-circle" alt="image" width="50" src="images/avatar/1.png"></td>
										<td>Pujayana</td>
										<td>12345678</td>
										<td>
											<a href="periksa-quiz.php"><span class="badge badge-success">Periksa Quiz</span></a>
										</td>
									</tr>
									<tr>
										<td>2</td>
										<td><img class="rounded-circle" alt="image" width="50" src="images/avatar/1.png"></td>
										<td>Kak Mario</td>
										<td>12345678</td>
										<td>
											<a href="periksa-quiz.php"><span class="badge badge-success">Periksa Quiz</span></a>
										</td>
									</tr>
									<tr>
										<td>3</td>
										<td><img class="rounded-circle" alt="image" width="50" src="images/avatar/1.png"></td>
										<td>Wirajaya</td>
										<td>12345678</td>
										<td>
											<a href="periksa-quiz.php"><span class="badge badge-success">Periksa Quiz</span></a>
										</td>
									</tr>
									<tr>
										<td>4</td>
										<td><img class="rounded-circle" alt="image" width="50" src="images/avatar/1.png"></td>
										<td>Gonzales</td>
										<td>12345678</td>
										<td>
											<a href="periksa-quiz.php"><span class="badge badge-success">Periksa Quiz</span></a>
										</td>
									</tr>
									<tr>
										<td>5</td>
										<td><img class="rounded-circle" alt="image" width="50" src="images/avatar/1.png"></td>
										<td>Helo</td>
										<td>12345678</td>
										<td>
											<a href="periksa-quiz.php"><span class="badge badge-success">Periksa Quiz</span></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
                    </div>
				</div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        <?php require_once "footer.php" ?>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	
	<script src="vendor/bootstrap-datetimepicker/js/moment.js"></script>
	<script src="vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
	
    <script src="js/custom.min.js"></script>
	<script src="js/deznav-init.js"></script>

	<script src="vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <script>
		$(".sweet-confirm").on('click', function(){
			swal({
				title: "Yakin ingin menghapus Username ?",
				text: "Jika yakin anda dapat menekan tombol hapus dibawah",
				type: "warning",
				showCancelButton: !0,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Hapus",
				closeOnConfirm: !1,
			}, function () {
				swal("Peserta Dihapus", "Berhasil menghapus peserta", "success")
			})
		});
	</script>

	<!-- Apex Chart -->
	<script src="vendor/apexchart/apexchart.js"></script>
	
	<!-- Datatable -->
	<script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
	
	<script>
        $(function () {
            $('#datetimepicker12').datetimepicker({
                inline: true,
                sideBySide: true
            });
        });
    </script>
	<script>
		(function($) {
		 
			var table = $('#example5').DataTable({
				searching: false,
				paging:true,
				select: false,
				//info: false,         
				lengthChange:false 
				
			});
			$('#example tbody').on('click', 'tr', function () {
				var data = table.row( this ).data();
				
			});

			$('.metismenu li:nth-child(3)').addClass('mm-active');
		   
		})(jQuery);
	</script>
	
</body>
</html>