<?php



namespace App\Http\Controllers;



use App\Kuis;

use App\Soal;

use App\SetKuis;

use App\AksesKuis;

use App\QuizTemporaryFile;

use App\KuisSubmit;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use File;

use DataTables;

use Auth;

use Session;

use DB;

use Carbon\Carbon;
use DirectoryIterator;

class KuisController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        return view('admin.kuis.index');

    }



    public function json()

    {

        $data = Kuis::all();

        return DataTables::of($data)->addColumn('action', function ($data) {

        return '

        <a href="javascript:;" onclick="form(\''.route('kuis.show',$data->id).'\')" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>

        <a href="javascript:;" onclick="form(\''.route('kuis.edit',$data->id).'\')" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>

        <a href="'.route('kuis.delete',$data->id).'" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>';

        })->make(true); 

    }



     /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */



    public function create() {

        return view('admin.kuis.create');

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

            'soal_value' => 'required|numeric'

        ]);

        Kuis::create($request->all());

        return redirect()->route('kuis.index')->with('success','Berhasil Tambah Data');

    }



    /**

     * Display the specified resource.

     *

     * @param  \App\Kuis  $Kuis

     * @return \Illuminate\Http\Response

     */

    public function show(Kuis $kuis)

    {

        $data = $kuis;

        return view('admin.kuis.show',compact('data'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Kuis  $Kuis

     * @return \Illuminate\Http\Response

     */

    public function edit(Kuis $kuis)

    {

        $data = $kuis;

        return view('admin.kuis.edit',compact('data'));

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Kuis  $Kuis

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Kuis $kuis)

    {

        $kuis->update($request->all());

        return redirect()->route('kuis.index')->with('success','Berhasil Update Data');

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Kuis  $Kuis

     * @return \Illuminate\Http\Response

     */

    public function destroy(Kuis $kuis)

    {

        DB::beginTransaction();

        try {

            if($kuis->soal()->exists()) $kuis->soal()->delete();

            if($kuis->set_kuis()->exists()) {

                if($kuis->set_kuis->akses_kuis()->exists()) $kuis->set_kuis->akses_kuis()->delete();

                if($kuis->set_kuis->kuis_submit()->exists()) $kuis->set_kuis->kuis_submit()->delete();

                $kuis->set_kuis()->delete();

            }

            

            $kuis->delete();

            DB::commit();

            return redirect()->route('kuis.index')->with('success','Berhasil Hapus Data');

        } catch(Exception $e) {

            DB::rollback();

            // dd($e);

            return redirect()->back()->with('error', 'Gagal !, kesalahan tidak terduga.');

        }

        $kuis->delete();

    }



    public function kuisSoal(Kuis $kuis) {

        return view('admin.soal.index',compact('kuis'));

    }



    public function kuisSoalAction(Request $request,Kuis $kuis) {

        $no = Soal::where('kuis_id',$kuis->id)->count()+1;

        $file = $request->file('foto');

  

        if($request->isPilihan == 1) {

            $data = [

                'kuis_id' => $kuis->id,

                'name' => $request->name,

                'a' => $request->a,

                'b' => $request->b,

                'c' => $request->c,

                'd' => $request->d,

                'isPilihan' => 1,

                'jawaban' => $request->jawaban,

                'no' => $no,

            ];

           

        } else {

            $data = [

                'kuis_id' => $kuis->id,

                'name' => $request->name,

                'no' => $no

            ];

        }



        if($request->file('foto') == TRUE) {

            $file_name = time().$file->getClientOriginalName();

            $data['foto'] = $file_name;

            $file->move(public_path('/file/img-soal'),$file_name);

        }

        $soal = Soal::create($data);



        return redirect()->route('kuis.soal',$kuis->id)->with('success','Berhasil Menambahkan Data #'.$soal->id);

        

    }



    public function soal_json(Kuis $kuis) {

        $data = Soal::where('kuis_id',$kuis->id)->get();

        return DataTables::of($data)

        ->addColumn('action', function ($data) {

        return '

        <a href="'.route('soal.edit',$data->id).'"  class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>

        <a href="'.route('soal.delete',$data->id).'" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>';

        })

        ->addColumn('soal', function ($data) {

            return $data->name;

        })

        ->rawColumns(['action','soal'])

        ->make(true); 

    }



    public function soalShow(Soal $soal) {

        return view('admin.soal.show',compact('soal'));

    }



    public function soalEdit(Soal $soal) {

        return view('admin.soal.edit',compact('soal'));

    }



    public function soalUpdate(Request $request,Soal $soal) {

        // dd($request);

        $file = $request->file('foto');

        

        if($request->isPilihan == 1){

            $data = [

                'kuis_id' => $soal->kuis->id,

                'name' => $request->name,

                'a' => $request->a,

                'b' => $request->b,

                'c' => $request->c,

                'd' => $request->d,

                'jawaban' => $request->jawaban,

                'isPilihan' => 1

            ];

        } else {

            $data = [

                'kuis_id' => $soal->kuis->id,

                'name' => $request->name,

                'a' => '',

                'b' => '',

                'c' => '',

                'd' => '',

                'isPilihan' => 0

            ];

        }

        if($request->file('foto') == TRUE) {

            $nama_foto = time().$file->getClientOriginalName();

            $data['foto'] = $nama_foto;

            $file->move(public_path('/file/img-soal'),$nama_foto);

        }

        $soal->update($data);



        return redirect()->route('kuis.soal',$soal->kuis->id)->with('success','Berhasil simpan data');

    }





    public function soalDelete(Soal $soal) {

        $soal->delete();

        return redirect()->back()->with('success','Berhasil Delete Data');

    }



    public function setKuis(Kuis $kuis) {

        return view('admin.set-kuis.index',compact('kuis'));

    }



    public function setKuisAction(Request $request,Kuis $kuis) {

        SetKuis::create([

            'kuis_id' => $kuis->id,

            'tanggal_mulai' => $request->tanggal.' '.$request->waktu,

            'durasi' => $request->durasi

        ]);

        return redirect()->back()->with('success','Berhasil !');

    }



    public function setKuisEdit(SetKuis $setkuis) {

        return view('admin.set-kuis.edit',compact('setkuis'));

    }



    public function setKuisUpdate(SetKuis $setkuis,Request $request) {

        $setkuis->update([

            'tanggal_mulai' => $request->tanggal.' '.$request->waktu,

            'durasi' => $request->durasi

        ]);

        return redirect()->back()->with('success','Berhasil !');

    }



    public function setKuisDelete(SetKuis $setkuis) {

        $setkuis->delete();

        return redirect()->back()->with('success','Berhasil !');

    }



    public function setKuisJson(Kuis $kuis) {

        $data = $kuis->set_kuis()->with('kuis')->get();

        return DataTables::of($data)->addColumn('action', function ($data) {

        return '

        <a href="'.route('jadwal.edit',$data->id).'"  class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>

        <a href="'.route('jadwal.delete',$data->id).'" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>';

        })->make(true); 

    }



    public function cek_akses_set_kuis(Kuis $kuis) {

        // dd($kuis);

        return view('admin.akses-kuis.index',compact('kuis'));

    }



    public function cek_akses_set_kuis_json(Kuis $kuis) {

        $data = $kuis->set_kuis()->get();

        return DataTables::of($data)

        ->addColumn('tanggal', function ($data) {

            return $data->getTanggalMulai();

        })

        ->addColumn('kuis_name', function ($data) {

            return $data->kuis->name;

        })

        ->addColumn('action', function ($data) {

        return '

        <a href="'.route('kuis.akses_peserta_kuis',$data->id).'"  class="btn btn-sm btn-success"><i class="fa fa-fw mr-2 fa-sign-in"></i>Akses ( '.$data->kuis_submit()->count().' )</a>';

        })->make(true); 

    }



    public function cek_akses_peserta_kuis(SetKuis $setkuis) {

        return view('admin.akses-kuis.peserta',compact('setkuis'));

    }



    public function cek_akses_peserta_kuis_json(SetKuis $setkuis) {

        $data = $setkuis->kuis_submit()->with('user')->get();

        // dd($data);

        return DataTables::of($data)

        ->addColumn('action', function ($data) {

        return '

        <a href="'.route('kuis.cek_akses_jawaban_kuis',$data->id).'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Periksa Kuis</a>';

        })

        ->addColumn('users', function ($data) {

            return '<img class="rounded-circle" alt="image" width="50" src="/template/images/avatar/1.png">';

        })

        ->rawColumns(['users','action'])

        ->make(true); 

    }



    public function cek_akses_jawaban_kuis(KuisSubmit $kuis_submit) {

        $quetions = AksesKuis::where('user_id',$kuis_submit->user->id)->where('set_kuis_id',$kuis_submit->set_kuis_id)->get();
        
        $data = [];

        foreach ($quetions as $quetion) {

            if(!isset($data[$quetion->soal->no])) {

                $data[$quetion->soal->no] = array(); 
                
            }
            
            array_push($data[$quetion->soal->no], $quetion);

        }

        return view('admin.akses-kuis.submit',compact('kuis_submit'))->with('questions',$data);

    }



    public function update_nilai_kuis(Request $request ,KuisSubmit $kuis_submit) {

        // dd($request->all());

        $kuis_submit->nilai = $request->nilai;

        $kuis_submit->save();

        return redirect()->route('kuis.akses_peserta_kuis',$kuis_submit->set_kuis_id)->with('success','Berhasil !');

    }



   



    // PESERTA AREA 



    public function history_nilai() {

        return view('kuis.nilai');

    }



    public function history_nilai_json() {

        $data = KuisSubmit::where('user_id',Auth::user()->id)->whereNotNull('nilai')->with(['user','set_kuis'])->get();

        return DataTables::of($data)->addColumn('kuis_name',function($data) {

            return $data->set_kuis->kuis->name;

        })->make(true); 

    }



    public function aksesKuis() {

        return view('kuis.index');

    }



    public function showAksesKuis(SetKuis $setkuis) {

        // dd($setk)

        $temporaryFiles = QuizTemporaryFile::where('set_kuis_id', $setkuis->id)->where('user_id', Auth::user()->id)->get();

        if($temporaryFiles->count() > 0) {

            foreach ($temporaryFiles as $temporaryFile) {

                $temporaryFile->delete();

                array_map('unlink', glob(public_path('file/jawaban/temp/' . $temporaryFile->folder . '/*.*')));

                rmdir(public_path('file/jawaban/temp/' . $temporaryFile->folder));

            }

        }


        if(Carbon::parse($setkuis->getTanggalMulai())->addMinutes($setkuis->durasi)->format('Y-m-d H:i:s') < date('Y-m-d H:i:s')) {

            return redirect()->route('kuis.jawab.list')->with('error','ujian telah berakhir');

            exit;

        }

        // dd(AksesKuis::where('user_id',Auth::user()->id)->where('set_kuis_id',$setkuis->id)->count());

        if(AksesKuis::where('user_id',Auth::user()->id)->where('set_kuis_id',$setkuis->id)->count() < 1) {

            DB::beginTransaction();

            try {

                    foreach($setkuis->kuis->soal()->get() as $data) {

                        AksesKuis::create([

                            'user_id' => Auth::user()->id,

                            'kuis_id' => $data->kuis_id,

                            'set_kuis_id' => $setkuis->id,

                            'soal_id' => $data->id,

                            'type' => $data->isPilihan // 0 = essai , 1 = pilihan ganda

                        ]);

                    }

                    KuisSubmit::create([

                        'user_id' => Auth::user()->id,

                        'set_kuis_id' => $setkuis->id

                    ]);

                DB::commit();

            } catch(Exception $e) {

                DB::rollback();

                // dd($e);

                return redirect()->back()->with('error', 'Gagal !, kesalahan tidak terduga.');

            }

        }

        return view('kuis.show',compact('setkuis'));

       

    }

    public function ajaxAksesKuis(Request $request,$type) {

        // dd($request->all());

        if($type == "no-soal") {

            $data = AksesKuis::where('user_id',Auth::user()->id)->where('set_kuis_id',$request->setkuis)->get();

            // dd($data);

            return view('kuis.ajax.panel',compact('data'));

        } else if($type == "ragu" ) {

            if(AksesKuis::findOrFail($request->id)->isRagu == 0)

            { 

                AksesKuis::findOrFail($request->id)->update([

                    'isRagu' => 1

                ]);

            } else {

                AksesKuis::findOrFail($request->id)->update([

                    'isRagu' => 0

                ]);

            }

            return 'ok ragu';

        } else if($type == "jawab" ) {

            AksesKuis::findOrFail($request->id)->update([

                'jawaban' => $request->jawaban

            ]);

            return 'ok jawab';

        } else if($type == "upload" ) {

            print_r($request->file('file'));

            return 'ok aplod';

        }

    }

    public function uploadAksesKuisFile(Request $request, SetKuis $setkuis, $id) {

        if ($request->input('useChunk')) {

            $folder = $id.$setkuis->id.Auth::user()->id.'-'.uniqid().'-'.now()->timestamp;

            return $folder;

        } else {

            if ($request->hasFile('jawaban')) {
                
                $files = $request->file('jawaban');
                
                foreach ($files as $file) {
                    
                    $filename = Auth::user()->name.'-'.$setkuis->kuis->name.'-'.uniqid().'.'.$file->extension();
    
                    $folder = $id.$setkuis->id.Auth::user()->id.'-'.uniqid().'-'.now()->timestamp;
    
                    $file->move('file/jawaban/temp/' . $folder, $filename);
    
                    $akseskuis = AksesKuis::findOrFail($id);
    
                    QuizTemporaryFile::create([
    
                        'user_id' => Auth::user()->id,
    
                        'kuis_id' => $akseskuis->soal->kuis_id,
    
                        'set_kuis_id' => $setkuis->id,
    
                        'soal_id' => $akseskuis->soal->id,
    
                        'folder' => $folder,
    
                        'filename' => $filename
    
                    ]);
    
                    return $folder;
    
                }
    
            }

        }

        return '';

    }

    public function patchAksesKuisFile(Request $request, SetKuis $setkuis, $id) {
        $loaded = $request->input('loaded');
        $chunkSize = $request->input('chunkSize');
        $fileSize = $request->input('fileSize');
        
        $chunk = $request->file('filedata');

        $chunkName = $chunk->getClientOriginalName().'.'.$chunk->extension();
        
        $folder = $request->input('folder');
        
        $chunk->move('file/jawaban/temp/' . $folder, $chunkName);
        
        if ($loaded + $chunkSize > $fileSize) {
            $dir = new DirectoryIterator(public_path('file/jawaban/temp/'.$folder));
            $filename = '';
            $extension = '';
            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot()) {
                    if (pathinfo($fileinfo, PATHINFO_EXTENSION) != 'bin') {
                        $extension = pathinfo($fileinfo, PATHINFO_EXTENSION);
                    }
                    $chunkPath = public_path('file/jawaban/temp/'.$folder.'/'.$fileinfo->getFileName());
                    $file = fopen($chunkPath, 'rb');
                    $buff = fread($file, $chunkSize);
                    fclose($file);
                    
                    $filename = Auth::user()->name.'-'.$setkuis->kuis->name.'-'.explode('-', $folder)[1].'.'.$extension;
                    $filePath = public_path('file/jawaban/temp/'.$folder.'/'.$filename);
                    $final = fopen($filePath,'ab');
                    $write = fwrite($final, $buff);
                    fclose($final);

                    unlink($chunkPath);
                }
            }

            $akseskuis = AksesKuis::findOrFail($id);
    
            QuizTemporaryFile::create([

                'user_id' => Auth::user()->id,

                'kuis_id' => $akseskuis->soal->kuis_id,

                'set_kuis_id' => $setkuis->id,

                'soal_id' => $akseskuis->soal->id,

                'folder' => $folder,

                'filename' => $filename

            ]);
        }

        return $folder;
    }

    public function deleteAksesKuisFile(Request $request, SetKuis $setkuis, $id) {

        $foldername = $request->foldername;

        array_map('unlink', glob(public_path('file/jawaban/temp/' . $foldername . '/*.*')));

        rmdir(public_path('file/jawaban/temp/' . $foldername));     
        
        QuizTemporaryFile::where('folder', $foldername)->delete();

        return $foldername;

    }

    public function jawabAksesKuis(Request $request,SetKuis $setkuis) {

        // $request->validate([

        //     'jawaban' => 'required|array'

        // ]);

        $jawaban = $request->postData['jawaban'];

        $total_nilai_pilgan = 0;

        $nilai_per_soal = $setkuis->kuis->soal_value;

        

        // cek jawaban ragu ragu

        if(AksesKuis::where('set_kuis_id',$setkuis->id)->where('isRagu',1)->where('user_id',Auth::user()->id)->count() > 0) {

            if(Carbon::parse($setkuis->tanggal_mulai)->addMinutes($setkuis->durasi)->format('Y-m-d H:i:s') > date('Y-m-d H:i:s')) {

                return redirect()->back()->with('error','Masih ada yang ragu ragu !');

                exit;

            }

        }

        // cek file essay

        if(AksesKuis::where('set_kuis_id',$setkuis->id)->where('jawaban','0')->where('user_id',Auth::user()->id)->count() > 0) {

            return redirect()->back()->with('error','Ada Kesalahan ! Silahkan Masukkan Ulang File Essay');

            exit;

        }

        DB::beginTransaction();

        try {

            foreach($jawaban as $key => $value) {

                $data = AksesKuis::where('id',$key)->where('user_id',Auth::user()->id)->first();
                
                if($request->postData['isian'][$key] == 1) {

                    // $file_name = $key.$value->getClientOriginalName();

                    // $data->update([

                    //     'jawaban' => $file_name,

                    //     'isRagu' => 0,

                    //     'isCheck' => 1

                    // ]);

                    // $value->move('file/jawaban',$file_name);

                    $temporaryFiles = array();

                    foreach ($request->fileUploads[$key] as $foldername) {

                        array_push($temporaryFiles, QuizTemporaryFile::where('folder', $foldername)->where('set_kuis_id', $setkuis->id)->where('user_id', Auth::user()->id)->first());

                    }

                    if (count($temporaryFiles) > 0) {

                        foreach ($temporaryFiles as $index => $temporaryFile) {
                            
                            if ($index == 0) {

                                $data->update([

                                    'jawaban' => $temporaryFile->filename,

                                    'isRagu' => 0,

                                    'isCheck' => 1,

                                ]);

                            } else {

                                $aksesKuis = AksesKuis::create([

                                    'user_id' => Auth::user()->id,

                                    'kuis_id' => $temporaryFile->kuis_id,

                                    'set_kuis_id' => $temporaryFile->set_kuis_id,

                                    'soal_id' => $temporaryFile->soal_id,

                                    'type' => 0, // 0 = essai , 1 = pilihan ganda

                                    'jawaban' => $temporaryFile->filename,

                                    'isRagu' => 0,

                                    'isCheck' => 1,

                                ]);

                            }

                            


                            File::move(public_path('file\\jawaban\\temp\\' . $temporaryFile->folder . '\\' . $temporaryFile->filename) , public_path('file\\jawaban\\' . $temporaryFile->filename));
                            
                            $temporaryFile->delete();
                            
                            rmdir(public_path('file\\jawaban\\temp\\' . $temporaryFile->folder));

                        }

                    }

                } else {

                    // cek otomatis jawaban pilgan

                    $update_data = 

                    [

                        'jawaban' => $value,

                        'isRagu' => 0,

                        'isCheck' => 1

                    ];

                    if($value == $data->soal->jawaban) {

                        $total_nilai_pilgan+=$nilai_per_soal;

                        $update_data['isTrue'] = 1;

                    } else {

                        $update_data['isFalse'] = 1;

                    }

                    $data->update($update_data);

                }

               

            }

            KuisSubmit::where('set_kuis_id',$setkuis->id)->where('user_id',Auth::user()->id)->where('status',0)->update([

                'status' => 1,

                'nilai' => $total_nilai_pilgan

            ]);



        DB::commit();

            // return redirect()->route('kuis.jawab.list')->with('success','Berhasil Submit Jawaban');

            Session::flash('success', 'Berhasil Submit Jawaban');

            return 'Berhasil Submit Jawaban';

        } catch(Exception $e) {

            DB::rollback();

            dd($e);

            // return redirect()->back()->with('error', 'Gagal memproses data, kesalahan tidak terduga.');

        }

    }





    

}

