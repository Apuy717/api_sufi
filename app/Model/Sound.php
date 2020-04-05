<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sound extends Model
{
    protected $table = "sound";
    protected $fillable = ['title', 'photos', 'file'];
}
