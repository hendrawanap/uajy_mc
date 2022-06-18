@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="d-flex justify-content-start align-items-center mb-4">
            <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#222fb9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <h4 class="text-primary ml-2 mt-2">Peserta Kuis</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="json-table" class="table display mb-4 table-responsive-xl dataTablesCard fs-14">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Name</th>
                            <th>Quiz</th>
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
    $(function() {
        $('#json-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.quizzes.submissions_users_tables", [$quiz->id, $schedule->id]) }}',
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'users',
                    name: 'users'
                },
                {
                    data: 'user.name',
                    name: 'user.name'
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
