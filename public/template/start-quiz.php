<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Management Competition - Quiz</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
	<link href="vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
	<link href="vendor/lightgallery/css/lightgallery.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link href="vendor/dropzone/dist/dropzone.css" rel="stylesheet">
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
        <!-- Btn Soal -->
        <a class="schedule-event-inner d-flex justify-content-center align-items-center btn-soal"><i class="fa fa-eye fs-24" style="color: #fff;"></i></a>

        <!--**********************************
            EventList
        ***********************************-->
		
		<div class="event-sidebar dz-scroll" id="eventSidebar">
			<div class="card shadow-none rounded-0 bg-transparent h-auto mb-0">
				<div class="card-body text-center event-calender pb-2">
                    <!-- Waktu Quiz -->
                    <p style="text-align: left; margin-bottom: 0;">Waktu : </p>
                    <h3 style="text-align: left;">01:00:10</h3>
                    <!-- Nomor Soal -->
                    <p style="text-align: left; margin-bottom: 0; margin-top: 25px;">Nomor Soal : </p>
                    <div class="nomor-soal">
                        <a class="ns ns-sudah">1</a>
                        <a class="ns ns-ragu">2</a>
                        <a class="ns">3</a>
                        <a class="ns">4</a>
                        <a class="ns">5</a>
                        <a class="ns">6</a>
                        <a class="ns">7</a>
                    </div>
				</div>
			</div>
		</div>


        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <!-- Form -->
                    <form action="" class="col-xl-12">
                        <div class="col-xl-12"> 
                            <!-- Title -->
                            <div class="d-flex justify-content-start align-items-center mb-4">
                                <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#222fb9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <h4 class="text-primary ml-2 mt-2">Take Quiz</h4>
                            </div>
                            <!-- Repeat Soal -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="profile-tab">
                                        <div class="custom-tab-1">
                                            <div id="profile-settings">
                                                <div class="pt-0">
                                                    <img src="images/profile/8.jpg" alt="" class="img-fluid mb-4" style="height: auto; width: 100%; border-radius: 15px;">
                                                    <div class="d-flex align-items-start justify-content-start">
                                                        <div>
                                                            <label class="oval">1</label>
                                                        </div>
                                                        <div class="w-cont">
                                                            <h3 class="judul">Siapa juara progression 2020?</h3>
                                                            <div class="settings-form">
                                                                <div class="radio d-flex align-items-center wans">
                                                                    <label class="form-control d-flex align-items-center" style="cursor: pointer;">
                                                                    <input type="radio" name="optradio" class="mr-3 ml-2 ans">
                                                                    TIM GA ADA OBAT
                                                                    </label>
                                                                </div>
                                                                <div class="radio d-flex align-items-center wans">
                                                                    <label class="form-control d-flex align-items-center" style="cursor: pointer;">
                                                                    <input type="radio" name="optradio" class="mr-3 ml-2 ans">
                                                                    Saya tidak tahu
                                                                    </label>
                                                                </div>
                                                                <div class="radio d-flex align-items-center wans">
                                                                    <label class="form-control d-flex align-items-center" style="cursor: pointer;">
                                                                    <input type="radio" name="optradio" class="mr-3 ml-2 ans">
                                                                    TIM GA ADA OBAT
                                                                    </label>
                                                                </div>
                                                                <div class="radio d-flex align-items-center wans">
                                                                    <label class="form-control d-flex align-items-center" style="cursor: pointer;">
                                                                    <input type="radio" name="optradio" class="mr-3 ml-2 ans">
                                                                    TIM GA ADA OBAT
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Repeat Soal -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="profile-tab">
                                        <div class="custom-tab-1">
                                            <div id="profile-settings">
                                                <div class="pt-0">
                                                    <div class="d-flex align-items-start justify-content-start">
                                                        <div>
                                                            <label class="oval">2</label>
                                                        </div>
                                                        <div class="w-cont">
                                                            <h3 class="judul">Ini ceritanya pertanyaan Essai kak, kalau pertanyaan essai itu jawabnya PAKAI UPLOADER kak bukan ketikan hehe dari client</h3>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input">
                                                                    <label class="custom-file-label">Pilih file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success" type="submit">Finish Quiz</button>
                        </div>
                    </form>
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
	
	<!--removeIf(production)-->
        
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
    <!-- Apex Chart -->

    <script src="vendor/dropzone/dist/dropzone.js"></script>
    <script src="vendor/sweetalert2/dist/sweetalert2.min.js"></script>

    <script>
		$(".sweet-confirm").on('click', function(){
			swal({
				title: "Yakin ingin menghapus Soal 1 ?",
				text: "Jika yakin anda dapat menekan tombol hapus dibawah",
				type: "warning",
				showCancelButton: !0,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Hapus",
				closeOnConfirm: !1,
			}, function () {
				swal("Soal Dihapus", "Berhasil menghapus soal", "success")
			})
        });
	</script>
    

    <script src="vendor/lightgallery/js/lightgallery-all.min.js"></script>
	<script>
		$('#lightgallery').lightGallery({
			thumbnail:true,
        });
        
        $('.btn-soal').click(function(){
            $(this).find('i').toggleClass('fa-eye fa-eye-slash')
        });

		$('.metismenu li:nth-child(5)').addClass('mm-active');
	</script>	

</body>
</html>