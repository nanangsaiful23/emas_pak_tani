<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cokim extends Model
{    
    use SoftDeletes;
    
    protected $fillable = [
        'weight', 'status', 'production_price', 'selling_price'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $dates =[
        'deleted_at',
    ];

    public function getRealStatus()
    {
        if($this->status == 'ongoing')
        {
            return 'Proses lebur';
        }
        elseif($this->status == 'sell')
        {
            return 'Selesai dilebur';
        }
        elseif($this->status == 'sold')
        {
            return 'Telah dijual';
        }
        elseif($this->status == 'new gold from cokim')
        {
            return 'Emas baru dari cokim';
        }
    }
}
