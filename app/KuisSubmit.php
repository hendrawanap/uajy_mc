<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KuisSubmit extends Model
{
    protected $fillable = [
        'set_kuis_id','user_id','status'
    ];

    public function set_kuis() {
        return $this->belongsTo(SetKuis::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function akses_kuis() {
        return $this->hasMany(AksesKuis::class);
    }

    public function temporary_file() {
        return $this->hasMany(TemporaryFile::class);
    } 
    
}
