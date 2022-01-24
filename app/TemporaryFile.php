<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemporaryFile extends Model
{
    
    protected $fillable = ['set_kuis_id','kuis_id','user_id','soal_id','folder','filename'];

    public function soal() {
        return $this->belongsTo(Soal::class);
    }

    public function set_kuis() {
        return $this->belongsTo(SetKuis::class);
    }

}
