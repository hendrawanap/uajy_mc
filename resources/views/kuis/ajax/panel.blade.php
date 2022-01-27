

@forelse($data as $key => $value)

<a class="ns @if($value->isRagu == 1) ns-ragu @elseif($value->jawaban == TRUE) ns-sudah @endif 

" href="{{url('/kuis')}}/{{$value->set_kuis->id}}/show#{{$loop->iteration}}">{{$loop->iteration}}</a>

@empty 

@endforelse

