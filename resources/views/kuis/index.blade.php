@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="col-xl-12">
                <!-- Title -->
                <div class="d-flex justify-content-start align-items-center mb-4">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="scale5 mr-0 mb-0 mr-sm-2 mb-sm-1">
                        <path
                            d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z"
                            stroke="#222fb9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M16 2V6" stroke="#222fb9" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                        </path>
                        <path d="M8 2V6" stroke="#222fb9" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                        </path>
                        <path d="M3 10H21" stroke="#222fb9" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                        </path>
                    </svg>
                    <h4 class="text-primary ml-2 mt-2">Take Kuis</h4>
                </div>
                <!-- Repeat -->
                @forelse(\App\SetKuis::whereDate('tanggal_mulai','>=',date('Y-m-d'))->get() as $value) 
                <div class="widget-stat card">
                    <div class="card-body p-4">
                        <div class="media ai-icon statss">
                            @if($value->tanggal_mulai > date('Y-m-d'))
                                @if(\App\KuisSubmit::where('set_kuis_id',$value->id)->where('user_id',Auth::user()->id)->where('status',1)->count() > 0)
                                    <span class="mr-3 bgl-success text-success">
                                        <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            viewBox="0 0 24 24" fill="none" stroke="#21b731" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-file-text">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                    </span>
                                @else
                                    <span class="mr-3 bgl-danger text-danger">
                                        <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            viewBox="0 0 24 24" fill="none" stroke="#ff2625" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                    </span>
                                @endif
                            @else 

                            <span class="mr-3 bgl-success text-success">
                            <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                viewBox="0 0 24 24" fill="none" stroke="#21b731" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-file-text">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            </span>
                        @endif

                            <div class="media-body d-flex align-items-end justify-content-between">
                                <div>
                                    <h4 class="mt-1" style="color: #000;">{{$value->kuis->name}}</h4>
                                    <p class="mb-0">
                                        <i class="fa fa-clock-o"></i>
                                        {{$value->durasi}} Menit
                                    </p>
                                </div>
                                <div class="d-flex justify-content-end">
                                    @if((date('Y-m-d H:i:s') >= $value->tanggal_mulai))
                                        @if(\App\KuisSubmit::where('set_kuis_id',$value->id)->where('user_id',Auth::user()->id)->where('status',1)->count() > 0)
                                            <span class="badge badge-success">Sudah Dikerjakan</span>
                                        @else

                                            @if(\Carbon\Carbon::parse($value->tanggal_mulai)->addMinutes($value->durasi)->format('Y-m-d H:i:s') >= date('Y-m-d H:i:s'))
                                            <a href="{{route('kuis.jawab.show',$value->id)}}"><span class="badge badge-success">Kerjakan
                                                Sekarang</span></a>
                                            @else
                                            <span class="badge badge-danger">Ujian Telah Berakhir</span>
                                            @endif
                                        @endif
                                    @else 
                                        <p><b>Dimulai Pada :</b>&nbsp;{{$value->tanggal_mulai}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty 
                Tidak ada jadwal kuis
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection