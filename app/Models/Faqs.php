<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faqs extends Model
{
    protected $table = 'manage_faqs';

    protected $fillable = [
        'id', 'question', 'answer'
    ];

}
