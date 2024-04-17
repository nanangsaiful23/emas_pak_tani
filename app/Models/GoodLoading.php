<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use App\Admin;
use App\Cashier;

class GoodLoading extends Model
{    
    use SoftDeletes;
    
    protected $fillable = [
        'role', 'role_id', 'checker', 'loading_date', 'distributor_id', 'total_item_price', 'note', 'payment', 'type'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $dates =[
        'deleted_at',
    ];

    public function distributor()
    {
        return $this->belongsTo('App\Models\Distributor');
    }
    
    public function details()
    {
        return $this->hasMany('App\Models\GoodLoadingDetail');
    }

    public function detailsWithDeleted()
    {
        $details = $this->details;

        foreach($details as $detail)
        {
            $detail->good_unit = GoodUnit::withTrashed()->where('id', $detail->good_unit_id)->get();
            $detail->good = Good::withTrashed()->where('id', $detail->good_unit[0]->good_id)->get();
            $detail->good_unit = $detail->good_unit[0];
            $detail->good = $detail->good[0];
        }

        return $details;
    }

    public function actor()
    {
        if($this->role == 'admin')
            return Admin::find($this->role_id);
        else
            return Cashier::find($this->role_id);
    }

    public function getTotalEmas()
    {
        $sum = GoodLoadingDetail::select(DB::raw('SUM(goods.weight) as total_weight'))
                                ->join('good_units', 'good_units.id', 'good_loading_details.good_unit_id')
                                ->join('goods', 'goods.id', 'good_units.good_id')
                                ->where('good_loading_details.good_loading_id', $this->id)
                                ->get();

        return $sum[0];
    }
}
