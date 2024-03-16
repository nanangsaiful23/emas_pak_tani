<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoldPrice extends Model
{    
    use SoftDeletes;
    
    protected $fillable = [
        'weight', 'buy_price', 'selling_price', 'percentage'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $dates =[
        'deleted_at',
    ];
}
