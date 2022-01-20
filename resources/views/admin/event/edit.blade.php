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
                                                <div id="area" class="w-100 overflow-auto border rounded-lg" data-url="{{ $event->getSoalURL() }}" style="height: 50vh;">
                                                    <h1 style="display: none" id="error">An error occurred</h1>
                                                    <div id="loader">
                                                        Loading...
                                                    </div>
                                                </div>

                                                <!-- <h1 style="display: none" id="error-2">An error occurred</h1>
                                                <div id="loader-2" class="lds-ring">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                                <div id="area-2" class="w-100 overflow-auto border rounded-lg" data-url="{{ $event->getSoalURL() }}" style="height: 50vh;"></div> -->

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

    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content bg-transparent border-0">
        </div>
    </div>
</div>
<!-- <h1 style="display: none" id="error-2">An error occurred</h1>
<div id="loader-2" class="lds-ring">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
</div>
<div id="area-2" class="d-flex flex-column align-items-center bg-white w-100" data-url="{{ $event->getSoalURL() }}"></div> -->






    @endsection

@section('js')

<style>
    #area canvas {
        width: 100%;
    }
</style>

<script src="https://unpkg.com/pdfjs-dist@latest/build/pdf.min.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/epubjs@0.3.92/dist/epub.min.js"></script>

<script>
    const url = document.getElementById('area').dataset.url;
    console.log(url);
  var book = ePub(url);
  var rendition = book.renderTo("area", {width: 600, height: 400});
  var displayed = rendition.display();
</script> -->

<script>
const pdfjsLib = window['pdfjs-dist/build/pdf'];

let pdfDoc = null;
let currentRenderingPage = 1;
const scale = 1;
// const pagesContainer = document.getElementById('area');

const renderPage = (num, onPdfLoaded, id) => {
    const pagesContainer = document.getElementById(id);

    currentRenderingPage = num;

    // Using promise to fetch the page
    pdfDoc.getPage(currentRenderingPage).then(function (page) {
        
        let pdfViewport = page.getViewport({ scale });

        const container = document.getElementById(id);

        // Render at the page size scale.
        pdfViewport = page.getViewport({scale: container.offsetWidth / pdfViewport.width});
        const canvas = document.createElement('canvas');
        container.appendChild(canvas);
        const context = canvas.getContext('2d');
        canvas.height = pdfViewport.height;
        canvas.width = pdfViewport.width;

        const renderTask = page.render({
            canvasContext: context,
            viewport: pdfViewport,
        });
        
        // Wait for rendering to finish
        renderTask.promise.then(function () {
            
            if (currentRenderingPage < pdfDoc.numPages) {
                currentRenderingPage++;
                renderPage(currentRenderingPage, onPdfLoaded, id);
                onPdfLoaded();
            }

        });
    });

}

const renderAllPages = (onPdfLoaded, id) => {
    renderPage(1, onPdfLoaded, id);
}

const renderPdf = (url, onPdfLoaded, onError, id) => {

    pdfjsLib.getDocument(url).promise
        .then(function (pdfDoc_) {
            pdfDoc = pdfDoc_;
            renderAllPages(onPdfLoaded, id);
        })
        .catch(error => onError(error));

}

</script>

<script>

      document.addEventListener('DOMContentLoaded', function () {
          
        const url = document.getElementById('area').dataset.url;

          const errorContainer = document.getElementById('error');
          const pdfViewerContainer = document.getElementById('pages-container');
          const loader = document.getElementById('loader');

          renderPdf(
              url,
              onPdfLoaded = () => loader.classList.add('d-none'),
              onError = error => {
                  loader.style.display = 'none';
                  console.error(error);
                  errorContainer.style.display = 'block';
                  pdfViewerContainer.style.display = 'none';
                  errorContainer.innerText = error.message;
              },
              'area');

      }, false);

  </script>


@endsection