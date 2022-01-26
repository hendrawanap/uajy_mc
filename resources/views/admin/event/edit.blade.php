@extends('layouts.app')

@section('content')

<div class="container-fluid">



    <div class="col-xl-12">

        <!-- Title -->

        <div class="d-flex justify-content-start align-items-center mb-4">

            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"

                class="scale5 mr-0 mb-0 mr-sm-2 mb-sm-1">

                <path

                    d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z"

                    stroke="#222fb9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>

                <path d="M16 2V6" stroke="#222fb9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                </path>

                <path d="M8 2V6" stroke="#222fb9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                </path>

                <path d="M3 10H21" stroke="#222fb9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                </path>

            </svg>

            <h4 class="text-primary ml-2 mt-2">Edit Case</h4>

        </div>

        <!-- Repeat Soal -->

        <div class="card">

            <div class="card-body">

                <div class="profile-tab">

                    <div class="custom-tab-1">

                        <div id="profile-settings">

                            <div class="pt-0">



                               

                                <div class="settings-form">

                                    <form action="{{route('event.update',$event->id)}}" method="POST" enctype="multipart/form-data">

                                        @csrf

                                        @method('PUT')

                                        <div class="form-row">

                                        <div class="form-group col-md-12">

                                                <label>Nama :</label>

                                                <input type="text" name="name" value="{{$event->name}}" class="form-control"

                                                    placeholder="Nama Event...">

                                            </div>

                                            <div class="form-group col-md-12">

                                                <label>Soal :</label>

                                                <!-- <textarea name="soal" class="form-control"

                                                    placeholder="Pertanyaan Event...">{{$event->soal}}</textarea> -->
                                                <div id="preview" class="w-100 overflow-auto border rounded-lg" data-url="{{ $event->getSoalURL() }}" style="height: 50vh;">
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
                                                
                                                <div class="mt-2 d-flex justify-content-end">
                                                    <button type="button" class="btn btn-primary cursor-default" id="btn-open-large" onclick="toggleModal()" disabled>Memuat...</button>
                                                </div>


                                                <div class="input-group mt-3">

                                                    <div class="custom-file">

                                                        <input type="file" class="custom-file-input" name="soal" accept=".pdf">

                                                        <label class="custom-file-label">Pilih Dokumen PDF...</label>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="form-group col-md-4">

                                                <label>Tanggal :</label>

                                                <input type="date" name="tanggal" value="{{explode(' ',$event->tanggal_mulai)[0]}}" class="form-control">

                                            </div>

                                            <div class="form-group col-md-4">

                                                <label>Jam :</label>    

                                                <input type="time" name="jam" value="{{explode(' ',$event->tanggal_mulai)[1]}}" class="form-control">

                                            </div>

                                            <div class="form-group col-md-4">

                                                <label>Durasi (Menit):</label>

                                                @php 

                                                    $tanggal_awal = \Carbon\Carbon::parse($event->tanggal_mulai);

                                                    $tanggal_selesai = \Carbon\Carbon::parse($event->tanggal_selesai);

                                                @endphp

                                                <input type="number" name="durasi" value="{{$tanggal_selesai->diffInMinutes($tanggal_awal)}}" class="form-control">

                                            </div>

                                        </div>

                                        <button class="btn btn-success" type="submit">Submit</button>

                                     

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('modal-content')

<div id="large-view" class="w-100" data-url="{{ $event->getSoalURL() }}">
    <h1 style="display: none" id="error-2">An error occurred</h1>
    <div id="loader-2">
        Loading...
    </div>
</div>

@endsection

@section('js')

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

<script src="https://unpkg.com/pdfjs-dist@latest/build/pdf.min.js"></script>

<script>
const pdfjsLib = window['pdfjs-dist/build/pdf'];

let pdfDoc = null;
let currentRenderingPage = 1;
const scale = 1;

const url = document.getElementById('preview').dataset.url;

const getDoc = (url, containerId, onLoaded) => {
    pdfjsLib.getDocument(url).promise.then((doc) => {
        pdfDoc = doc;
        render(url, containerId, onLoaded);
    });
};

const render = (url, containerId, onLoaded) => {
    if (!pdfDoc) {
        getDoc(url, containerId, onLoaded);
    } else {
        const checkFinish = (currentPage) => currentPage == pdfDoc.numPages;
        const renderPromises = [];
        for (let i = 0; i < pdfDoc.numPages; i++) {
            renderPromises.push(pdfDoc.getPage(i + 1))
        }
        Promise.all(renderPromises).then(pages => {
            const pagesHTML = `
            <div style="width: 100%; position: relative;">
                <div id="pdf-loader">
                    <div class="sk-three-bounce">
                        <div class="sk-child sk-bounce1"></div>
                        <div class="sk-child sk-bounce2"></div>
                        <div class="sk-child sk-bounce3"></div>
                    </div>
                </div>
                <canvas></canvas>
            </div>`.repeat(pages.length);
            const container = document.getElementById(containerId);
            container.innerHTML = pagesHTML;
            pages.forEach(page => renderPage(page, container, checkFinish, onLoaded));
        })
    }
};

const renderPage = (page, _container, check, onLoaded) => {
    let pdfViewport = page.getViewport({ scale: 1 });

    const container = _container.children[page._pageIndex];
    pdfViewport = page.getViewport({ scale: container.offsetWidth / pdfViewport.width });
    const loader = container.children[0];
    const canvas = container.children[1];
    const context = canvas.getContext("2d");
    canvas.height = pdfViewport.height;
    canvas.width = pdfViewport.width;

    page.render({
      canvasContext: context,
      viewport: pdfViewport
    }).promise
    .then(() => {
        loader.style.display = 'none';
        if (check(page._pageIndex + 1)) {
            onLoaded ? onLoaded() : null;
        }
    })
    .catch((e) => console.log(e));
};

let firstTimeOpen = true;

const onPreviewLoaded = () => {
    const btnOpen = document.getElementById('btn-open-large');
    btnOpen.innerHTML = 'Perbesar';
    btnOpen.attributes.removeNamedItem('disabled');
    btnOpen.classList.remove('cursor-default');
    btnOpen.addEventListener('click', () => {
        if (firstTimeOpen) {
            render(url, 'large-view')
        }
        firstTimeOpen = false;
    });
}

render(url, 'preview', onPreviewLoaded);

</script>

@endsection