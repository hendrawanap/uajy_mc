<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AksesKuis extends Model
{
    protected $fillable = [
        'set_kuis_id','kuis_id','user_id','soal_id','jawaban','type','isRagu','user_id','nilai','isTrue','isFalse','isRagu','isCheck'
    ];

    public function soal() {
        return $this->belongsTo(Soal::class);
    }

    public function set_kuis() {
        return $this->belongsTo(SetKuis::class);
    }

    public function getJawaban() {
        if($this->type == 0) {
            return '/file/jawaban/'.$this->jawaban;
        }
    }
}
