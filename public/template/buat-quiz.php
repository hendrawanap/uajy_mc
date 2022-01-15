<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Management Competition - Buat Quiz</title>
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
                                <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#222fb9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <h4 class="text-primary ml-2 mt-2">Buat Quiz</h4>
                            </div>
                            <!-- Repeat Soal -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="profile-tab">
                                        <div class="custom-tab-1">
                                            <div id="profile-settings">
                                                <div class="pt-0">                    
                                                    <!-- Nomor Soal -->
                                                    <label class="oval mb-3">1</label>
                                                    <!-- Btn Hapus Soal -->
                                                    <a class="menu-delete-soal ml-4 sweet-confirm" style="cursor: pointer;">
                                                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M3.50195 5.99994H5.5156H21.6248" stroke="#A0A0A0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M8.5361 5.99994V3.99994C8.5361 3.46951 8.74826 2.9608 9.12589 2.58573C9.50352 2.21065 10.0157 1.99994 10.5498 1.99994H14.5771C15.1111 1.99994 15.6233 2.21065 16.0009 2.58573C16.3786 2.9608 16.5907 3.46951 16.5907 3.99994V5.99994M19.6112 5.99994V19.9999C19.6112 20.5304 19.399 21.0391 19.0214 21.4142C18.6438 21.7892 18.1316 21.9999 17.5975 21.9999H7.52928C6.99522 21.9999 6.48304 21.7892 6.10541 21.4142C5.72778 21.0391 5.51563 20.5304 5.51562 19.9999V5.99994H19.6112Z" stroke="#A0A0A0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </a>
                                                    <div class="settings-form">
                                                        <div class="form-group">
                                                            <label style="display: block;">Gambar :</label>
                                                            <img src="images/profile/8.jpg" alt="" class="img-fluid mb-4" style="height: auto; width: 100%; border-radius: 15px;">
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input">
                                                                    <label class="custom-file-label">People Laughing.jpg</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Pertayaan :</label>
                                                            <textarea placeholder="Masukan Pertanyaan..." class="form-control pt-3" style="min-height: 150px;"></textarea>
                                                        </div>
                                                        <div class="input-group mt-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio">
                                                                </div>
                                                            </div>
                                                            <input type="text" name="jawaban" value="a" placeholder="Jawaban 1..." class="form-control">
                                                        </div>
                                                        <div class="input-group mt-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio">
                                                                </div>
                                                            </div>
                                                            <input type="text" name="jawaban" value="b" placeholder="Jawaban 2..." class="form-control">
                                                        </div>
                                                        <div class="input-group mt-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio">
                                                                </div>
                                                            </div>
                                                            <input type="text" name="jawaban" value="c" placeholder="Jawaban 3..." class="form-control">
                                                        </div>
                                                        <div class="input-group mt-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio">
                                                                </div>
                                                            </div>
                                                            <input type="text" name="jawaban" value="d" placeholder="Jawaban 4..." class="form-control">
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
                                                    <!-- Nomor Soal -->
                                                    <label class="oval mb-3">2</label>
                                                    <!-- Btn Hapus Soal -->
                                                    <a class="menu-delete-soal ml-4 sweet-confirm" style="cursor: pointer;">
                                                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M3.50195 5.99994H5.5156H21.6248" stroke="#A0A0A0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M8.5361 5.99994V3.99994C8.5361 3.46951 8.74826 2.9608 9.12589 2.58573C9.50352 2.21065 10.0157 1.99994 10.5498 1.99994H14.5771C15.1111 1.99994 15.6233 2.21065 16.0009 2.58573C16.3786 2.9608 16.5907 3.46951 16.5907 3.99994V5.99994M19.6112 5.99994V19.9999C19.6112 20.5304 19.399 21.0391 19.0214 21.4142C18.6438 21.7892 18.1316 21.9999 17.5975 21.9999H7.52928C6.99522 21.9999 6.48304 21.7892 6.10541 21.4142C5.72778 21.0391 5.51563 20.5304 5.51562 19.9999V5.99994H19.6112Z" stroke="#A0A0A0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </a>
                                                    <div class="settings-form">
                                                        <div class="form-group">
                                                            <label>Gambar :</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input">
                                                                    <label class="custom-file-label">Pilih file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Pertayaan :</label>
                                                            <textarea placeholder="Masukan Pertanyaan..." class="form-control pt-3" style="min-height: 150px;"></textarea>
                                                        </div>
                                                        <div class="input-group mt-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio">
                                                                </div>
                                                            </div>
                                                            <input type="text" name="jawaban" value="a" placeholder="Jawaban 1..." class="form-control">
                                                        </div>
                                                        <div class="input-group mt-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio">
                                                                </div>
                                                            </div>
                                                            <input type="text" name="jawaban" value="b" placeholder="Jawaban 2..." class="form-control">
                                                        </div>
                                                        <div class="input-group mt-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio">
                                                                </div>
                                                            </div>
                                                            <input type="text" name="jawaban" value="c" placeholder="Jawaban 3..." class="form-control">
                                                        </div>
                                                        <div class="input-group mt-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio">
                                                                </div>
                                                            </div>
                                                            <input type="text" name="jawaban" value="d" placeholder="Jawaban 4..." class="form-control">
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
                                                    <!-- Nomor Soal -->
                                                    <label class="oval mb-3">3</label>
                                                    <!-- Btn Hapus Soal -->
                                                    <a class="menu-delete-soal ml-4 sweet-confirm" style="cursor: pointer;">
                                                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M3.50195 5.99994H5.5156H21.6248" stroke="#A0A0A0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M8.5361 5.99994V3.99994C8.5361 3.46951 8.74826 2.9608 9.12589 2.58573C9.50352 2.21065 10.0157 1.99994 10.5498 1.99994H14.5771C15.1111 1.99994 15.6233 2.21065 16.0009 2.58573C16.3786 2.9608 16.5907 3.46951 16.5907 3.99994V5.99994M19.6112 5.99994V19.9999C19.6112 20.5304 19.399 21.0391 19.0214 21.4142C18.6438 21.7892 18.1316 21.9999 17.5975 21.9999H7.52928C6.99522 21.9999 6.48304 21.7892 6.10541 21.4142C5.72778 21.0391 5.51563 20.5304 5.51562 19.9999V5.99994H19.6112Z" stroke="#A0A0A0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </a>
                                                    <div class="settings-form">
                                                        <div class="form-group">
                                                            <label>Gambar :</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input">
                                                                    <label class="custom-file-label">Pilih file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Pertayaan :</label>
                                                            <textarea placeholder="Masukan Pertanyaan..." class="form-control pt-3" style="min-height: 150px;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Tambah Pilihan Ganda</button>
                            <button class="btn btn-primary" type="submit">Tambah Essai</button>
                            <button class="btn btn-success" type="submit">Simpan Quiz</button>
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

		$('.metismenu li:nth-child(3)').addClass('mm-active');
	</script>	

</body>
</html>