@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="col-xl-12">
                <div class="d-flex justify-content-start align-items-center mb-4">
                    <svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#222fb9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <h4 class="text-primary ml-2 mt-2">Periksa Quiz</h4>
                </div>

                <div class="table-responsive">
                    <table id="example5" class="table display mb-4 table-responsive-xl dataTablesCard fs-14">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Tanggal & Waktu Mulai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img class="rounded-circle mr-2" alt="image" width="50" src="/template/images/avatar/1.png"> {{$submission->user->name}}</td>
                                <td>{{$submission->created_at}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.quizzes.submissions_users_update', [$quiz->id, $schedule->id, $user->id]) }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="nilai" value="{{$submission->nilai}}" placeholder="Masukkan Nilai...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Submit Nilai</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @forelse($questions as $key => $question)

                @if($question[0]->type == 1)
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <div id="profile-settings">
                                    <div class="pt-0">
                                        @if($question[0]->soal->foto == TRUE)
                                        <img src="{{$question[0]->soal->getFoto()}}" loading="lazy" alt="" class="img-fluid mb-4" style="height: auto; width: 100%; border-radius: 15px;">
                                        @endif

                                        <div class="d-flex align-items-start justify-content-start">
                                            <div>
                                                <label class="oval">{{ $loop->iteration }}</label>
                                            </div>

                                            <div class="w-cont">
                                                <h3 class="judul">{!! $question[0]->soal->name !!}</h3>
                                                <div class="settings-form">
                                                    <div class="radio d-flex align-items-center wans">
                                                        <label class="form-control d-flex align-items-center" style="cursor: pointer;">
                                                            <input disabled type="radio" name="jawaban[{{$question[0]->id}}]" class="mr-3 ml-2 ans" value="a" @if($question[0]->jawaban == "a") checked @endif>
                                                            <b>A .</b>&nbsp;{{ $question[0]->soal->a }}
                                                        </label>
                                                    </div>

                                                    <div class="radio d-flex align-items-center wans">
                                                        <label class="form-control d-flex align-items-center" style="cursor: pointer;">
                                                            <input disabled type="radio" name="jawaban[{{$question[0]->id}}]" class="mr-3 ml-2 ans" value="b" @if($question[0]->jawaban == "b") checked @endif>
                                                            <b>B .</b>&nbsp; {{ $question[0]->soal->b }}
                                                        </label>
                                                    </div>

                                                    <div class="radio d-flex align-items-center wans">
                                                        <label class="form-control d-flex align-items-center" style="cursor: pointer;">
                                                            <input disabled type="radio" name="jawaban[{{$question[0]->id}}]" value="c" class="mr-3 ml-2 ans" @if($question[0]->jawaban == "c") checked @endif>
                                                            <b>C .</b>&nbsp; {{ $question[0]->soal->c }}
                                                        </label>
                                                    </div>

                                                    <div class="radio d-flex align-items-center wans">
                                                        <label class="form-control d-flex align-items-center" style="cursor: pointer;">
                                                            <input disabled type="radio" name="jawaban[{{$question[0]->id}}]" class="mr-3 ml-2 ans" value="d" @if($question[0]->jawaban == "d") checked @endif>
                                                            <b>D .</b>&nbsp; {{ $question[0]->soal->d }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @else
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <div id="profile-settings">
                                    <div class="pt-0">
                                        @if($question[0]->soal->foto == TRUE)
                                        <img src="{{$question[0]->soal->getFoto()}}" loading="lazy" alt="" class="img-fluid mb-4" style="height: auto; width: 100%; border-radius: 15px;">
                                        @endif

                                        <div class="d-flex align-items-start justify-content-start">
                                            <div>
                                                <label class="oval">{{$loop->iteration}}</label>
                                            </div>

                                            <div class="w-cont">
                                                <h3 class="judul">{!! $question[0]->soal->name !!}</h3>
                                                <div class="file-peserta">
                                                    @foreach ($question as $aksesKuis)
                                                    @if ($aksesKuis->jawaban)
                                                    <a href="{{$aksesKuis->getJawaban()}}" download>
                                                        <i class="fa fa-paperclip"></i>
                                                        {{ basename($aksesKuis->getJawaban()) }}
                                                    </a>
                                                    <hr>
                                                    @else
                                                    <p>Peserta tidak mengumpulkan jawaban</p>
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @empty
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
