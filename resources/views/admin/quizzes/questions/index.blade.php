@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.quizzes.questions_store', $quiz->id) }}" method="POST" enctype="multipart/form-data">
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
                                                <img id="img-preview" src="https://via.placeholder.com/800x300" alt="" class="img-fluid mb-4" style="height: auto; width: 100%; border-radius: 15px;">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="foto" onchange="readURL(this)" accept="image/jpg,image/png,image/jpeg">
                                                        <label class="custom-file-label">Pilih Gambar...</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Pertanyaan :</label>
                                                <textarea placeholder="Masukan Pertanyaan..." name="name" class="form-control pt-3" style="min-height: 150px;"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <input type="checkbox" id="pilihan" name="isPilihan" value="1"> Pilihan Ganda ?
                                            </div>

                                            <div id="pilihan-view" style="display:none">
                                                <div class="input-group mt-3">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"> a </div>
                                                    </div>
                                                    <input type="text" name="a" placeholder="Jawaban 1..." class="form-control">
                                                </div>

                                                <div class="input-group mt-3">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"> b </div>
                                                    </div>
                                                    <input type="text" name="b" placeholder="Jawaban 2..." class="form-control">
                                                </div>

                                                <div class="input-group mt-3">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"> c </div>
                                                    </div>
                                                    <input type="text" name="c" placeholder="Jawaban 3..." class="form-control">
                                                </div>

                                                <div class="input-group mt-3">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"> d </div>
                                                    </div>
                                                    <input type="text" name="d" placeholder="Jawaban 4..." class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>Kunci Jawaban</label>
                                                    <input type="text" name="jawaban" placeholder="contoh : a" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group  mt-4">
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

        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white font-weight-bold">
                    <i class="fa fa-list"></i> Data
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered" id="json-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Soal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>
    $(function() {
        $('#json-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.quizzes.questions_tables", $quiz->id)}}',
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'soal',
                    name: 'soal'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    });

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
