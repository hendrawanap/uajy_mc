<table class="table table-striped">
    
    <tr>
        <td>Nama</td>
        <td>{{$data->name ?? ''}}</td>
    </tr>
    <tr>
        <td>Merk</td>
        <td>{{$data->merk ?? ''}}</td>
    </tr>
    <tr>
        <td>Jenis</td>
        <td>{{$data->jenis ?? ''}}</td>
    </tr>
    <tr>
        <td>Peruntukan</td>
        <td>{{$data->peruntukan ?? ''}}</td>
    </tr>
    <tr>
        <td>Speed</td>
        <td>{{$data->speed ?? ''}}</td>
    </tr>

    <tr>
        <td>Launching </td>
        <td>{{$data->launching ?? ''}}</td>
    </tr>
   
    <tr>
        <td>Dibuat</td>
        <td>{{$data->created_at}}</td>
    </tr>

    <tr>
        <td>Diperbaharui</td>
        <td>{{$data->created_at}}</td>
    </tr>
</table>