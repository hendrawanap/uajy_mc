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
        $CASE_SUBMISSIONS_URL = config('app.case_submissions_url');
        return $CASE_SUBMISSIONS_URL.'/'.$this->file;
    }


    public function getFiles() {

        $files = array();
        $files_location = array();

        foreach ($this->user->event_submit as $event) {
            if ($event->event_id == $this->event->id) {
                array_push($files, $event->file);
            }
        }

        foreach ($files as $file) {
            array_push($files_location, '/file/event/' . $file);
        }

        return $files_location;

    }

}
