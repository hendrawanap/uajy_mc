@extends('layouts.app')

@section('link')

    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />  

    <style>
        #btn-open-large {
            width: fit-content;
            background-color: var(--primary);
            /* backdrop-filter: blur(5px); */
            bottom: 6px;
            right: 24px;
            transition: all 0.3s ease-out;
            color: #fff;
            font-weight: bold;
        }

        #btn-open-large:hover {
            box-shadow: 0 0 1rem 0 rgba(0, 0, 0, .2); 
        }

        #btn-open-large.btn-loaded {
            width: 50px;
            height: 50px;
            padding: 0;
            color: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
        }
        
    </style>  

@endsection

@section('content')

<div class="container-fluid">

    <div class="row">

        <div class="timer-mobile col-12">

            <div class="mb-2 w-100 d-flex flex-column align-items-end justify-content-center col-12">

                <p style="text-align: left; margin-bottom: 5px;">Waktu : </p>

                <h3 style="text-align: left;" id="time-kuis"></h3>

            </div>
            
        </div>

        <!-- Form -->

        <form action="{{route('cases.submissions.store',$case->id)}}" method="POST" enctype="multipart/form-data" id="form-submit" class="col-xl-12">

        @csrf

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

                    <h4 class="text-primary ml-2 mt-2">Upload Case</h4>

                </div>

                <!-- Repeat Soal -->

                <div class="card">

                    <div class="card-body">

                        <div class="profile-tab">

                            <div class="custom-tab-1">

                                <div id="profile-settings">

                                    <div class="pt-0">

                                        <!-- <div>{!! $case->soal !!}</div> -->

                                        <div class="position-relative">
                                            <div id="preview" class="w-100 overflow-auto border rounded-lg" data-url="{{ $case->getSoalURL() }}" style="height: 50vh;">
                                                <div style="width: 100%; height:100%; position: relative;">
                                                    <div id="pdf-loader">
                                                        <div class="sk-three-bounce">
                                                            <div class="sk-child sk-bounce1"></div>
                                                            <div class="sk-child sk-bounce2"></div>
                                                            <div class="sk-child sk-bounce3"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn cursor-default position-absolute" id="btn-open-large" onclick="toggleModal()" disabled>Memuat...</button>
                                        </div>

                                        <p class="mb-3">

                                            <i class="fa fa-clock-o"></i>

                                            {{ \Carbon\Carbon::parse($case->tanggal_selesai)->diffInMinutes(\Carbon\Carbon::parse($case->tanggal_mulai))}} Menit

                                        </p>

                                        <p>Upload hanya dapat dilakukan selama waktu uploader tersedia</p>

                                        {{-- <div class="input-group">


                                            <div class="custom-file">

                                                <input type="file" name="file" class="custom-file-input">

                                                <label class="custom-file-label">Pilih file</label>

                                            </div>

                                        </div> --}}

                                        <div class="fileInputContainer">
                                                                                         
                                            <input type="file" name="file[]" class="file" multiple="true" required>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <button class="btn btn-success" type="submit">Simpan Berkas</button>

            </div>

        </form>

    </div>

    <div class="row mt-2">

        <div class="col-xl-12">

        <div class="card card-body">

                <table id="json-table" class="table display mb-4 table-responsive-xl dataTablesCard fs-14">

                    <thead>

                        <tr>

                            <th>File</th>

                            <th>Tanggal & Jam</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection

@section('js')

