<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    //
    protected $primaryKey = 'doc_id';

    protected $fillable = [
        'doc_programid',
        'doc_content',
    ];

    protected $hidden = [

    ];
}
