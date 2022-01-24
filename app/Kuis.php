<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    protected $fillable = [
        'name','soal_value'
    ];

    public function soal() {
        return $this->hasMany(Soal::class);
    }

    public function set_kuis() {
        return $this->hasOne(SetKuis::class);
    }

    public function akses_kuis() {
        return $this->hasMany(AksesKuis::class);
    }

    public function temporary_file() {
        return $this->hasMany(TemporaryFile::class);
    } 

    public function kuis_submit() {
        return $this->hasMany(KuisSubmit::class);
    }
}
