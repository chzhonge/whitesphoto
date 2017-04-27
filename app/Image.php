<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use SoftDeletes;
    protected $table = 'image';
    public $timestamps = true;


    /**
     * 需要被轉換成日期的屬性。
     *
     * @var array
     */

    protected $fillable = ['title', 'author', 'desc','projectID'];
    protected $dates = ['deleted_at'];
}
