@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row mb-5 align-items-center">
        <div class="col-lg-3 mb-4 mb-lg-0">
            <a href="{{route('kuis.create')}}" class="btn btn-primary light btn-lg btn-block rounded shadow px-2">+ Buat Kuis</a>
        </div>
        <div class="total-peserta col-lg-9 d-flex justify-content-end">
            <div class="d-flex justify-content-start align-items-end">
                <span class="mr-2 mb-1">
                    <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                        fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-file-text">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </span>
                <div>
                    <p class="mb-1 fs-14">Total Kuis</p>
                    <h3 class="mb-0 text-black font-w600 fs-20">{{\App\Kuis::count()}} Kuis</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    @forelse(\App\Kuis::all() as $value)
        <div class="col-lg-12">
            <div class="widget-stat card">
                <div class="card-body p-4">
                    <div class="media ai-icon">
                        <!-- Kuis Aktif -->
                        
                        @if($value->set_kuis()->count() > 0)
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
                                viewBox="0 0 24 24" fill="none" stroke="#ff2625" stroke-width="2" stroke-linecap="round"
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
                                <h4 class="mt-1">{{$value->name}}</h4>
                                <p class="mb-0">{{$value->soal()->count()}} Soal</p>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('kuis.soal',$value->id)}}"><span class="badge badge-primary">Soal</span></a>
                                <a href="{{route('kuis.edit',$value->id)}}"><span class="badge badge-warning">Edit Kuis</span></a>
                                <a href="{{route('kuis.delete',$value->id)}}" onclick="return confirm('Apakah anda yakin hapus data Kuis ini ?')"><span class="badge badge-danger">Hapus Kuis</span></a>
                                <a href="{{route('jadwal.index',$value->id)}}"><span class="badge badge-danger">Set Kuis</span></a>
                                <a href="{{route('kuis.akses_set_kuis',$value->id)}}"><span class="badge badge-success">( {{$value->set_kuis()->count()}} ) Lihat Submit</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty 
    @endforelse
    </div>
    </div>

    @endsection