@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">

        <!-- Form -->

        <form action="{{route('event.submit.action',$event->id)}}" method="POST" enctype="multipart/form-data" class="col-xl-12">

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

                                        <!-- <div>{!! $event->soal !!}</div> -->

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

                                        <p class="mb-3">

                                            <i class="fa fa-clock-o"></i>

                                            {{ \Carbon\Carbon::parse($event->tanggal_selesai)->diffInMinutes(\Carbon\Carbon::parse($event->tanggal_mulai))}} Menit

                                        </p>

                                        <p>Upload hanya dapat dilakukan selama waktu uploader tersedia</p>

                                        <div class="input-group">

                                            <div class="custom-file">

                                                <input type="file" name="file" class="custom-file-input">

                                                <label class="custom-file-label">Pilih file</label>

                                            </div>

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

    canvas.addEventListener('contextmenu', (e) => e.preventDefault(), false);

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

<script>

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