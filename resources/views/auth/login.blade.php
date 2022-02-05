<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{config('app.name')}} - Login</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{env('APP_ICON')}}">
    <link href="/template/css/style.css" rel="stylesheet">
    

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-5">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img src="/logo/LOGO UAJY FBE.png" width="75" style="margin: 0px 5px"/>
                                        <img src="/logo/LOGO MC.png" width="95" style="margin: 0px 5px"/>
                                        <img src="/logo/LOGO HMPSM FBE.png" width="60" style="margin: 0px 5px"/>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center" style="margin: 10px 0;">
                                        <img src="/logo/cross.png" width="35" style="margin: 0px 5px"/>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-3">
                                        <img src="/logo/2-Logo G-New Year-Landscape-OK.jpg" width="75" style="margin: 0px 5px"/>
                                        <img src="/logo/LOGO Lokalate Kopi Berondong.png" width="75" style="margin: 0px 5px"/>
                                    </div>
                                    <h4 class="text-center mb-4"><span class="d-block mb-2">- Login -</span><strong>{{config('app.name')}}</strong></h4>
                                    <form method="POST" class="needs-validation">
                                    @csrf
                                        <div class="form-group">
                                            <label class="mb-1" style="color: #3d4465;">Username</label>
                                            <input type="text" name="username" class="form-control form-control-sm  @error('username') is-invalid @enderror" placeholder="Masukan Username..." required>
                                            @error('username') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1" style="color: #3d4465;">Password</label>
                                            <input type="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror "   placeholder="Masukan Password..." required>
                                            @error('password') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <script>
        (function () {
            'use strict';
            window.addEventListener('load', function () {
         
                var forms = document.getElementsByClassName('needs-validation');
               
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('keyup', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
    <!-- Required vendors -->
    <script src="/template/vendor/global/global.min.js"></script>
	<script src="/template/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="/template/js/custom.min.js"></script>
    <script src="/template/js/deznav-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
</body>
</html>