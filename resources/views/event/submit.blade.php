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
                                        <div>{!! $event->soal !!}</div>
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
@section('js')
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