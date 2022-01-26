@extends('layouts.app')

@section('link')

    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />    

@endsection

@section('content')

<div class="container-fluid">

    <div class="row">

        <!-- Form -->

        <form action="{{route('event.submit.action',$event->id)}}" method="POST" enctype="multipart/form-data" id="form-submit" class="col-xl-12">

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

                                        <div>{!! $event->soal !!}</div>

                                        <p class="mb-3">

                                            <i class="fa fa-clock-o"></i>

                                            {{ \Carbon\Carbon::parse($event->tanggal_selesai)->diffInMinutes(\Carbon\Carbon::parse($event->tanggal_mulai))}} Menit

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

<script>

    // Get a reference to the file input element
    const inputElement = document.querySelector('input[class="file"]');

    // Create a FilePond instance
    const pond = FilePond.create(inputElement);

    let FILEUPLOADS = [];

    let foldername;

    let index = 0;
    
    pond.setOptions({

        chunkUploads: true,

        chunkSize: 10_000_000,

        chunkForce: true,

        server: {

            process: function(fieldName, file, metadata, load, error, progress, abort, transfer, options) {


                // onload: function(response) {

                //     FILEUPLOADS.push(response);
                    
                //     const filePondRevertButtons = document.querySelectorAll('.filepond--file-action-button.filepond--action-revert-item-processing');

                //     for(let i = 0; i < filePondRevertButtons.length; i++) {
                            
                //         filePondRevertButtons[i].addEventListener('click', function(e) {
                            
                //             FILEUPLOADS.reverse();
                            
                //             foldername = FILEUPLOADS[i];

                //             console.log(foldername);

                //             FILEUPLOADS = FILEUPLOADS.filter(function(folder) {
                                    
                //                 return folder != foldername; 

                //             });

                //             FILEUPLOADS.reverse();

                //         });
    

                //     }
                    
                //     console.log(FILEUPLOADS);

                // }

                const postUrl = '/event/{{$event->id}}/upload/'+inputElement.id;
                const patchUrl = '/event/{{$event->id}}/patch/'+inputElement.id;

                const useChunk = file.size > options.chunkSize;

                const startChunk = function(folderName) {
                    const max_chunk_size = options.chunkSize;
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
                        $.ajax(patchUrl, {
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            type: "POST",
                            contentType: false,
                            data: fd,
                            processData: false,
                            success: function(r) {
                                loaded += max_chunk_size;
                                part++;
                                if (loaded < file.size) {
                                    blob = file.slice(loaded, loaded + max_chunk_size);
                                    reader.readAsArrayBuffer(blob);
                                    progress(true, loaded, file.size);
                                } else {
                                    loaded = file.size;
                                    FILEUPLOADS.push(r);
                                    load(r);
                                }
                            },
                            error: function(e) {
                                const errorMessage = `Oh no ${e.statusText} (${e.status})`
                                error(errorMessage);
                                console.log(errorMessage);
                            }
                        });
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

                            FILEUPLOADS.push(request.responseText);
    
                            load(request.responseText);

                        } else {
                            const errorMessage = `Oh no ${e.statusText} (${e.status})`
                            error(errorMessage);
                            console.log(errorMessage);
                        }
    
                        
                        // shiftDown(file.name);
    
                        // const files = pond.getFiles();
    
                        // const fileIndex = getFileIndex(files, file.name);
    
                        // const filePondRevertButtons = document.querySelectorAll('.filepond--file-action-button.filepond--action-revert-item-processing');
                                
                        // filePondRevertButtons[fileIndex].addEventListener('click', function(e) {
    
                        //     FILEUPLOADS.reverse();
                            
                        //     foldername = FILEUPLOADS[getFileIndex(files, e.target.parentNode.previousSibling.innerText)];
    
                        //     console.log(foldername);
    
                        //     FILEUPLOADS = FILEUPLOADS.filter(function(folder) {
                                    
                        //         return folder != foldername; 
    
                        //     });
    
                        //     FILEUPLOADS.reverse();
    
                        // });
    
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

            //     url: '/event/{{$event->id}}/delete',
                
            //     onload: function(response) {
                    
            //         FILEUPLOADS = FILEUPLOADS.filter(function(folder) {
                                
            //             return folder != response; 

            //         });

            //         console.log(FILEUPLOADS);

            //     }

            // },

            revert: (uniqueFileId, load, error) => {

                $.ajax({

                    url: '/event/{{$event->id}}/delete',

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

    $( "#form-submit" ).submit(function( e ) {

        e.preventDefault();

        let inputs = $(this).serializeArray();

        let file = {};

        inputs.forEach( input => {

            if (input.name.includes('file')) {

                file['{{$event->id}}'] = input.value;

            }

        });

        postData = {file: file}

        $.ajax({

            type: "POST",

            url: "{{route('event.submit.action',$event->id)}}",
            
            data: {postData:postData, fileUploads: FILEUPLOADS},

            headers: {
                
                'X-CSRF-TOKEN': '{{ csrf_token() }}'

            }, 

            success: function(response){
                
                window.location = "{{route('event.submit',$event->id)}}"
                
            }

        });

    });


    $(function () {

        $('#json-table').DataTable({

            processing: true,

            serverSide: true,

            ajax: '{{ route('event.submit.json',$event->id) }}',

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

</script>

@endsection