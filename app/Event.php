<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name','tanggal_mulai','tanggal_selesai','soal'
    ];

    public function event_submit() {
        return $this->hasMany(EventSubmit::class);
    }

    public function getTanggalMulai() {
        return str_replace('T',' ',$this->tanggal_mulai);
    }
    
    public function getTanggalSelesai() {
        return str_replace('T',' ',$this->tanggal_selesai);
    }
    public function submitCounts() {
        return $this->event_submit->unique('user_id')->count();
    }
}
