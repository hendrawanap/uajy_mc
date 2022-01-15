<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Management Competition - Set Uploader</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
	<link href="vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
	<link href="vendor/lightgallery/css/lightgallery.min.css" rel="stylesheet">
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
            <div class="container-fluid">
                <div class="row">
                    <!-- Form -->
                    <form action="" class="col-xl-12">
                        <div class="col-xl-12"> 
                            <!-- Title -->
                            <div class="d-flex justify-content-start align-items-center mb-4">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="scale5 mr-0 mb-0 mr-sm-2 mb-sm-1"><path d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z" stroke="#222fb9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M16 2V6" stroke="#222fb9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8 2V6" stroke="#222fb9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M3 10H21" stroke="#222fb9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                <h4 class="text-primary ml-2 mt-2">Set Uploader</h4>
                            </div>
                            <!-- Repeat Soal -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="profile-tab">
                                        <div class="custom-tab-1">
                                            <div id="profile-settings">
                                                <div class="pt-0">
                                                    <!-- Judul Uploader -->
                                                    <label style="font-size: 20px; color: #000; margin-bottom: 25px;">Semifinal</label>
                                                    <div class="settings-form">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label>Tanggal : </label>
                                                                <input type="text" id="date-format" class="form-control" placeholder="Saturday 24 June 2017 - 21:44">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Durasi (Menit) :</label>
                                                                <input type="number" placeholder="Masukan Durasi Menit..." min="0" class="form-control form-control-md">
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-success" type="submit">Set Uploader</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

		$('.metismenu li:nth-child(4)').addClass('mm-active');
	</script>	

</body>
</html>