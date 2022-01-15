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
							<h4 class="text-warning">Halo Peserta,</h4>
							<p>Selamat datang di website Management Competition, ini merupakan website tentang multiple choice dan essay.</p>
							<a class="btn btn-warning btn-rounded" href="take-quiz.php">Lihat Quiz <i class="las la-long-arrow-alt-right ml-2"></i></a>
							<!-- <a class="btn-link text-dark ml-3" href="javascript:void(0);">Remind Me Later</a> -->
							<img src="images/svg/welcom-card.svg" alt="" class="position-absolute">
						</div>
                    </div>
                    <!-- Repeat -->
					<div class="col-xl-12">
                        <div class="widget-stat card">
                            <div class="card-body p-4">
                                <div class="media ai-icon statss">
                                    <span class="mr-3 bgl-danger text-danger">
                                        <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#ff2625" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                    </span>
                                    <div class="media-body d-flex align-items-end justify-content-between">
                                        <div>
                                            <h4 class="mt-1" style="color: #000;">Periksa Kuis</h4>
                                            <p class="mb-0">
                                                <i class="fa fa-clock-o"></i>
                                                Anda memiliki quiz yang harus dikerjakan
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <a href="take-quiz.php"><span class="badge badge-success">Lihat Quiz</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Repeat -->
					<div class="col-xl-12">
                        <div class="widget-stat card">
                            <div class="card-body p-4">
                                <div class="media ai-icon statss">
                                    <span class="mr-3 bgl-danger text-danger">
                                        <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#ff2625" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                    </span>
                                    <div class="media-body d-flex align-items-end justify-content-between">
                                        <div>
                                            <h4 class="mt-1" style="color: #000;">Periksa Hasil Kerja</h4>
                                            <p class="mb-0">
                                                <i class="fa fa-clock-o"></i>
                                                Anda memiliki hasil kerja yang harus dikumpulkan
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <a href="take-quiz.php"><span class="badge badge-success">Lihat Uploader</span></a>
                                        </div>
                                    </div>
                                </div>
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