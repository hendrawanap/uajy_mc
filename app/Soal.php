<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $fillable = [
        'kuis_id','no','name','a','b','c','d','jawaban','foto','isPilihan'
    ];

    public function kuis() {
        return $this->belongsTo(Kuis::class);
    }

    public function getFoto() {
        if($this->foto == NULL) {
            return 'https://via.placeholder.com/800x300';
        } else {
            return '/file/img-soal/'.$this->foto;
        }
    }

    public function getfotoKuis() {
        if($this->foto == NULL) {
            return false;
        } else {
            return '/file/img-soal/'.$this->foto;
        }
    }

}
