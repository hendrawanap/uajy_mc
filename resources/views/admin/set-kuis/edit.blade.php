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
            <h4 class="text-primary ml-2 mt-2">Set Kuis</h4>
        </div>
        <!-- Repeat Soal -->
        <div class="card">
            <div class="card-body">
                <div class="profile-tab">
                    <div class="custom-tab-1">
                        <div id="profile-settings">
                            <div class="pt-0">
                                <!-- Judul Quiz -->
             
                                <div class="settings-form">
                                    <form action="{{route('jadwal.update',$setkuis->id)}}" method="POST" class="form-validation">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>Tanggal :</label>
                                                <input type="date" name="tanggal" value="{{explode(' ',$setkuis->tanggal_mulai)[0]}}"
                                                    class="form-control" placeholder="Tanggal...">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Jam :</label>
                                                <input type="time" name="waktu" value="{{explode(' ',$setkuis->tanggal_mulai)[1]}}" 
                                                placeholder="Jam..." class="form-control form-control-md">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Durasi (Menit) :</label>
                                                <input type="number" name="durasi" min="1" value="{{$setkuis->durasi}}" placeholder="Durasi..." class="form-control form-control-md">
                                            </div>
                                        </div>
                                        <button class="btn btn-success" type="submit">Set Kuis</button>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    @endsection
  