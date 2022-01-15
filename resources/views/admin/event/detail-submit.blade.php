@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Form -->
            <div class="col-xl-12">
                <!-- Title -->
                <div class="d-flex justify-content-start align-items-center mb-4">
                    <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                        fill="none" stroke="#222fb9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-file-text">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <h4 class="text-primary ml-2 mt-2">Periksa Case</h4>
                </div>
                <!-- Data Peserta Quiz -->
                <div class="table-responsive">
                    <table class="table display mb-4 table-responsive-xl dataTablesCard fs-14">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Username</th>
                                <th>Waktu Submit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img class="rounded-circle" alt="image" width="50" src="/template/images/avatar/1.png"></td>
                                <td>{{$event->user->name}}</td>
                                <td>{{$event->created_at->format('Y-m-d H:i:s')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Repeat Soal -->
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <div id="profile-settings">
                                    <div class="pt-0">
                                        <div class="w-cont">
                                            <h3 class="judul">{!! $event->event->soal !!}</h3>
                                            <div class="file-peserta">
                                                <a href="{{$event->getFile()}}" download>
                                                    <i class="fa fa-paperclip"></i>
                                                    File Peserta.zip
                                                </a>
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
</div>
@endsection