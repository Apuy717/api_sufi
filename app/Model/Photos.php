<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    protected $table = "photos";
    protected $fillable = ['id_gallery', 'photos'];
}
