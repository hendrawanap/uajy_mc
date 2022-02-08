@extends('layouts.app')

@php
$attachments = \App\Kuis::find($setkuis->kuis_id)->get()[0]->attachments
@endphp

@section('link')

    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

    <style>

        .event-sidebar {
            right: -110vw;
            width: 320px;
        }

        @media only screen and (min-width: 992px) {
            .event-sidebar {
                right: 0;
            }
        }



    </style>

@endsection

@section('content')

<!--**********************************

            Content body start

        ***********************************-->

<!-- Btn Soal -->

<a class="schedule-event-inner d-flex justify-content-center align-items-center btn-soal d-lg-none"><i class="fa fa-eye fs-24"

        style="color: #fff;"></i></a>



    <!--**********************************

                EventList

            ***********************************-->



    <div class="event-sidebar dz-scroll" id="eventSidebar">

        <div class="card shadow-none rounded-0 bg-transparent h-auto mb-0">

            <div class="card-body text-center event-calender pb-2">

                <!-- Waktu Quiz  -->

                <p style="text-align: left; margin-bottom: 0;">Waktu : </p>

                <h3 style="text-align: left;" id="time-kuis"></h3>

                <!-- Nomor Soal  -->

                <p style="text-align: left; margin-bottom: 0; margin-top: 25px;">Nomor Soal : </p>

                <div class="nomor-soal"></div>

            </div>

        </div>

    </div>





    <div class="mx-5">

        <div class="row">
            
            <!-- Form -->
            
            <div class="col-lg-8">

                <div class="row" id="top-row">
                    <div class="col" id="open-attachment-container">
                        @if (!empty($attachments))
                        <button class="btn btn-outline-primary my-3 d-lg-none" onclick="toggleModal()">Lihat Lampiran</button>
                        @endif
                    </div>
                    <div class="col d-flex flex-column align-items-end" id="timer-container">
                        @if (!empty($attachments))
                        <button class="btn btn-outline-primary my-3 d-none d-lg-block" id="btn-open-attachment" onclick="toggleModal()">Lihat Lampiran</button>
                        @endif
                    </div>
                </div>

                <form action="{{route('kuis.jawab.action',$setkuis->id)}}" id="form-submit" method="POST" enctype="multipart/form-data">
    
                    @csrf
    
                    <div class="">
    
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
    
                        @foreach(\App\AksesKuis::where('set_kuis_id',$setkuis->id)->where('user_id',Auth::user()->id)->get() as $key => $value)
    
                        <section id="{{$loop->iteration}}">
    
                            @if($value->type == 1)
    
                            <div class="card">
    
                                <div class="card-body">
    
                                    <div class="profile-tab">
    
                                        <div class="custom-tab-1">
    
                                            <div id="profile-settings">
    
                                                <div class="pt-0">
    
                                                    @if($value->soal->getfotoKuis() == TRUE)
    
                                                    <img src="{{$value->soal->getfotoKuis()}}" alt="" class="img-fluid mb-4" loading="lazy" style="height: auto; width: 100%; border-radius: 15px;">
    
                                                    @endif
    
                                                    <div class="d-flex align-items-start justify-content-start">
    
                                                        <div>
    
                                                            <label class="oval">{{$loop->iteration}}</label>
    
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
        
                                                                    <input type="hidden" name="isian[{{$value->id}}]" value="0">
        
                                                                    <!-- <input type="checkbox" style="margin-top:15px" onchange="ahayyy('{{route('kuis.jawab.ajax',['type' => 'ragu','id' => $value->id])}}')" @if($value->isRagu == 1) checked @endif> Ragu Ragu ?  -->
        
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
    
                                                    @if($value->soal->getfotoKuis() == TRUE)
    
                                                    <img src="{{$value->soal->getfotoKuis()}}" alt="" class="img-fluid mb-4" loading="lazy" style="height: auto; width: 100%; border-radius: 15px;">
    
                                                    @endif
    
                                                    <div class="d-flex align-items-start justify-content-start">
    
                                                        <div>
    
                                                            <label class="oval">{{$loop->iteration}}</label>
    
                                                        </div>
    
                                                        <div class="w-cont">
    
                                                            {!! $value->soal->name !!}
                                                            
                                                            <!-- <div class="input-group">
    
                                                                <div class="custom-file">
    
                                                                <input type="hidden" name="isian[{{$value->id}}]" value="1">
    
                                                                    <input type="file" name="jawaban[{{$value->id}}]" onchange="ahayyy('{{route('kuis.jawab.ajax',['type' => 'jawab','jawaban' =>'1','id' => $value->id])}}');" class="custom-file-input" required>
    
                                                                    <label class="custom-file-label">Pilih file</label>
    
                                                                </div>
    
                                                            </div>  -->
    
                                                            <div class="fileInputContainer">
                                                                
                                                                <input type="hidden" name="isian[{{$value->id}}]" value="1">
                                                                    
                                                                <input type="file" name="jawaban[{{$value->id}}]" id="{{$value->id}}" value="1" class="file" multiple="true">
        
                                                            </div>
        
                                                            <!-- <input type="checkbox" style="margin-top:15px" onchange="ahayyy('{{route('kuis.jawab.ajax',['type' => 'ragu','id' => $value->id])}}')" @if($value->isRagu == 1) checked @endif> Ragu Ragu ?  -->
                                                        
                                                        </div>
            
                                                    </div>
            
                                                </div>
            
                                            </div>
        
                                        </div>
        
                                    </div>
        
                                </div>
        
                            </div>
            
                            @endif
        
                            
                            
                        </section>
                        
                        @endforeach
                      
        
                        <button class="btn btn-success" data-toggle="modal" type="button" data-target="#openConfirm" onclick="makeConfirmationMessage()">Kuis Selesai</button>

                        <!-- Modal -->
                        <div class="modal fade" id="openConfirm" tabindex="-1" aria-labelledby="openConfirmLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content py-4">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="openConfirmLabel"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batalkan</button>
                                    <button type="submit" class="btn btn-success" data-dismiss="modal" onclick="submitJawaban()">Kirim</button>
                                </div>
                                </div>
                            </div>
                        </div>

        
                    </div>
        
                </form>

            </div>


        </div>

    </div>

    @endsection


    @section('modal-content')

    @if(!empty($attachments))

    <div class="card container">

        <div class="card-header">

            <h4>Berikut lampiran yang perlu Anda unduh: </h4>

            <button class="btn" onclick="toggleModal()" style="font-size: larger;"><i class="fa fa-close"></i></button>

        </div>

        <div class="card-body">

            @foreach(explode(',',$attachments) as $attachment)

            <div class="previous-attachment mb-3">

                <a href="{{'/file/kuis-attachments/'.$attachment}}" download style="font-size: larger;"><i class="fa fa-download"></i> {{$attachment}}</a>

            </div>

            @endforeach

        </div>

    </div>

    @endif

    @endsection

    @section('js')

    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <script>

    $(document).ready(function() {

        load_no();
        @if (!empty($attachments))
        toggleModal();
        @endif

    });

    const FILEUPLOADS = {};

    // Get a reference to the file input element
    const inputElements = document.querySelectorAll('input[class="file"]');
        
    inputElements.forEach(function(inputElement) {

        // Create a FilePond instance
        const pond = FilePond.create(inputElement);

        FILEUPLOADS[inputElement.id] = [];

        let foldername;
        
        pond.setOptions({

            chunkUploads: true,

            chunkSize: 41_943_040,

            chunkForce: true,

            server: {

                process: function(fieldName, file, metadata, load, error, progress, abort, transfer, options) {

                    // url: '/kuis/{{$setkuis->id}}/upload/'+inputElement.id,

                    // onload: function(response) {

                    //     foldername = response;
                        
                    //     FILEUPLOADS[inputElement.id].push(response);

                    // }

                    const postUrl = '/kuis/{{$setkuis->id}}/upload/'+inputElement.id;
                    const patchUrl = '/kuis/{{$setkuis->id}}/patch/'+inputElement.id;

                    const useChunk = file.size > options.chunkSize;

                    const startChunk = function(folderName) {
                        const max_chunk_size = options.chunkSize;
                        const fileExtension = file.name.split('.').pop();
                        let loaded = 0;
                        let part = 1;
                        let reader = new FileReader();
                        let blob = file.slice(loaded, max_chunk_size);
                        reader.readAsArrayBuffer(blob);
                        reader.onload = function(e) {
                            let fd = new FormData();
                            fd.append('filedata', new File([reader.result], 'part-'+part));
                            fd.append('loaded', loaded);
                            fd.append('folder', folderName);
                            fd.append('fileSize', file.size);
                            fd.append('chunkSize', max_chunk_size);
                            fd.append('fileExtension', fileExtension);

                            const request = new XMLHttpRequest();
    
                            request.open('POST', patchUrl);
        
                            request.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        
                            request.upload.onprogress = (e) => {
        
                                progress(e.lengthComputable, e.loaded + loaded, file.size);
        
                            };
        
                            request.onload = function () {
        
                                if (request.status >= 200 && request.status < 300) {
                                    loaded += max_chunk_size;
                                    part++;
                                    if (loaded < file.size) {
                                        blob = file.slice(loaded, loaded + max_chunk_size);
                                        reader.readAsArrayBuffer(blob);
                                    } else {
                                        loaded = file.size;
                                        FILEUPLOADS[inputElement.id].push(request.responseText);
                                        load(request.responseText);
                                        load_no();
                                    }
                                } else {
                                    const errorMessage = `Oh no ${e.statusText} (${e.status})`
                                    error(errorMessage);
                                }

                            };
        
                            request.send(fd);

                        };
                    }

                    if (useChunk) {
                        $.ajax(postUrl, {
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            type: "POST",
                            data: { useChunk: true },
                            success: function(r) {
                                startChunk(r);
                            }
                        });
                    } else {

                        const formData = new FormData();
    
                        formData.append(fieldName, file, file.name);
    
                        const request = new XMLHttpRequest();
    
                        request.open('POST', postUrl);
    
                        request.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    
                        request.upload.onprogress = (e) => {
    
                            progress(e.lengthComputable, e.loaded, e.total);
    
                        };
    
                        request.onload = function () {
    
                            if (request.status >= 200 && request.status < 300) {
                                // the load method accepts either a string (id) or an object
                                load(request.responseText);
        
                                FILEUPLOADS[inputElement.id].push(request.responseText);
        
                                // console.log(FILEUPLOADS);

                                load_no();
    
                            } else {
                                // Can call the error method if something is wrong, should exit after
                                const errorMessage = `Oh no ${e.statusText} (${e.status})`
                                error(errorMessage);
                                // console.log(errorMessage);
                            }
    
    
                        };
    
                        request.send(formData);
    
                        return {
    
                            abort: () => {
    
                                request.abort();
    
                                abort();
    
                            },
                            
                        };

                    }
                },
            
                // revert: {

                //     url: '/kuis/{{$setkuis->id}}/delete/'+inputElement.id,
                    
                //     onload: function(response) {
                        
                //         delete FILEUPLOADS[response];

                //         console.log(FILEUPLOADS);

                //     }

                // },

                revert: (uniqueFileId, load, error) => {

                    $.ajax({

                        url: '/kuis/{{$setkuis->id}}/delete/'+inputElement.id,

                        headers: {
                            
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'

                        },

                        type: 'DELETE',

                        data: {foldername:uniqueFileId},

                         success: function(response){
                
                            FILEUPLOADS[inputElement.id] = FILEUPLOADS[inputElement.id].filter(function(folder) {
                                 
                                return folder != response; 

                            });
                            
                            load();

                            load_no();

                        }

                    })


                },

                headers: {
                    
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'

                }

            }
        });

    });

    const makeConfirmationMessage = function() {
        let inputs = $('#form-submit').serializeArray();

        let isian = {};

        let jawaban = {};

        inputs.forEach( input => {

            if(input.name.match(/(\d+)/)) {
                
                let aksesKuisId = input.name.match(/(\d+)/)[0];

                if (input.name.includes('isian')) {

                    isian[aksesKuisId] = input.value;

                } else if (input.name.includes('jawaban')) {

                    jawaban[aksesKuisId] = input.value || null;

                }

            }

        });

        postData = {

            isian: isian,

            jawaban: jawaban,

        }

        const modalTitle = document.querySelector('#openConfirm .modal-title');

        const message = Object.keys(isian).length == Object.keys(jawaban).length ? modalTitle.innerHTML = `Apakah Anda yakin untuk mengumpulkan jawaban Anda?` : modalTitle.innerHTML = `Apakah Anda yakin untuk mengumpulkan jawaban Anda? <span class="text-warning">Masih terdapat soal yang belum Anda jawab.</span>`;

        return postData;
    }


    const submitJawaban = function(instantSubmit = false) {

        const postData = makeConfirmationMessage();

        if (instantSubmit) {

            $.ajax({
        
                type: "POST",

                url: "{{route('kuis.jawab.action',$setkuis->id)}}",
                
                data: {postData:postData, fileUploads: FILEUPLOADS},

                headers: {
                    
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'

                }, 

                success: function(response){
                    
                    window.location = "{{route('kuis.jawab.list')}}"
                    
                },

            });

        } else {
            // const confirm = window.confirm(message);

            // if (confirm) {
                
                $.ajax({
        
                    type: "POST",
        
                    url: "{{route('kuis.jawab.action',$setkuis->id)}}",
                    
                    data: {postData:postData, fileUploads: FILEUPLOADS},
        
                    headers: {
                        
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
        
                    }, 
        
                    success: function(response){
                        
                        window.location = "{{route('kuis.jawab.list')}}"
                        
                    },
        
                });

            // }
        }
    };

    $( "#form-submit" ).submit(function( e ) {

        e.preventDefault();

        submitJawaban();

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
            
            endTime = endTime.toLocaleString('en-US', {timeZone: 'Asia/Bangkok'});

// 			alert(new Date('August 19, 1975 23:15:30 GMT+07:00'));

			endTime = (Date.parse(endTime) / 1000);

			var now = new Date();

            now = now.toLocaleString('en-US', {timeZone: 'Asia/Bangkok'});

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

                submitJawaban(true);

                clearInterval(timer);

            }

			if (hours < "10") { hours = "0" + hours; }

			if (minutes < "10") { minutes = "0" + minutes; }

			if (seconds < "10") { seconds = "0" + seconds; }



			$("#time-kuis").html("<span><b>"+hours+"</b>:<b>"+minutes+"</b>:<b>"+seconds+"</b></span>");

            $("#time-kuis-mobile").html("<span><b>"+hours+"</b>:<b>"+minutes+"</b>:<b>"+seconds+"</b></span>");

	}



// 	setInterval(function() { makeTimer(); }, 1000);

	const timer = setInterval(makeTimer, 1000);

    function myFunction(x) {
        if (x.matches) {
            const timeTemplate = `<div class="timer-mobile col-12">

                    <div class="mb-2 w-100 d-flex flex-column align-items-end justify-content-center col-12">

                        <p style="text-align: left; margin-bottom: 5px;">Waktu : </p>
        
                        <h3 style="text-align: left;" id="time-kuis-mobile"></h3>

                    </div>
                    
                </div>`;

            $('#btn-open-attachment').before(timeTemplate);

        } else {
            $('.timer-mobile').remove();
        }
    }

    let x = window.matchMedia("(max-width: 991px)");
    myFunction(x);
    x.addListener(myFunction);

    </script>

    <h3 style="text-align: left;"></h3>

    @endsection