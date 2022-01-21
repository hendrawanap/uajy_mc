<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventSubmit;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Auth;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.event.index');
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function create() {
         return view('admin.event.create');
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json()
    {
        $data = Event::all();
        return DataTables::of($data)
        ->addColumn('mulai', function ($data) {
            return str_replace('T',' ',$data->tanggal_mulai);
        })
        ->addColumn('selesai', function ($data) {
            return str_replace('T',' ',$data->tanggal_selesai);
        })
        ->addColumn('action', function ($data) {
        return '
        <a href="'.route('event.edit',$data->id).'"  class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
        <a href="'.route('event.delete',$data->id).'" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>';
        })->make(true); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'soal' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
            'durasi' => 'required'
        ]);

        $file = $request->file('soal');
        $file_name = "blank";
        if ($file) {
            $file_name = time().$file->getClientOriginalName();
            $file->move(public_path('/file/case-soal'),$file_name);
        }

        Event::create([
            'tanggal_mulai' => $request->tanggal.' '.$request->jam,
            'tanggal_selesai' => Carbon::parse($request->tanggal.' '.$request->jam)->addMinutes($request->durasi)->format('Y-m-d H:i:s'),
            'soal' => $file_name,
            'name' => $request->name
        ]);
        return redirect()->route('event.index')->with('success','Berhasil !');
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('admin.event.edit',compact('event'));
    }

    /**
     * U    pdate the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $newData = [
            'tanggal_mulai' => $request->tanggal.' '.$request->jam,
            'tanggal_selesai' => Carbon::parse($request->tanggal.' '.$request->jam)->addMinutes($request->durasi)->format('Y-m-d H:i:s'),
            'name' => $request->name
        ];

        $file = $request->file('soal');
        if ($file) {
            $file_name = time().$file->getClientOriginalName();
            $file->move(public_path('/file/case-soal'),$file_name);
            $newData['soal'] = $file_name;
            unlink(public_path($event->getSoalURL()));
        }

        $event->update($newData);
        return redirect()->route('event.index')->with('success','Berhasil !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        if($event->event_submit()->exists()) $event->event_submit()->delete();
        unlink(public_path($event->getSoalURL()));
        $event->delete();
        return redirect()->route('event.index')->with('success','Berhasil !');
    }


    public function event_peserta(Event $event) {
        return view('admin.event.submit',compact('event'));
    }

    public function event_peserta_json(Event $event) {
        $data = $event->event_submit()->with('user')->get();
        return DataTables::of($data)
        ->addColumn('tanggal', function ($data) {
            return $data->created_at->format('Y-m-d H:i:s');
        })
        ->addColumn('action', function ($data) {
        return '
        <a href="'.route('event.peserta.show',$data->id).'" class="btn btn-sm 
        btn-warning"><i class="fa fa-sign-in"></i> Lihat</a>';
        })->make(true); 
    }

    public function event_peserta_show(EventSubmit $event) {
        return view('admin.event.detail-submit',compact('event'));
    }

    public function list() {
        return view('event.index');
    }

    public function submit(Event $event) {
        if(Carbon::parse($event->getTanggalSelesai())->format('Y-m-d H:i:s') < date('Y-m-d H:i:s')) {
            return redirect()->back()->with('error','Waktu sudah habis !');
            exit;
        }
        return view('event.submit',compact('event'));
    }

    public function submit_action(Request $request,Event $event) {
        $request->validate([
            'file' => 'required'
        ]);
        $data = EventSubmit::where('user_id',Auth::user()->id)->where('event_id',$event->id);
        if($data->count() > 0) {
            return redirect()->back()->with('error','Anda hanya dapat upload 1x jika ada perubahan maka silahkan hapus data sebelumnya');
            exit;
        }
        $file = $request->file('file');
        $file_name = $event->id.Auth::user()->id.$file->getClientOriginalName();
        EventSubmit::create([
            'event_id' => $event->id,
            'file' => $file_name,
            'user_id' => Auth::user()->id
        ]);
        $file->move('file/event',$file_name);
        return redirect()->back()->with('success','Berhasil !');
    }

    public function submit_json(Event $event)
    {
        $data = $event->event_submit()->where('user_id',Auth::user()->id)->get();
        return DataTables::of($data)
        ->addColumn('file', function ($data) {
            return '<a href="'.$data->getFile().'" download>'.$data->file.'</a>';
        })
        ->addColumn('created_at', function ($data) {
            return Carbon::parse($data->created_at)->format('Y-m-d H:i:s');
        })
        ->addColumn('action', function ($data) {
        return '
        <a href="'.route('event.submit.delete',$data->id).'" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>';
        })
        ->rawColumns(['file','action'])
        ->make(true); 
    }

    public function submit_delete(EventSubmit $event) {
        unlink(public_path($event->getFile()));
        $event->delete();
        return redirect()->back()->with('success','Berhasil !');
    }
}
