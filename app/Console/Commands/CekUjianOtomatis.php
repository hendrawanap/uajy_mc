<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AksesKuis;
use App\KuisSubmit;

class CekUjianOtomatis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cek:ujian';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fungsi untuk mengecek ujian yang expired ketika member tiba2 bermasalah koneksi';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $data = AksesKuis::all();
       $total_nilai_pilgan = 0;
       
       $data_nilai = [];
        foreach($data as $key => $value) {
            if(\Carbon\Carbon::parse($value->set_kuis->tanggal_mulai)->addMinutes($value->set_kuis->durasi)->format('Y-m-d H:i:s') < date('Y-m-d H:i:s'))
            {
               
                if($value->type == 1) { 
                    if($value->jawaban == $value->soal->jawaban) {
                        $value->update([
                            'isTrue' => 1
                        ]);

                        
                    } else {
                        $value->update([
                            'isFalse' => 1
                        ]);
                        
                    }
                }
                if($value->isRagu == 1) {
                    AksesKuis::find($value->id)->update([
                        'isRagu' => 0
                    ]);
                }
            }
            KuisSubmit::where('user_id',$value->user_id)->where('set_kuis_id',$value->set_kuis_id)->update([
                    'status' => 1
                ]);
        }
        
        
        
         
  
    }
}
