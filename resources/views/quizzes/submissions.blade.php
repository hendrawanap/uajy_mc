@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">

        <div class="col-lg-12">

            <div class="table-responsive">

                <table id="json-table" class="table display mb-4 table-responsive-xl dataTablesCard fs-14">

                    <thead>

                        <tr>

                            <th>Kuis</th>

                            <th>Peserta</th>

                            <th>Tanggal & Jam</th>

                            <th>Nilai</th>

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

            ajax: '{{ route("quizzes.submissions_tables") }}',

            columns: [{

                    data: 'kuis_name',

                    name: 'kuis_name'

                },

				{

                    data: 'user.name',

                    name: 'user.name'

                },

                {

                    data: 'set_kuis.tanggal_mulai',

                    name: 'set_kuis.tanggal_mulai'

                },

				{

                    data: 'nilai',

                    name: 'nilai'

                }

            ]

        });

    });

</script>

@endsection