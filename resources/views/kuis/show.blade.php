@extends('layouts.app')
@section('content')
<!--**********************************
            Content body start
        ***********************************-->
<!-- Btn Soal -->
<a class="schedule-event-inner d-flex justify-content-center align-items-center btn-soal"><i class="fa fa-eye fs-24"
        style="color: #fff;"></i></a>

<!--**********************************
            EventList
        ***********************************-->

<div class="event-sidebar dz-scroll" id="eventSidebar">
    <div class="card shadow-none rounded-0 bg-transparent h-auto mb-0">
        <div class="card-body text-center event-calender pb-2">
            <!-- Waktu Quiz -->
            <p style="text-align: left; margin-bottom: 0;">Waktu : </p>
            <h3 style="text-align: left;" id="time-kuis"></h3>
            <!-- Nomor Soal -->
            <p style="text-align: left; margin-bottom: 0; margin-top: 25px;">Nomor Soal : </p>
            <div class="nomor-soal"></div>
        </div>
    </div>
</div>


    <div class="container-fluid">
        <div class="row">
            <!-- Form -->
            <form action="{{route('kuis.jawab.action',$setkuis->id)}}" id="form-submit" method="POST" class="col-xl-12" enctype="multipart/form-data">
            @csrf
                <div class="col-xl-12">
                    <!-- Title -->
                    <div class="d-flex justify-content-start align-items-center mb-4">
                        <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                            viewBox="0 0 24 24" fill="none" stroke="#222fb9" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-file-text">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <h4 class="text-primary ml-2 mt-2">Take Kuis</h4>
                    </div>
                    <!-- Repeat Soal -->
                    @forelse(\App\AksesKuis::where('set_kuis_id',$setkuis->id)->where('user_id',Auth::user()->id)->get() as $key => $value)
                    <section id="{{$value->soal->no}}">
                    @if($value->type == 1)
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <div id="profile-settings">
                                            <div class="pt-0">
                                            @if($value->soal->getfotoKuis() == TRUE)
                                            <img src="{{$value->soal->getfotoKuis()}}" alt="" class="img-fluid mb-4"
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
                                                            <input type="hidden" name="isian[{{$value->id}}]" value="0">
                                                            <input type="checkbox" style="margin-top:15px" onchange="ahayyy('{{route('kuis.jawab.ajax',['type' => 'ragu','id' => $value->id])}}')" @if($value->isRagu == 1) checked @endif> Ragu Ragu ?
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
                                            @if($value->soal->getfotoKuis() == TRUE)
                                            <img src="{{$value->soal->getfotoKuis()}}" alt="" class="img-fluid mb-4"
                                                    style="height: auto; width: 100%; border-radius: 15px;">
                                            @endif
                                             <div class="d-flex align-items-start justify-content-start">
                                                    <div>
                                                        <label class="oval">{{$value->soal->no}}</label>
                                                    </div>
                                                    <div class="w-cont">
                                                        {!! $value->soal->name !!}
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                            <input type="hidden" name="isian[{{$value->id}}]" value="1">
                                                                <input type="file" name="jawaban[{{$value->id}}]" onchange="ahayyy('{{route('kuis.jawab.ajax',['type' => 'jawab','jawaban' =>'1','id' => $value->id])}}');" class="custom-file-input" required>
                                                                <label class="custom-file-label">Pilih file</label>
                                                            </div>
                                                        </div>
                                                        <input type="checkbox" style="margin-top:15px" onchange="ahayyy('{{route('kuis.jawab.ajax',['type' => 'ragu','id' => $value->id])}}')" @if($value->isRagu == 1) checked @endif> Ragu Ragu ?
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
                    </section>
              
                    <button class="btn btn-success" type="submit">Kuis Selesai</button>
                </div>
            </form>
        </div>
    </div>
    @endsection
    @section('js')
    <script>
    $(document).ready(function() {
        load_no();
    });
    function load_no() {
        $(".nomor-soal").load("{{route('kuis.jawab.ajax',['type' => 'no-soal','setkuis' => $setkuis->id])}}");
    }

    function simpan_file(file,id) {
        $.ajax({
            url:'{{route('kuis.jawab.ajax',['type' => 'upload'])}}',
            data:'file='+file+'&_token={{ csrf_token() }}'+'&id='+id,
            type:'POST',
            contentType: 'multipart/form-data',
            success:function(data){
                console.log(data);
                load_no();
            }
        });
    }

    function ahayyy(url) {
        $.ajax({
            url:url,
            success:function(){
                load_no();
            }
        });
    }
    @php 
    $waktu_kuis_fix = \Carbon\Carbon::parse($setkuis->tanggal_mulai)->addMinutes($setkuis->durasi);
    @endphp
    function makeTimer() {
		    var endTime = new Date("{{\Carbon\Carbon::parse($setkuis->tanggal_mulai)->addMinutes($setkuis->durasi)->format('M d, Y H:i:s')}} UTC+07:00");			
// 			alert(new Date('August 19, 1975 23:15:30 GMT+07:00'));
			endTime = (Date.parse(endTime) / 1000);
			var now = new Date();
// 			alert(now);
			now = (Date.parse(now) / 1000);
			var timeLeft = endTime - now;
			var days = Math.floor(timeLeft / 86400); 
			var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
			var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
			var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
			if(hours == 0 && minutes == 5) {
			 $('.peringatan-notif').fadeIn();
			    return false;
			}
            if( hours == 0 && minutes == 0 && seconds == 0){
                $("#form-submit").submit();
                return false;
            }
			if (hours < "10") { hours = "0" + hours; }
			if (minutes < "10") { minutes = "0" + minutes; }
			if (seconds < "10") { seconds = "0" + seconds; }

			$("#time-kuis").html("<span><b>"+hours+"</b>:<b>"+minutes+"</b>:<b>"+seconds+"</b></span>");

	}

// 	setInterval(function() { makeTimer(); }, 1000);
	setInterval(makeTimer, 1000);
    </script>
    <h3 style="text-align: left;"></h3>
    @endsection