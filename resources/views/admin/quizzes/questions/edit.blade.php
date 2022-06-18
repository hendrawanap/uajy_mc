@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="col-md-12">
        <form action="{{ route('admin.quizzes.questions_update', [$quiz->id, $question->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <div id="profile-settings">
                                <div class="pt-0">
                                    <div class="settings-form">
                                        <div class="form-group">
                                            <label style="display: block;">Gambar :</label>
                                            <img id="img-preview" src="{{$question->getFoto()}}" alt="" class="img-fluid mb-4" style="height: auto; width: 100%; border-radius: 15px;">

                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="foto" class="custom-file-input" onchange="readURL(this)" accept="image/jpg,image/png,image/jpeg">
                                                    <label class="custom-file-label">Pilih Gambar...</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Pertanyaan :</label>
                                            <textarea placeholder="Masukan Pertanyaan..." name="name" class="form-control pt-3" style="min-height: 150px;">{{ $question->name }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <input type="checkbox" id="pilihan" name="isPilihan" value="1" @if($question->isPilihan == 1) checked @endif> Pilihan Ganda ?
                                        </div>

                                        <div id="pilihan-view" @if($question->isPilihan == 0) style="display:none" @endif>
                                            <div class="input-group mt-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"> a </div>
                                                </div>

                                                <input type="text" name="a" placeholder="Jawaban 1..." class="form-control" value="{{$question->a}}">
                                            </div>

                                            <div class="input-group mt-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"> b </div>
                                                </div>
                                                <input type="text" name="b" placeholder="Jawaban 2..." class="form-control" value="{{$question->b}}">
                                            </div>

                                            <div class="input-group mt-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"> c </div>
                                                </div>
                                                <input type="text" name="c" placeholder="Jawaban 3..." class="form-control" value="{{$question->c}}">
                                            </div>

                                            <div class="input-group mt-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"> d </div>
                                                </div>
                                                <input type="text" name="d" placeholder="Jawaban 4..." class="form-control" value="{{$question->d}}">
                                            </div>

                                            <div class="form-group">
                                                <label>Kunci Jawaban</label>
                                                <input type="text" name="jawaban" value="{{$question->jawaban}}" placeholder="contoh : a" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group mt-4">
                                            <button class="btn btn-success" type="submit">Simpan Soal</button>
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
    $(document).ready(function() {
        $("#pilihan").on('change', function() {
            if ($('#pilihan').prop('checked')) {
                $("#pilihan-view").fadeIn();
            } else {
                $("#pilihan-view").fadeOut();
            }
        });
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img-preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection