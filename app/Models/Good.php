<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\GoodLoadingDetail;
use App\Models\GoodUnit;

class Good extends Model
{    
    use SoftDeletes;
    
    protected $fillable = [
        'category_id', 'brand_id', 'is_old_gold', 'code', 'name', 'percentage_id', 'weight', 'status', 'gold_history_number', 'description', 'stone_weight', 'stone_price', 'change_status_fee', 'last_distributor_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $dates =[
        'deleted_at',
    ];
    
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }
    
    public function percentage()
    {
        return $this->belongsTo('App\Models\Percentage');
    }
    
    public function good_units()
    {
        return $this->hasMany('App\Models\GoodUnit');
    }
    
    public function good_photos()
    {
        return $this->hasMany('App\Models\GoodPhoto');
    }

    public function profilePicture()
    {
        return GoodPhoto::where('good_id', $this->id)
                        ->where('is_profile_picture', 1)
                        ->first();
    }

    public function good_loadings()
    {
        return GoodLoadingDetail::join('good_units', 'good_units.id', 'good_loading_details.good_unit_id')
                                ->join('good_loadings', 'good_loadings.id', 'good_loading_details.good_loading_id')
                                ->where('good_units.good_id', $this->id)
                                ->where('good_loadings.deleted_at', null)
                                ->get();
    }
    
    public function good_transactions()
    {
        return TransactionDetail::join('good_units', 'good_units.id', 'transaction_details.good_unit_id')
                                ->join('transactions', 'transactions.id', 'transaction_details.transaction_id')
                                ->where('good_units.good_id', $this->id)
                                ->where('transaction_details.type', '!=', 'retur')
                                ->where('transactions.deleted_at', null)
                                ->get();
    }

    public function getPcsSellingPrice()
    {
        $good_unit = GoodUnit::join('units', 'good_units.unit_id', 'units.id')
                       ->select('good_units.*', 'units.*', 'good_units.id as id')
                       ->where('units.quantity', '1')
                       ->where('good_units.good_id', $this->id)
                       ->first();

        if($good_unit == null)
        {
            $good_unit = GoodUnit::join('units', 'good_units.unit_id', 'units.id')
                       ->select('good_units.*', 'units.*', 'good_units.id as id')
                       ->where('good_units.good_id', $this->id)
                       ->orderByRaw('CONVERT(units.quantity, INT) asc')
                       ->first();
        }

        return $good_unit;
    }

    public function getLastBuy()
    {
        return GoodLoadingDetail::join('good_units', 'good_units.id', 'good_loading_details.good_unit_id')
                                ->join('good_loadings', 'good_loadings.id', 'good_loading_details.good_loading_id')
                                ->where('good_units.good_id', $this->id)
                                ->where('good_loadings.deleted_at', null)
                                ->orderBy('good_loading_details.id', 'desc')
                                ->first();
    }

    public function getStock()
    {
        $loadings = $this->good_loadings()->sum('real_quantity');

        $transactions = $this->good_transactions()->sum('real_quantity');

        $total = $loadings - $transactions;

        return $total / $this->getPcsSellingPrice()->unit->quantity;
    }

    public function getBarcode()
    {
        $barcode = '0' . $this->category->id;
        if($this->category->id < 10) $barcode = '0' . $barcode;

        $id = $this->id;
        while($id < 1000)
        {
            $barcode .= '0';
            $id = $id * 10; 
        }
        $barcode .= $this->id;
        // dd($barcode);die;

        return $barcode;
    }

    // public function getCode()
}
