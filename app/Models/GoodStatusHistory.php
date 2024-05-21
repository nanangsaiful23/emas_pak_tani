<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodStatusHistory extends Model
{    
    use SoftDeletes;
    
    protected $fillable = [
        'good_id', 'old_status', 'new_status', 'old_weight', 'new_weight'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $dates =[
        'deleted_at',
    ];

    public function good()
    {
        return $this->belongsTo('App\Models\Good');
    }
}
