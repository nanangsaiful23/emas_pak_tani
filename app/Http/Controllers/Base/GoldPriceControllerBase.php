<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;

use App\Models\GoldPrice;

trait GoldPriceControllerBase 
{
    public function indexGoldPriceBase($pagination)
    {
        if($pagination == 'all')
           $gold_prices = GoldPrice::orderBy('created_at', 'desc')->get();
        else
           $gold_prices = GoldPrice::orderBy('created_at', 'desc')->paginate($pagination);

        return $gold_prices;
    }

    public function storeGoldPriceBase(Request $request)
    {
        $request->price = unformatNumber($request->price);
        $this->validate($request, [
            'price' => array('required', 'regex:/^[\d\s,]*$/'),
        ]);
        // $data = $request->input();
        $data['weight'] = 1;
        $data['price'] = unformatNumber($request->price);
        $data['percentage'] = 24;

        $gold_price = GoldPrice::create($data);

        return $gold_price;
    }

    public function deleteGoldPriceBase($gold_price_id)
    {
        $gold_price = GoldPrice::find($gold_price_id);
        $gold_price->delete();
    }
}
