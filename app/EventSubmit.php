<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventSubmit extends Model
{
    protected $fillable = [
        'event_id','file','user_id','read_admin'
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getFile() {
        return '/file/event/'.$this->file;
    }

}
