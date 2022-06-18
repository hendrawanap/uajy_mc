<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{config('app.name')}}</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{config('app.icon_url')}}">
    <link href="/template/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="/template/css/style.css" rel="stylesheet">
    <link href="/template//vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link href="/template/vendor/summernote/summernote.css" rel="stylesheet">
    @yield('link')
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color:#fff !important
        }
        .dataTables_wrapper .dataTables_paginate {
            padding:0 !important
        }

        .glassy-container {
            background-color: rgba(0, 0, 0, .25) !important;
            backdrop-filter: blur(5px) !important;
        }
    </style>
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

        <!--**********************************
	Nav header start
***********************************-->
        <div class="nav-header">
            <a href="/" class="brand-logo d-flex align-content-center justify-content-center">
                <img src="{{ config('app.icon_url') }}" width="75" />
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
	Nav header end
***********************************-->

        <!--**********************************
	Header start
***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                            @if(Request::segment(1) == "event")
                                Case
                            @elseif(Request::segment(1) == "user")
                                Peserta
                            @else
                                {{ucwords(Request::segment(1) ?? 'Dashboard')}}
                            @endif
                            </div>
                        </div>
                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <img src="/template/images/avatar/1.png" width="20" alt="" class="mr-3" />
                                    <b style="font-weight: 600; color: #000;">{{Auth::user()->name}}
                                        <i class="fa fa-caret-down scale3 ml-2 d-none d-sm-inline-block"
                                            style="font-size: 12px;"></i>
                                    </b>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{route('logout')}}" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                            width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        <span class="ml-2">Logout</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
	Header end ti-comment-alt
***********************************-->

        <!--**********************************
	Sidebar start
***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">
                    <li><a href="{{url('/')}}" aria-expanded="false">
                            <i class="flaticon-381-networking"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    @if(Auth::user()->isAdmin == 1)
                    <li><a href="{{route('user.index')}}" aria-expanded="false">
                            <i class="flaticon-381-television"></i>
                            <span class="nav-text">Peserta</span>
                        </a>
                    </li>
                    <li><a href="{{route('admin.quizzes.index')}}" aria-expanded="false">
                            <i class="flaticon-381-controls-3"></i>
                            <span class="nav-text">Kuis</span>
                        </a>
                    </li>
                    <li><a href="{{route('admin.cases.index')}}" aria-expanded="false">
                            <i class="fa fa-bookmark"></i>
                            <span class="nav-text">Case</span>
                        </a>
                    </li>
                    @else
                    <li><a href="{{route('quizzes.submissions_index')}}" aria-expanded="false">
                            <i class="flaticon-381-internet"></i>
                            <span class="nav-text">Hasil Kuis</span>
                        </a>
                    </li>
                    <li><a href="{{route('quizzes.index')}}" aria-expanded="false">
                            <i class="flaticon-381-heart"></i>
                            <span class="nav-text">Kuis</span>
                        </a>
                    </li>
                    <li><a href="{{route('cases.index')}}" aria-expanded="false">
                            <i class="flaticon-381-settings-2"></i>
                            <span class="nav-text">Case</span>
                        </a>
                    </li>
                    @endif
                </ul>
                <div class="copyright">
                    <p>{{ config('app.name') }} Dashboard © All Rights Reserved</p>
                    <p class="op5">Made with <i class="fa fa-heart"></i> by HMPSM UAJY</p>
                </div>
            </div>
        </div>
        <!--**********************************
	Sidebar end
***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body rightside-event">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if (session('success'))

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('success') }}
                        </div>
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            Isian form tidak valid:
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if (session('error'))

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('error') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- row -->
            @yield('content')
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer mt-5 text-center">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a>{{config('app.name')}}</a></p>
            </div>
        </div>

        <!--**********************************
            Footer end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->

    <div class="overflow-auto d-none modal-transition" id="modal-overlay" style="top: 0; bottom: 0; left: 0; right: 0; position: fixed; z-index: 999;">
        <div class="my-5 container" id="modal-content" style="background-color: transparent; position: relative; z-index: 1000">
            @yield('modal-content')
        </div>
    </div>

    <style>
        .modal-transition.d-none {
            background-color: rgba(0,0,0,0);
        }

        .modal-transition {
            background-color: rgba(0,0,0,0.8);
            transition: all;
        }
    </style>

    <script src="/template/vendor/global/global.min.js"></script>
    <script src="/template/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="/template/vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="/template/vendor/bootstrap-datetimepicker/js/moment.js"></script>
    <script src="/template/js/custom.min.js"></script>
    <script src="/template/js/deznav-init.js"></script>
    <script src="/template/vendor/datatables/js/jquery.dataTables.min.js"></script>


    <!-- Chart piety plugin files -->
    <script src="/template/vendor/peity/jquery.peity.min.js"></script>
    <script src="/ckeditor/ckeditor.js"></script>
    <script src="/ckeditor/adapters/jquery.js"></script>
    <script>
    $(document).ready(function(){
       
       $('textarea').ckeditor();
    
    });

    let modalIsOpen = false;
    const modal = document.getElementById('modal-overlay');
    const modalContainer = document.getElementById('modal-content');
    // console.log(modalContainer.offsetWidth);

    function toggleModal() {
        if (modalIsOpen) {
            document.body.classList.remove('overflow-hidden');
            modal.classList.add('d-none');
        } else {
            document.body.classList.add('overflow-hidden');
            modal.classList.remove('d-none');
        }
        modalIsOpen = !modalIsOpen;
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            toggleModal()
        }
    } 
    </script>
    @yield('js')
</body>

</html>