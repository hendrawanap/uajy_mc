<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseTemporaryFile extends Model
{

    protected $fillable = ['event_id','user_id','folder','filename'];

}
