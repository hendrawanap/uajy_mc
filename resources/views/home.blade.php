@extends('layouts.app')

@section('content')
@if(Auth::user()->isAdmin == 1)
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="welcome-card rounded pl-5 pt-5 pb-4 mt-3 position-relative mb-5">
                <h4 class="text-warning">Halo Admin,</h4>
                <p>Selamat datang di website {{ env('APP_NAME') }}.</p>
                <a class="btn btn-warning btn-rounded" href="{{route('kuis.index')}}">Buat kuis <i
                        class="las la-long-arrow-alt-right ml-2"></i></a>
                <img src="/template/images/svg/welcom-card.svg" alt="" class="position-absolute">
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card widget-media">
                <div class="card-header border-0 pb-0 ">
                    <h4 class="text-black">Data Peserta</h4>
                </div>
                <div class="card-body timeline pb-2">
                    @forelse(\App\User::where('isAdmin',0)->limit(5)->get() as $value)
                    <div class="timeline-panel align-items-end">
                        <div class="mr-3">
                            <img class="rounded-circle" alt="image" width="50" src="/template/images/avatar/1.png">
                        </div>
                        <div class="media-body">
                            <h5 class="mb-3" style="color: #000;">{{$value->name}}</h5>
                        </div>
                        <p class="mb-0 fs-14">Peserta</p>
                    </div>
                    @empty 
                    <div class="timeline-panel align-items-end">
                        <p class="mb-0 fs-14">tidak ada perserta</p>
                    </div>
                    @endforelse

                </div>
                @if(\App\User::where('isAdmin',0)->count() > 5)
                <div class="card-footer border-0 pt-0 text-center">
                    <a href="{{route('user.index')}}" class="btn-link">Lihat Selengkapnya <i
                            class="fa fa-angle-down ml-2 scale-2"></i></a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@else 
<div class="container-fluid">
				<div class="row">
					<div class="col-xl-12">
						<div class="welcome-card rounded pl-5 pt-5 pb-4 mt-3 position-relative mb-5">
							<h4 class="text-warning">Halo {{Auth::user()->name}},</h4>
							<p>Selamat datang di website {{ env('APP_NAME' )}}, ini merupakan website tentang Kuis dan Case.</p>
							<a class="btn btn-warning btn-rounded" href="{{route('kuis.jawab.list')}}">Lihat Kuis <i class="las la-long-arrow-alt-right ml-2"></i></a>
							<img src="/template/images/svg/welcom-card.svg" alt="" class="position-absolute">
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
                                                <!-- <i class="fa fa-clock-o"></i> Anda memiliki {{\App\KuisSubmit::where('user_id',Auth::user()->id)->where('status',0)->count() }} kuis yang harus dikerjakan -->
                                                <i class="fa fa-clock-o"></i> Anda memiliki Kuis yang harus dikerjakan
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{route('kuis.jawab.list')}}"><span class="badge badge-success">Lihat Kuis</span></a>
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
                                            <h4 class="mt-1" style="color: #000;">Periksa Case</h4>
                                            <p class="mb-0">
                                                <!-- <i class="fa fa-clock-o"></i> Anda memiliki {{\App\Event::where('tanggal_selesai','<',date('Y-m-d H:i:s'))->count()}} case yang harus dikumpulkan -->
                                                <i class="fa fa-clock-o"></i> Anda memiliki Case yang harus dikumpulkan
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{route('cases.index')}}"><span class="badge badge-success">Lihat Case</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
            </div>
@endif
@endsection