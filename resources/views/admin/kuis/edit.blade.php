@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">

        <!-- Form -->

        <form action="{{route('kuis.update',$data->id)}}" method="POST" class="col-xl-12" enctype="multipart/form-data">

            @csrf

            @method('PUT')

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

                    <h4 class="text-primary ml-2 mt-2">Edit Kuis</h4>

                </div>

                <div class="card">

                    <div class="card-body">

                        <div class="profile-tab">

                            <div class="custom-tab-1">

                                <div id="profile-settings">

                                    <div class="pt-3">

                                        <div class="settings-form">

                                            <div class="form-group">

                                                <label>Judul Kuis</label>

                                                <input type="text" name="name" value="{{$data->name}}" placeholder="Masukan Judul..." class="form-control">

                                            </div>

                                            <div class="form-group">

                                                <label>Nilai Per Soal</label>

                                                <input type="text" name="soal_value" value="{{$data->soal_value}}" placeholder="Masukan Nilai Per Soal..." class="form-control">

                                            </div>


                                            <div class="form-group">

                                                <label>Attachments</label>

                                                @if (empty($data->attachments))

                                                <div class="input-group" id="attachments">

                                                @else

                                                <div class="input-group" id="attachments" style="display: none;">

                                                @endif

                                                    <div class="custom-file mb-3">

                                                        <input type="file" name="attachments[]" class="custom-file-input" multiple>

                                                        <label class="custom-file-label">Pilih Dokumen...</label>

                                                    </div>

                                                </div>

                                                @if(empty($data->attachments))
    
                                                @else
    
                                                @foreach(explode(',',$data->attachments) as $attachment)
                                                
                                                <div class="previous-attachment mb-3">

                                                    <a href="{{'/file/kuis-attachments/'.$attachment}}" download=""><i class="fa fa-paperclip"></i> {{$attachment}}</a>

                                                </div>

                                                @endforeach

                                                <input type="checkbox" id="replace-attachments" name="replace_attachments">
                                                <label for="replace_attachments">Replace Attachments?</label>
    
                                                @endif

                                            </div>

                                            <button class="btn btn-success" type="submit">Simpan Data</button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection

@section('js')

<script>

    $(document).ready(function () {

        $("#replace-attachments").on('change', function () {

            if ($('#replace-attachments').prop('checked')) {

                $("#attachments").show();
                $(".previous-attachment").hide();

            } else {

                $("#attachments").hide();
                $(".previous-attachment").show();

            }

        });

    });

</script>

@endsection
