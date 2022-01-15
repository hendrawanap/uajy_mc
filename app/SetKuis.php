<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SetKuis extends Model
{
    protected $fillable = [
        'kuis_id','tanggal_mulai','durasi'
    ];

    public function kuis() {
        return $this->belongsTo(Kuis::class);
    }    

    public function akses_kuis() {
        return $this->hasMany(AksesKuis::class);
    } 

    public function getTanggalMulai() {
        return str_replace('T',' ',$this->tanggal_mulai);
    }

    public function kuis_submit() {
        return $this->hasMany(KuisSubmit::class);
    }

    

}