<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuid.min.js" integrity="sha512-UNM1njAgOFUa74Z0bADwAq8gbTcqZC8Ej4xPSzpnh0l6KMevwvkBvbldF9uR++qKeJ+MOZHRjV1HZjoRvjDfNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    // Get a reference to the file input element
    const inputElement = document.querySelector('input[class="file"]');

    // Create a FilePond instance
    const pond = FilePond.create(inputElement);

    let FILEUPLOADS = [];

    let foldername;

    let index = 0;

    let chunkRequests = {};

    pond.setOptions({

        chunkUploads: true,

        chunkSize: 40_943_040,

        chunkForce: true,

        server: {

            process: function(fieldName, file, metadata, load, error, progress, abort, transfer, options) {

                const postUrl = "{{route('cases.submissions.upload_temp', $case->id)}}";
                const patchUrl = "{{route('cases.submissions.patch_temp', $case->id)}}";

                const useChunk = file.size > options.chunkSize;

                const startChunk = function(folderName, postId) {
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
                                    FILEUPLOADS.push(request.responseText);
                                    load(request.responseText);
                                }
                            } else {
                                const errorMessage = `Oh no ${e.statusText} (${e.status})`
                                error(errorMessage);
                            }

                        };

                        chunkRequests[postId] = { request, folderName, loaded };

                        request.send(fd);
                    };
                }

                if (useChunk) {
                    const formData = new FormData();

                    formData.append('useChunk', true);

                    const postId = uuid.v4();

                    const request = new XMLHttpRequest();

                    request.open('POST', postUrl);

                    request.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                    request.onload = function() {
                        if (request.status >= 200 && request.status < 300) {

                            startChunk(request.response, postId);

                        } else {

                            const errorMessage = `Oh no ${request.statusText} (${request.status})`;

                            error(errorMessage);

                            console.log(errorMessage);

                        }
                    }

                    request.send(formData);

                    return {

                        abort: () => {

                            if (chunkRequests[postId]) {

                                chunkRequests[postId].request.abort();

                                if (chunkRequests[postId].loaded > 0) {

                                    $.ajax({

                                        url: "{{route('cases.submissions.delete_temp', $case->id)}}",

                                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },

                                        type: 'DELETE',

                                        data: { foldername: chunkRequests[postId].folderName },

                                        error: function(error) {

                                            console.log(error);

                                        },

                                    });

                                }

                            }

                            request.abort();

                            abort();

                        },

                    };

                } else {
                    console.log('not chunk');
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

                            FILEUPLOADS.push(request.responseText);
    
                            load(request.responseText);

                        } else {

                            const errorMessage = `Oh no ${request.statusText} (${request.status})`;

                            error(errorMessage);

                            alert(errorMessage);

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

            revert: (uniqueFileId, load, error) => {

                $.ajax({

                    url: "{{route('cases.submissions.delete_temp', $case->id)}}",

                    headers: {
                        
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'

                    },

                    type: 'DELETE',

                    data: {foldername:uniqueFileId},

                    success: function(response){
            
                        FILEUPLOADS = FILEUPLOADS.filter(function(folder) {
                                
                            return folder != response; 

                        });

                        load();
                        
                    }

                })

            },

            headers: {
                
                'X-CSRF-TOKEN': '{{ csrf_token() }}'

            }

        }
    });

    function shiftDown(filename) {

        const files = pond.getFiles();

        const fileIndex = getFileIndex(files, filename);

        pond.moveFile(fileIndex, files.length - 1 - index);

        index++;

        return fileIndex;

    }


    function getFileIndex(files, filename) {

        let fileIndex = 0;

        for (let i = 0; i < files.length; i++) {

            if (files[i].filename != filename) {

                fileIndex++;

            } else {

                break;

            }

        }

        return fileIndex;

    }

    const submitJawaban = function(isTimeup = false) {

        let inputs = $("#form-submit").serializeArray();

        let file = {};

        inputs.forEach( input => {

            if (input.name.includes('file')) {

                file['{{$case->id}}'] = input.value;

            }

        });

        postData = {file: file};

        if (FILEUPLOADS.length > 0) {

            $.ajax({
    
                type: "POST",
    
                url: "{{route('cases.submissions.store',$case->id)}}",
                
                data: {postData:postData, fileUploads: FILEUPLOADS},
    
                headers: {
                    
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
    
                }, 
    
                success: function(response){

                    if (isTimeup) {

                        window.location = "{{route('cases.index')}}";

                    } else {

                        window.location = "{{route('cases.submissions.index',$case->id)}}"

                    }
                    
                }
    
            });

        } else {

            window.location = "{{route('cases.index')}}";

        }

    }

    $( "#form-submit" ).submit(function( e ) {

        e.preventDefault();

        submitJawaban();

    });
</script>

<style>

    #preview canvas {
        width: 100%;
    }

    #large-view canvas {
        width: 100%;
    }

    .cursor-default {
        cursor: default;
    }

</style>

