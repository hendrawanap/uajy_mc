<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventSubmit;
use App\CaseTemporaryFile;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Auth;
use DirectoryIterator;
use Exception;
use Session;

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
        $data = $event->event_submit()->with('user')->orderByDesc('created_at')->get()->unique('user_id');

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

        $temporaryFiles = CaseTemporaryFile::where('event_id', $event->id)->where('user_id', Auth::user()->id)->get();

        if ($temporaryFiles->count() > 0) {

            foreach ($temporaryFiles as $temporaryFile) {

                $temporaryFile->delete();

                array_map('unlink', glob(public_path('file/event/temp/' . $temporaryFile->folder . '/*.*')));

                rmdir(public_path('file/event/temp/' . $temporaryFile->folder));

            }

        }

        return view('event.submit',compact('event'));
    }

    public function submit_action(Request $request,Event $event) {
        // $request->validate([
        //     'file' => 'required'
        // ]);
        // $data = EventSubmit::where('user_id',Auth::user()->id)->where('event_id',$event->id);
        // if($data->count() > 0) {
        //     return redirect()->back()->with('error','Anda hanya dapat upload 1x jika ada perubahan maka silahkan hapus data sebelumnya');
        //     exit;
        // }

        // $file = $request->file('file');
        // $file_name = $event->id . Auth::user()->id . $file->getClientOriginalName();
        // EventSubmit::create([
        //     'event_id' => $event->id,
        //     'file' => $file_name,
        //     'user_id' => Auth::user()->id,
        // ]);
        // $file->move('file/event', $file_name);


        $temporaryFiles = array();

        foreach ($request->fileUploads as $foldername) {

            array_push($temporaryFiles, CaseTemporaryFile::where('folder', $foldername)->where('event_id', $event->id)->where('user_id', Auth::user()->id)->first());

        }

        if (count($temporaryFiles) > 0) {

            foreach ($temporaryFiles as $index => $temporaryFile) {

                EventSubmit::create([

                    'event_id' => $event->id,

                    'file' => $temporaryFile->filename,

                    'user_id' => Auth::user()->id,

                ]);


                File::move(public_path('file\\event\\temp\\' . $temporaryFile->folder . '\\' . $temporaryFile->filename), public_path('file\\event\\' . $temporaryFile->filename));

                $temporaryFile->delete();

                rmdir(public_path('file\\event\\temp\\' . $temporaryFile->folder));

            }

        }
        
        // return redirect()->back()->with('success','Berhasil !');

        Session::flash('success', 'Berhasil !');

        return 'Berhasil !';

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

    public function uploadEventFile(Request $request, Event $event) {

        if ($request->input('useChunk')) {

            $folder = $event->id.Auth::user()->id.'-'.uniqid().'-'.now()->timestamp;

            return $folder;

        } else {

            if ($request->hasFile('file')) {
                
                $files = $request->file('file');
    
                foreach ($files as $file) {
    
                    // Baps-Case Susah-uniqid
                
                    $filename = Auth::user()->name.'-'.$event->name.'-'.uniqid().'.'.$file->extension();
    
                    $folder = $event->id.Auth::user()->id.'-'.uniqid().'-'.now()->timestamp;
    
                    $file->move('file/event/temp/' . $folder, $filename);
    
                    CaseTemporaryFile::create([
    
                        'user_id' => Auth::user()->id,
    
                        'event_id' => $event->id,
    
                        'folder' => $folder,
    
                        'filename' => $filename
    
                    ]);
    
                    return $folder;
                    
                }
    
            }

        }

        return '';

    }

    public function patchEventFile(Request $request, Event $event) {
        
        $loaded = $request->input('loaded');

        $chunkSize = $request->input('chunkSize');
        
        $fileSize = $request->input('fileSize');
        
        $chunk = $request->file('filedata');

        $chunkName = $chunk->getClientOriginalName();
        
        $folder = $request->input('folder');

        try {

            $chunk->move('file/event/temp/' . $folder, $chunkName);

            if ($loaded + $chunkSize > $fileSize) {

                $dir = new DirectoryIterator(public_path('file/event/temp/'.$folder));

                $extension = $request->input('fileExtension');

                $filename = Auth::user()->name.'-'.$event->name.'-'.explode('-', $folder)[1].'.'.$extension;

                foreach ($dir as $fileinfo) {

                    if (!$fileinfo->isDot()) {

                        $chunkPath = public_path('file/event/temp/'.$folder.'/'.$fileinfo->getFileName());

                        $file = fopen($chunkPath, 'rb');

                        $buff = fread($file, $chunkSize);

                        fclose($file);
                        
                        $filePath = public_path('file/event/temp/'.$folder.'/'.$filename);

                        $final = fopen($filePath,'ab');

                        $write = fwrite($final, $buff);

                        fclose($final);
    
                        unlink($chunkPath);

                    }

                }
    
                CaseTemporaryFile::create([
        
                    'user_id' => Auth::user()->id,
    
                    'event_id' => $event->id,
    
                    'folder' => $folder,
    
                    'filename' => $filename
    
                ]);

            }

        } catch (Exception $error) {

            array_map('unlink', glob(public_path('file/event/temp/' . $folder . '/*.*')));

            rmdir(public_path('file/event/temp/' . $folder));

            return response($error, 500);

        }

        return $folder;

    }

    public function deleteEventFile(Request $request, Event $event) {

        $foldername = $request->foldername;

        array_map('unlink', glob(public_path('file/event/temp/' . $foldername . '/*.*')));

        rmdir(public_path('file/event/temp/' . $foldername));     
        
        CaseTemporaryFile::where('folder', $foldername)->delete();

        return $foldername;

    }
}
