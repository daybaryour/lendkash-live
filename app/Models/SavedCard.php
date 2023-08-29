<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedCard extends Model
{
    protected $table = 'saved_cards';
    protected $fillable = [
        'user_id', 'expiry_month', 'expiry_year','card_bin','last_four_digits','brand','issuing_country','type','card_tokens','embed_token','log'
    ];


}