<script>

    $(function () {

        $('#json-table').DataTable({

            processing: true,

            serverSide: true,

            ajax: "{{ route('cases.submissions.tables', $case->id) }}",

            columns: [

                {

                    data: 'file',

                    name: 'file'

                },

				{

                    data: 'created_at',

                    name: 'created_at'

                },

              

				{

                    data: 'action',

                    name: 'action'

                }

            ]

        });

    });

    function makeTimer() {

        var endTime = new Date("{{\Carbon\Carbon::parse($case->tanggal_selesai)->format('M d, Y H:i:s')}} UTC+07:00");

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

    }

    const timer = setInterval(makeTimer, 1000);

</script>

<script src="https://unpkg.com/pdfjs-dist@latest/build/pdf.min.js"></script>

<script>
const pdfjsLib = window['pdfjs-dist/build/pdf'];

let pdfDoc = null;
let currentRenderingPage = 1;
const scale = 1;

const url = document.getElementById('preview').dataset.url;

function getDoc(url, containerId, onLoaded) {
    pdfjsLib.getDocument(url).promise.then(function(doc) {
        pdfDoc = doc;
        render(url, containerId, onLoaded);
    });
};

function render(url, containerId, onLoaded) {
    if (!pdfDoc) {
        getDoc(url, containerId, onLoaded);
    } else {
        const checkFinish = function(currentPage) {
            return currentPage == pdfDoc.numPages
        };
        const renderPromises = [];
        for (let i = 0; i < pdfDoc.numPages; i++) {
            renderPromises.push(pdfDoc.getPage(i + 1))
        }
        Promise.all(renderPromises).then(function(pages) {
            const pagesHTML = `
            <div style="width: 100%; position: relative; margin-bottom: 0.75rem;">
                <div id="pdf-loader">
                    <div class="sk-three-bounce">
                        <div class="sk-child sk-bounce1"></div>
                        <div class="sk-child sk-bounce2"></div>
                        <div class="sk-child sk-bounce3"></div>
                    </div>
                </div>
                <canvas style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;"></canvas>
            </div>`.repeat(pages.length);
            const container = document.getElementById(containerId);
            container.innerHTML = pagesHTML;
            renderPage(pages, container, checkFinish, onLoaded, 0);
        });
    }
};

function renderPage(pages, _container, check, onLoaded, pageIndex) {
    const DELAY_AFTER_RENDER = 500;
    const page = pages[pageIndex];
    let pdfViewport = page.getViewport({ scale: 1 });

    const container = _container.children[page._pageIndex];
    const scale = container.offsetWidth ? (container.offsetWidth / pdfViewport.width) : (1110 / pdfViewport.width);
    pdfViewport = page.getViewport({ scale });
    const loader = container.children[0];
    const canvas = container.children[1];
    const context = canvas.getContext("2d");
    canvas.height = pdfViewport.height;
    canvas.width = pdfViewport.width;

    page.render({
      canvasContext: context,
      viewport: pdfViewport
    })
    .promise
    .then(function() {
        loader.classList.add('d-none');
        if (check(page.pageNumber)) {
            onLoaded ? onLoaded() : null;
        } else {
            setTimeout(function() {
                renderPage(pages, _container, check, onLoaded, (pageIndex + 1));
            }, DELAY_AFTER_RENDER);
        }
    })
    .catch(function(e){ console.log(e) });
};

let firstTimeOpen = true;

function onPreviewLoaded() {
    const btnOpen = document.getElementById('btn-open-large');
    btnOpen.innerHTML = '<i class="fa fa-search-plus fs-24"></i>';
    btnOpen.attributes.removeNamedItem('disabled');
    btnOpen.classList.remove('cursor-default');
    btnOpen.classList.add('btn-loaded');
    btnOpen.addEventListener('click', function() {
        if (firstTimeOpen) {
            firstTimeOpen = false;
            render(url, 'large-view');
        }
    });
}

render(url, 'preview', onPreviewLoaded);

</script>

@endsection

@section('modal-content')

<div id="large-view" class="w-100" data-url="{{ $case->getSoalURL() }}">
    <h1 style="display: none" id="error-2">An error occurred</h1>
    <div id="loader-2">
        Loading...
    </div>
</div>

@endsection