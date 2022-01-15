@forelse($data as $key => $value)
    @if($value['type'] == "pilihan")
        @include('admin.kuis.ajax.soal.pilihan',['no' => $loop->iteration,'key' => $key])
    @elseif($value['type'] == "essay")
        @include('admin.kuis.ajax.soal.essay',['no' => $loop->iteration,'key' => $key])
    @endif
    <a href="javascript:;" class="btn btn-success" onclick="simpan('{{route('soal.save')}}')">Simpan Soal</a>
@empty 
@endforelse
