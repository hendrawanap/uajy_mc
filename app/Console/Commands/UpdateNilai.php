<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AksesKuis;
use App\KuisSubmit;

class UpdateNilai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cek:nilai';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fungsi untuk menghitung nilai';

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
      foreach(AksesKuis::where('isCheck',0)->get() as $key => $value) {
          $kuis_submit = KuisSubmit::where('user_id',$value->user_id)->where('set_kuis_id',$value->set_kuis_id)->first();
          if($value->isTrue == 1) {
            $kuis_submit->nilai = $kuis_submit->nilai+$value->kuis->soal_value;    
          }
          $value->isCheck = 1;
          $value->save();
          $kuis_submit->save();
      }
    }
}
