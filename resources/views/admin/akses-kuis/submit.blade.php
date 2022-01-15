@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Form -->
        <div class="col-xl-12">
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
                    <h4 class="text-primary ml-2 mt-2">Periksa Quiz</h4>
                </div>
                <!-- Data Peserta Quiz -->
                <div class="table-responsive">
                    <table id="example5" class="table display mb-4 table-responsive-xl dataTablesCard fs-14">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Tanggal & Waktu Mulai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img class="rounded-circle mr-2" alt="image" width="50" src="/template/images/avatar/1.png"> {{$kuis_submit->user->name}}</td>
                                <td>{{$kuis_submit->created_at}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card">
                    <div class="card-body">
                    <form action="{{route('kuis.update_nilai_kuis',$kuis_submit->id)}}" method="POST">
                    @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="nilai" value="{{$kuis_submit->nilai}}" placeholder="Masukkan Nilai...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Submit Nilai</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                @forelse(\App\AksesKuis::where('user_id',$kuis_submit->user->id)->where('set_kuis_id',$kuis_submit->set_kuis_id)->get() as $key => $value)
    
                @if($value->type == 1)
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <div id="profile-settings">
                                            <div class="pt-0">
                                                @if($value->soal->foto == TRUE)
                                            <img src="{{$value->soal->getFoto()}}" alt="" class="img-fluid mb-4"
                                                    style="height: auto; width: 100%; border-radius: 15px;">
                                            @endif
                                                <div class="d-flex align-items-start justify-content-start">
                                                    <div>
                                                        <label class="oval">{{$value->soal->no}}</label>
                                                    </div>
                                                    <div class="w-cont">
                                                        <h3 class="judul">{!! $value->soal->name !!}</h3>
                                                        <div class="settings-form">
                                                            <div class="radio d-flex align-items-center wans">
                                                                <label class="form-control d-flex align-items-center"
                                                                    style="cursor: pointer;">
                                                                    <input type="radio" name="jawaban[{{$value->id}}]"
                                                                        class="mr-3 ml-2 ans" value="a" onclick="ahayyy('{{route('kuis.jawab.ajax',['type' => 'jawab','jawaban' =>'a','id' => $value->id])}}');" @if($value->jawaban == "a") checked @endif>
                                                                <b>A .</b>&nbsp;{{$value->soal->a}}
                                                                </label>
                                                            </div>
                                                            <div class="radio d-flex align-items-center wans">
                                                                <label class="form-control d-flex align-items-center"
                                                                    style="cursor: pointer;">
                                                                    <input type="radio"  name="jawaban[{{$value->id}}]"
                                                                        class="mr-3 ml-2 ans" value="b" onclick="ahayyy('{{route('kuis.jawab.ajax',['type' => 'jawab','jawaban' =>'b','id' => $value->id])}}');" @if($value->jawaban == "b") checked @endif>
                                                                    <b>B .</b>&nbsp; {{$value->soal->b}}
                                                                </label>
                                                            </div>
                                                            <div class="radio d-flex align-items-center wans">
                                                                <label class="form-control d-flex align-items-center"
                                                                    style="cursor: pointer;">
                                                                    <input type="radio" name="jawaban[{{$value->id}}]"
                                                                    value="c"class="mr-3 ml-2 ans" onclick="ahayyy('{{route('kuis.jawab.ajax',['type' => 'jawab','jawaban' =>'c','id' => $value->id])}}');" @if($value->jawaban == "c") checked @endif>
                                                                    <b>C .</b>&nbsp; {{$value->soal->c}}
                                                                </label>
                                                            </div>
                                                            <div class="radio d-flex align-items-center wans">
                                                                <label class="form-control d-flex align-items-center"
                                                                    style="cursor: pointer;">
                                                                    <input type="radio" name="jawaban[{{$value->id}}]"
                                                                        class="mr-3 ml-2 ans" value="d" onclick="ahayyy('{{route('kuis.jawab.ajax',['type' => 'jawab','jawaban' =>'d','id' => $value->id])}}')" @if($value->jawaban == "d") checked @endif>
                                                                    <b>D .</b>&nbsp; {{$value->soal->d}}
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
                    @else
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <div id="profile-settings">
                                            <div class="pt-0">
                                            @if($value->soal->foto == TRUE)
                                            <img src="{{$value->soal->getFoto()}}" alt="" class="img-fluid mb-4"
                                                    style="height: auto; width: 100%; border-radius: 15px;">
                                            @endif
                                                <div class="d-flex align-items-start justify-content-start">
                                                    <div>
                                                        <label class="oval">{{$value->soal->no}}</label>
                                                    </div>
                                                    <div class="w-cont">
                                                        <h3 class="judul">{!! $value->soal->name !!}</h3>
                                                        <div class="file-peserta">
                                                                <a href="{{$value->getJawaban()}}" download>
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
                    @endif
                    @empty 
                    @endforelse
            </div>
        </div>
    </div>
</div>
@endsection