<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected  $table = 'content';
    protected $fillable = ['title', 'file', 'article'];
}
