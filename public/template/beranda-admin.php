<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Management Competition</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/chartist/css/chartist.min.css">
    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
	<link href="vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
	<link href="../../cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">

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
        <div class="content-body rightside-event">
            <!-- row -->
			<div class="container-fluid">
				<div class="row">
					<div class="col-xl-12">
						<div class="welcome-card rounded pl-5 pt-5 pb-4 mt-3 position-relative mb-5">
							<h4 class="text-warning">Halo Admin,</h4>
							<p>Selamat datang di website Management Competition, ini merupakan website tentang multiple choice dan essay.</p>
							<a class="btn btn-warning btn-rounded" href="quiz.php">Buat Quiz <i class="las la-long-arrow-alt-right ml-2"></i></a>
							<!-- <a class="btn-link text-dark ml-3" href="javascript:void(0);">Remind Me Later</a> -->
							<img src="images/svg/welcom-card.svg" alt="" class="position-absolute">
						</div>
					</div>
					<div class="col-xl-12">
						<div class="card widget-media">
							<div class="card-header border-0 pb-0 ">
								<h4 class="text-black">Data Peserta</h4>
							</div>
							<div class="card-body timeline pb-2">
								<div class="timeline-panel align-items-end">
									<div class="mr-3">
										<img class="rounded-circle" alt="image" width="50" src="images/avatar/1.png">
									</div>
									<div class="media-body">
										<h5 class="mb-3" style="color: #000;">Olivia Johnson</h5>
									</div>
									<p class="mb-0 fs-14">Peserta</p>
								</div>
								<div class="timeline-panel align-items-end">
									<div class="mr-3">
										<img class="rounded-circle" alt="image" width="50" src="images/avatar/1.png">
									</div>
									<div class="media-body">
										<h5 class="mb-3" style="color: #000;">Griezerman</h5>
									</div>
									<p class="mb-0 fs-14">Peserta</p>
								</div>
								<div class="timeline-panel align-items-end">
									<div class="mr-3">
										<img class="rounded-circle" alt="image" width="50" src="images/avatar/1.png">
									</div>
									<div class="media-body">
										<h5 class="mb-3" style="color: #000;">Uli Trumb</h5>
									</div>
									<p class="mb-0  fs-14">Peserta</p>
								</div>
								<div class="timeline-panel align-items-end">
									<div class="mr-3">
										<img class="rounded-circle" alt="image" width="50" src="images/avatar/1.png">
									</div>
									<div class="media-body">
										<h5 class="mb-3" style="color: #000;">Oconner</h5>
									</div>
									<p class="mb-0 fs-14">Peserta</p>
								</div>
							</div>
							<div class="card-footer border-0 pt-0 text-center">
								<a href="peserta.php" class="btn-link">Lihat Selengkapnya <i class="fa fa-angle-down ml-2 scale-2"></i></a>
							</div>
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
	<script src="vendor/chart.js/Chart.bundle.min.js"></script>
	<script src="vendor/bootstrap-datetimepicker/js/moment.js"></script>
	<script src="vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script src="js/custom.min.js"></script>
	<script src="js/deznav-init.js"></script>
	<!-- Apex Chart -->
	<script src="vendor/apexchart/apexchart.js"></script>
	
	<!-- Chart piety plugin files -->
    <script src="vendor/peity/jquery.peity.min.js"></script>	
	
	<!-- Dashboard 1 -->
	<script src="js/dashboard/dashboard-1.js"></script>
	
</body>
</html>