<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use File;

use App\Models\Category;
use App\Models\Good;
use App\Models\GoodLoadingDetail;
use App\Models\GoodPhoto;
use App\Models\GoodPrice;
use App\Models\GoodUnit;
use App\Models\TransactionDetail;
use App\Models\Unit;

trait GoodControllerBase 
{
    public function indexGoodBase($category_id, $distributor_id, $status, $pagination)
    {
        if($pagination == 'all')
        {
            if($category_id == 'all' && $distributor_id == 'all')
            {
                if($status == 'all')
                    $goods = Good::orderBy('goods.id', 'desc')->where('goods.status', '!=', 'Lebur cokim')->get();
                else
                    $goods = Good::where('status', $status)->orderBy('goods.id', 'desc')->get();
            }
            elseif($category_id == 'all')
            {
                if($status == 'all')
                    $goods = Good::join('good_units', 'good_units.good_id', 'goods.id')
                                 ->join('good_loading_details', 'good_loading_details.good_unit_id', 'good_units.id')
                                 ->join('good_loadings', 'good_loadings.id', 'good_loading_details.good_loading_id')
                                 ->select('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->where('good_loadings.distributor_id', $distributor_id)
                                 ->where('goods.status', '!=', 'Proses lebur cokim')
                                 ->where('goods.status', '!=', 'Done lebur cokim')
                                 ->orderBy('goods.id', 'desc')
                                 ->groupBy('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->get();
                else
                    $goods = Good::join('good_units', 'good_units.good_id', 'goods.id')
                                 ->join('good_loading_details', 'good_loading_details.good_unit_id', 'good_units.id')
                                 ->join('good_loadings', 'good_loadings.id', 'good_loading_details.good_loading_id')
                                 ->select('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->where('good_loadings.distributor_id', $distributor_id)
                                 ->where('goods.status', $status)
                                 ->orderBy('goods.id', 'desc')
                                 ->groupBy('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->get();
            }
            elseif($distributor_id == 'all')
            {
                if($status == 'all')
                    $goods = Good::where('category_id', $category_id)
                                 ->where('goods.status', '!=', 'Proses lebur cokim')
                                 ->where('goods.status', '!=', 'Done lebur cokim')
                                 ->orderBy('goods.id', 'desc')
                                 ->get();     
                else 
                    $goods = Good::where('category_id', $category_id)
                                 ->where('goods.status', $status)
                                 ->orderBy('goods.id', 'desc')
                                 ->get(); 
            }
            else
            {
                if($status == 'all')
                    $goods = Good::join('good_units', 'good_units.good_id', 'goods.id')
                                 ->join('good_loading_details', 'good_loading_details.good_unit_id', 'good_units.id')
                                 ->join('good_loadings', 'good_loadings.id', 'good_loading_details.good_loading_id')
                                 ->select('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->where('good_loadings.distributor_id', $distributor_id)
                                 ->where('goods.category_id', $category_id)
                                 ->where('goods.status', '!=', 'Proses lebur cokim')
                                 ->where('goods.status', '!=', 'Done lebur cokim')
                                 ->orderBy('goods.id', 'desc')
                                 ->groupBy('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->get();
                else
                    $goods = Good::join('good_units', 'good_units.good_id', 'goods.id')
                                 ->join('good_loading_details', 'good_loading_details.good_unit_id', 'good_units.id')
                                 ->join('good_loadings', 'good_loadings.id', 'good_loading_details.good_loading_id')
                                 ->select('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->where('good_loadings.distributor_id', $distributor_id)
                                 ->where('goods.category_id', $category_id)
                                 ->where('goods.status', $status)
                                 ->orderBy('goods.id', 'desc')
                                 ->groupBy('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->get();
            }
        }
        else
        {
            if($category_id == 'all' && $distributor_id == 'all')
            {
                if($status == 'all')
                    $goods = Good::orderBy('goods.id', 'desc')->where('goods.status', '!=', 'Lebur cokim')->paginate($pagination);
                else
                    $goods = Good::where('status', $status)->orderBy('goods.id', 'desc')->paginate($pagination);
            }
            elseif($category_id == 'all')
            {
                if($status == 'all')
                    $goods = Good::join('good_units', 'good_units.good_id', 'goods.id')
                                 ->join('good_loading_details', 'good_loading_details.good_unit_id', 'good_units.id')
                                 ->join('good_loadings', 'good_loadings.id', 'good_loading_details.good_loading_id')
                                 ->select('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->where('good_loadings.distributor_id', $distributor_id)
                                 ->where('goods.status', '!=', 'Proses lebur cokim')
                                 ->where('goods.status', '!=', 'Done lebur cokim')
                                 ->orderBy('goods.id', 'desc')
                                 ->groupBy('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->paginate($pagination);
                else
                    $goods = Good::join('good_units', 'good_units.good_id', 'goods.id')
                                 ->join('good_loading_details', 'good_loading_details.good_unit_id', 'good_units.id')
                                 ->join('good_loadings', 'good_loadings.id', 'good_loading_details.good_loading_id')
                                 ->select('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->where('good_loadings.distributor_id', $distributor_id)
                                 ->where('goods.status', $status)
                                 ->orderBy('goods.id', 'desc')
                                 ->groupBy('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->paginate($pagination);
            }
            elseif($distributor_id == 'all')
            {
                if($status == 'all')
                    $goods = Good::where('category_id', $category_id)
                                 ->where('goods.status', '!=', 'Proses lebur cokim')
                                 ->where('goods.status', '!=', 'Done lebur cokim')
                                 ->orderBy('goods.id', 'desc')
                                 ->paginate($pagination);     
                else 
                    $goods = Good::where('category_id', $category_id)
                                 ->where('goods.status', $status)
                                 ->orderBy('goods.id', 'desc')
                                 ->paginate($pagination); 
            }
            else
            {
                if($status == 'all')
                    $goods = Good::join('good_units', 'good_units.good_id', 'goods.id')
                                 ->join('good_loading_details', 'good_loading_details.good_unit_id', 'good_units.id')
                                 ->join('good_loadings', 'good_loadings.id', 'good_loading_details.good_loading_id')
                                 ->select('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->where('good_loadings.distributor_id', $distributor_id)
                                 ->where('goods.category_id', $category_id)
                                 ->where('goods.status', '!=', 'Proses lebur cokim')
                                 ->where('goods.status', '!=', 'Done lebur cokim')
                                 ->orderBy('goods.id', 'desc')
                                 ->groupBy('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->paginate($pagination);
                else
                    $goods = Good::join('good_units', 'good_units.good_id', 'goods.id')
                                 ->join('good_loading_details', 'good_loading_details.good_unit_id', 'good_units.id')
                                 ->join('good_loadings', 'good_loadings.id', 'good_loading_details.good_loading_id')
                                 ->select('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->where('good_loadings.distributor_id', $distributor_id)
                                 ->where('goods.category_id', $category_id)
                                 ->where('goods.status', $status)
                                 ->orderBy('goods.id', 'desc')
                                 ->groupBy('goods.id', 'goods.name', 'goods.code', 'goods.category_id', 'goods.weight', 'goods.percentage', 'goods.status')
                                 ->paginate($pagination);
            }
        }

        return $goods;
    }

    public function searchByBarcodeGoodBase($barcode)
    {
        $good = Good::where('code', $barcode)->first();

        if($good == null) $good = Good::find(convertGoodBarcode($barcode));

        $good->getPcsSellingPrice = $good->getPcsSellingPrice();
        $good->stock = $good->getStock();
        $good->percentage = $good->percentage;

        return $good;
    }

    public function searchByIdGoodBase($good_id)
    {
        $good = Good::find($good_id);
        $good->getPcsSellingPrice = $good->getPcsSellingPrice();
        $good->stock = $good->getStock();

        $units = [];
        foreach($good->good_units as $unit)
        {
            $temp = [];
            $temp['good_id'] = $good->id;
            $temp['category_id'] = $good->category_id;
            $temp['is_old_gold'] = $good->is_old_gold;
            $temp['good_unit_id'] = $unit->id;
            $temp['unit_id'] = $unit->unit_id;
            $temp['code'] = $good->code;
            $temp['name'] = $good->name;
            $temp['percentage'] = $good->percentage;
            $temp['weight'] = $good->weight;
            $temp['status'] = $good->status;
            $temp['gold_history_number'] = $good->gold_history_number;
            $temp['stone_price'] = $good->stone_price;
            $temp['stone_weight'] = $good->stone_weight;
            array_push($units, $temp);
        }

        return $units;
    }

    public function searchByGoodUnitGoodBase($good_unit_id)
    {
        $good_unit = GoodUnit::find($good_unit_id);
        $good_unit->name = $good_unit->unit->name;

        $good = Good::find($good_unit->good_id);
        $good->getPcsSellingPrice = $good_unit;
        $good->stock = $good->getStock();
        $good->percentage = $good->percentage;

        return $good;
    }

    public function searchByKeywordGoodBase($query)
    {
        $goods = Good::where('code', 'like', '%'. $query . '%')
                     ->orWhere('name', 'like', '%'. $query . '%')
                     ->orWhere('id', convertGoodBarcode($query))
                     ->where('deleted_at', '=', null)
                     ->orderBy('name')
                     ->with('category')
                     // ->with('brand')
                     ->get();

        foreach($goods as $good)
        {
            $good->brand_name = $good->brand == null ? "" : $good->brand->name;
            $good->last_loading = $good->getLastBuy() == null ? "" : $good->getLastBuy()->good_loading->distributor->name . ' (' . $good->getLastBuy()->good_loading->note . ')';
            $good->stock = $good->getStock();
            $good->transaction = $good->good_transactions()->sum('real_quantity') / $good->getPcsSellingPrice()->unit->quantity;
            $good->loading = $good->good_loadings()->sum('real_quantity') / $good->getPcsSellingPrice()->unit->quantity;
            $good->unit = $good->getPcsSellingPrice() == null ? "" : $good->getPcsSellingPrice()->unit->code;

            foreach($good->good_units as $unit)
            {
                $unit->price = showRupiah(roundMoney($unit->selling_price));
                $unit->profit = showRupiah(roundMoney($unit->selling_price) - checkNull($unit->buy_price));
                $unit->percentage = calculateProfit(checkNull($unit->buy_price), roundMoney($unit->selling_price));
                $unit->unit_name = $unit->unit->name;
                $unit->unit_id = $unit->unit->id;
                $unit->buy_price = showRupiah(roundMoney(checkNull($unit->buy_price)));
            }
        }

        return $goods;
    }

    public function searchByKeywordGoodUnitGoodBase($query)
    {
        $goods = Good::where('code', 'like', '%'. $query . '%')
                     ->orWhere('name', 'like', '%'. $query . '%')
                     ->where('deleted_at', '=', null)
                     ->orderBy('name')
                     ->get();

        $units = [];
        foreach($goods as $good)
        {
            foreach($good->good_units as $unit)
            {
                $temp = [];
                $temp['good_id'] = $good->id;
                $temp['good_unit_id'] = $unit->id;
                $temp['unit_id'] = $unit->unit_id;
                $temp['code'] = $good->code;
                $temp['name'] = $good->name;
                $temp['percentage'] = $good->percentage;
                $temp['weight'] = $good->weight;
                $temp['unit'] = $unit->unit->name;
                $temp['buy_price'] = $unit->buy_price;
                $temp['selling_price'] = $unit->selling_price;
                array_push($units, $temp);
            }
        }

        return $units;
    }

    public function checkDiscountGoodBase($good_id, $quantity, $pcsPrice)
    {
        // $good_unit = GoodUnit::join('units', 'good_units.unit_id', 'units.id')
        //                      ->where('units.quantity', '<=', $quantity)
        //                      ->where('good_units.good_id', $good_id)
        //                      ->orderBy('units.quantity', 'desc')
        //                      ->first();

        // if($good_unit == null)
        // {
        //     return 0;
        // }
        // else
        // {
        //     if($good_unit->quantity != 1)
        //     {
        //         if($quantity < 1) $disc_quantity = 0;
        //         else $disc_quantity = intdiv($quantity, $good_unit->quantity);

        //         $real_quantity = fmod($quantity, $good_unit->quantity);
        //         // dd($disc_quantity . ' ' . $real_quantity);die;

        //         // return ($disc_quantity * (($pcsPrice * $good_unit->quantity) - $good_unit->selling_price)) + ($real_quantity * $pcsPrice);
        //         return $disc_quantity * (($pcsPrice * $good_unit->quantity) - $good_unit->selling_price);
        //     }
        //     else
        //     {
        //         return '0';
        //     }
        // }
        return '0';
    }

    public function getPriceUnitGoodBase($good_id, $unit_id)
    {
        $good_unit = GoodUnit::where('good_id', $good_id)->where('unit_id', $unit_id)->first();

        return $good_unit;
    }

    public function storeGoodBase(Request $request)
    {
        $this->validate($request, [
            'weight' => array('required', 'numeric'),
        ]);

        $data = $request->input();

        $data['unit_id'] = 1;
        $data['selling_price'] = 1;
        $data['price'] = unformatNumber($request->price);
        $data['stone_price'] = unformatNumber($request->stone_price);

        $good = Good::where('name', $data['name'])->first();

        if($good == null)
        {
            $good = Good::create($data);

            $category = Category::find($data['category_id']);

            $year = date('y');

            $barcode = '';
            $id = $good->id;
            while($id < 1000)
            {
                $barcode .= '0';
                $id = $id * 10; 
            }
            $barcode .= $good->id;

            $data_good['code'] = $category->code . ' ' . date('y') . ' ' . $barcode . ' ' . date('m') . ' ' . $request->gold_history_number;
            $good->update($data_good);
            $good->code = $data_good['code'];

            $data_unit['good_id']       = $good->id;
            $data_unit['unit_id']       = $data['unit_id'];
            $data_unit['buy_price']     = $data['price'];
            $data_unit['selling_price'] = $data['selling_price'];

            $good_unit = GoodUnit::create($data_unit);

            $data_price['role']         = $data['role'];
            $data_price['role_id']      = \Auth::user()->id;
            $data_price['good_unit_id'] = $good_unit->id;
            $data_price['old_price']    = $good_unit->selling_price;
            $data_price['recent_price'] = $data['selling_price'];
            $data_price['reason']       = 'Harga pertama';

            GoodPrice::create($data_price);

            $good->unit_id = $good_unit->unit_id;
            $good->unit    = $good_unit->unit->name . '(' . $good_unit->unit->code . ')';
            $good->price   = $data['price'];
            $good->selling_price   = $data['selling_price'];
        }
        else
        {
            return redirect()->to($this->getRedirectUrl())
                             ->withInput($request->input())
                             ->with('message', 'Nama barang tidak boleh duplikat');
                    // ->withErrors($errors, $this->errorBag());
        }

        return $good;
    }

    public function loadingGoodBase($good_id, $start_date, $end_date, $pagination)
    {
        if($pagination == 'all')
        {
            $loadings = GoodLoadingDetail::join('good_units', 'good_units.id', 'good_loading_details.good_unit_id')
                                         ->where('good_units.good_id', $good_id)
                                         ->whereDate('good_loading_details.loading_date', '>=', $start_date)
                                         ->whereDate('good_loading_details.loading_date', '<=', $end_date)
                                         ->where('good_units.deleted_at', null)
                                         ->get();
        }
        else
        {
            $loadings = GoodLoadingDetail::join('good_units', 'good_units.id', 'good_loading_details.good_unit_id')
                                         ->where('good_units.good_id', $good_id)
                                         ->whereDate('good_loading_details.created_at', '>=', $start_date)
                                         ->whereDate('good_loading_details.created_at', '<=', $end_date)
                                         ->where('good_units.deleted_at', null)
                                         ->paginate($pagination);
        }

        return $loadings;
    }

    public function transactionGoodBase($good_id, $start_date, $end_date, $pagination)
    {
        if($pagination == 'all')
        {
            $transactions = TransactionDetail::join('good_units', 'good_units.id', 'transaction_details.good_unit_id')
                                             ->join('goods', 'goods.id', 'good_units.good_id')
                                             ->select('transaction_details.*')
                                             ->where('goods.id', $good_id)
                                             ->whereDate('transaction_details.created_at', '>=', $start_date)
                                             ->whereDate('transaction_details.created_at', '<=', $end_date)
                                            ->where('good_units.deleted_at', null)
                                             ->orderBy('transaction_details.created_at', 'desc')
                                             ->get();
        }
        else
        {
            $transactions = TransactionDetail::join('good_units', 'good_units.id', 'transaction_details.good_unit_id')
                                             ->join('goods', 'goods.id', 'good_units.good_id')
                                             ->select('transaction_details.*')
                                             ->where('goods.id', $good_id)
                                             ->whereDate('transaction_details.created_at', '>=', $start_date)
                                             ->whereDate('transaction_details.created_at', '<=', $end_date)
                                            ->where('good_units.deleted_at', null)
                                             ->orderBy('transaction_details.created_at', 'desc')
                                             ->paginate($pagination);
        }

        return $transactions;
    }

    public function priceGoodBase($good_id, $start_date, $end_date, $pagination)
    {
        if($pagination == 'all')
        {
            $prices = GoodPrice::join('good_units', 'good_units.id', 'good_prices.good_unit_id')
                               ->select('good_prices.*')
                               ->where('good_units.good_id', $good_id)
                               ->whereDate('good_prices.created_at', '>=', $start_date)
                               ->whereDate('good_prices.created_at', '<=', $end_date)
                               ->orderBy('good_prices.created_at', 'desc')
                               ->get();
        }
        else
        {
            $prices = GoodPrice::join('good_units', 'good_units.id', 'good_prices.good_unit_id')
                               ->select('good_prices.*')
                               ->where('good_units.good_id', $good_id)
                               ->whereDate('good_prices.created_at', '>=', $start_date)
                               ->whereDate('good_prices.created_at', '<=', $end_date)
                               ->orderBy('good_prices.created_at', 'desc')
                               ->paginate($pagination);
        }

        return $prices;
    }

    public function updateGoodBase($good_id, $role, Request $request)
    {
        $this->validate($request, [
            'weight' => array('required', 'numeric'),
        ]);
        $data = $request->input();

        $good = Good::find($good_id);
        $good->update($data);

        // $good_unit = GoodUnit::where('good_id', $good->id)
        //                      ->where('unit_id', 1)
        //                      ->first();

        // $data['selling_price'] = unformatNumber($data['selling_price']);

        // if($good_unit)
        // {
        //     if($good_unit->selling_price != $data['selling_price'])
        //     {
        //         $data_price['role']         = $role;
        //         $data_price['role_id']      = \Auth::user()->id;
        //         $data_price['good_unit_id'] = $good_unit->id;
        //         $data_price['old_price']    = $good_unit->selling_price;
        //         $data_price['recent_price'] = $data['selling_price'];
        //         $data_price['reason']       = 'Diubah saat edit barang';

        //         GoodPrice::create($data_price);
        //     }

        //     $data_unit['selling_price'] = $data['selling_price'];

        //     $good_unit->update($data_unit);
        // }

        return $good;
    }

    public function deleteGoodBase($good_id)
    {
        $good = Good::find($good_id);
        $good->delete();

        return true;
    }

    public function zeroStockGoodBase($category_id, $location, $distributor_id, $stock)
    {
        if($category_id == 'all')
        {
            if($location == 'all')
            {
                if($distributor_id == 'all')
                {
                    $goods = DB::select(DB::raw("SELECT loading.quantity as loading, COALESCE(SUM(transaction.quantity), 0) as transaction, goods.id
                                      FROM goods 
                                      LEFT JOIN (SELECT COALESCE(SUM(good_loading_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM good_loading_details
                                                LEFT JOIN good_units ON good_units.id = good_loading_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as loading ON loading.good_id = goods.id
                                      LEFT JOIN (SELECT COALESCE(SUM(transaction_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM transaction_details
                                                LEFT JOIN good_units ON good_units.id = transaction_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as transaction ON transaction.good_id = goods.id
                                      WHERE goods.deleted_at IS NULL
                                      GROUP BY goods.id, loading.quantity, transaction.quantity
                                      HAVING (loading - transaction) <= " . $stock));
                }
                else
                {
                    $goods = DB::select(DB::raw("SELECT loading.quantity as loading, COALESCE(SUM(transaction.quantity), 0) as transaction, goods.id 
                                      FROM (SELECT goods.id 
                                            FROM goods 
                                            JOIN good_units ON good_units.good_id = goods.id
                                            JOIN good_loading_details ON good_units.id = good_loading_details.good_unit_id
                                            JOIN good_loadings ON good_loadings.id = good_loading_details.good_loading_id
                                            JOIN distributors ON distributors.id = good_loadings.distributor_id
                                            WHERE distributors.id = " . $distributor_id . " 
                                            AND goods.deleted_at IS NULL
                                            AND good_units.deleted_at IS NULL
                                            GROUP BY goods.id) as goods
                                      LEFT JOIN (SELECT COALESCE(SUM(good_loading_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM good_loading_details
                                                LEFT JOIN good_units ON good_units.id = good_loading_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as loading ON loading.good_id = goods.id
                                      LEFT JOIN (SELECT COALESCE(SUM(transaction_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM transaction_details
                                                LEFT JOIN good_units ON good_units.id = transaction_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as transaction ON transaction.good_id = goods.id
                                      GROUP BY goods.id, loading.quantity, transaction.quantity
                                      HAVING (loading - transaction) <= " . $stock));
                }
            }
            else
            {
                if($distributor_id == 'all')
                {
                    $goods = DB::select(DB::raw("SELECT loading.quantity as loading, COALESCE(SUM(transaction.quantity), 0) as transaction, goods.id
                                      FROM (SELECT goods.id 
                                            FROM goods 
                                            JOIN good_units ON good_units.good_id = goods.id
                                            JOIN good_loading_details ON good_units.id = good_loading_details.good_unit_id
                                            JOIN good_loadings ON good_loadings.id = good_loading_details.good_loading_id
                                            JOIN distributors ON distributors.id = good_loadings.distributor_id
                                            WHERE distributors.location = '" . $location . "' 
                                            AND good_units.deleted_at IS NULL
                                            AND goods.deleted_at IS NULL
                                            GROUP BY goods.id) as goods
                                      LEFT JOIN (SELECT COALESCE(SUM(good_loading_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM good_loading_details
                                                LEFT JOIN good_units ON good_units.id = good_loading_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as loading ON loading.good_id = goods.id
                                      LEFT JOIN (SELECT COALESCE(SUM(transaction_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM transaction_details
                                                LEFT JOIN good_units ON good_units.id = transaction_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as transaction ON transaction.good_id = goods.id
                                      GROUP BY goods.id, loading.quantity, transaction.quantity
                                      HAVING (loading - transaction) <= " . $stock));
                }
                else
                {
                    $goods = DB::select(DB::raw("SELECT loading.quantity as loading, COALESCE(SUM(transaction.quantity), 0) as transaction, goods.id 
                                      FROM (SELECT goods.id
                                            FROM goods 
                                            JOIN good_units ON good_units.good_id = goods.id
                                            JOIN good_loading_details ON good_units.id = good_loading_details.good_unit_id
                                            JOIN good_loadings ON good_loadings.id = good_loading_details.good_loading_id
                                            JOIN distributors ON distributors.id = good_loadings.distributor_id
                                            WHERE distributors.location = '" . $location . "' AND 
                                            distributors.id = " . $distributor_id . " 
                                            AND good_units.deleted_at IS NULL
                                            AND goods.deleted_at IS NULL
                                            GROUP BY goods.id) as goods
                                      LEFT JOIN (SELECT COALESCE(SUM(good_loading_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM good_loading_details
                                                LEFT JOIN good_units ON good_units.id = good_loading_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as loading ON loading.good_id = goods.id
                                      LEFT JOIN (SELECT COALESCE(SUM(transaction_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM transaction_details
                                                LEFT JOIN good_units ON good_units.id = transaction_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as transaction ON transaction.good_id = goods.id
                                      GROUP BY goods.id, loading.quantity, transaction.quantity
                                      HAVING (loading - transaction) <= " . $stock));
                }
            }
        }
        else
        {
            if($location == 'all')
            {
                if($distributor_id == 'all')
                {
                    $goods = DB::select(DB::raw("SELECT loading.quantity as loading, COALESCE(SUM(transaction.quantity), 0) as transaction, goods.id
                                      FROM goods 
                                      LEFT JOIN (SELECT COALESCE(SUM(good_loading_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM good_loading_details
                                                LEFT JOIN good_units ON good_units.id = good_loading_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as loading ON loading.good_id = goods.id
                                      LEFT JOIN (SELECT COALESCE(SUM(transaction_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM transaction_details
                                                LEFT JOIN good_units ON good_units.id = transaction_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as transaction ON transaction.good_id = goods.id
                                      WHERE goods.category_id = " . $category_id . " 
                                      AND goods.deleted_at IS NULL
                                      GROUP BY goods.id, loading.quantity, transaction.quantity
                                      HAVING (loading - transaction) <= " . $stock));
                }
                else
                {
                    $goods = DB::select(DB::raw("SELECT loading.quantity as loading, COALESCE(SUM(transaction.quantity), 0) as transaction, goods.id 
                                      FROM (SELECT goods.id 
                                            FROM goods 
                                            JOIN good_units ON good_units.good_id = goods.id
                                            JOIN good_loading_details ON good_units.id = good_loading_details.good_unit_id
                                            JOIN good_loadings ON good_loadings.id = good_loading_details.good_loading_id
                                            JOIN distributors ON distributors.id = good_loadings.distributor_id
                                            WHERE distributors.id = " . $distributor_id . " 
                                            AND goods.category_id = " . $category_id . " 
                                            AND goods.deleted_at IS NULL 
                                            AND good_units.deleted_at IS NULL
                                            GROUP BY goods.id) as goods
                                      LEFT JOIN (SELECT COALESCE(SUM(good_loading_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM good_loading_details
                                                LEFT JOIN good_units ON good_units.id = good_loading_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as loading ON loading.good_id = goods.id
                                      LEFT JOIN (SELECT COALESCE(SUM(transaction_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM transaction_details
                                                LEFT JOIN good_units ON good_units.id = transaction_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as transaction ON transaction.good_id = goods.id
                                      GROUP BY goods.id, loading.quantity, transaction.quantity
                                      HAVING (loading - transaction) <= " . $stock));
                }
            }
            else
            {
                if($distributor_id == 'all')
                {
                    $goods = DB::select(DB::raw("SELECT loading.quantity as loading, COALESCE(SUM(transaction.quantity), 0) as transaction, goods.id
                                      FROM (SELECT goods.id 
                                            FROM goods 
                                            JOIN good_units ON good_units.good_id = goods.id
                                            JOIN good_loading_details ON good_units.id = good_loading_details.good_unit_id
                                            JOIN good_loadings ON good_loadings.id = good_loading_details.good_loading_id
                                            JOIN distributors ON distributors.id = good_loadings.distributor_id
                                            WHERE distributors.location = '" . $location . "'
                                            AND goods.category_id = " . $category_id . " 
                                            AND goods.deleted_at IS NULL 
                                            AND good_units.deleted_at IS NULL
                                            GROUP BY goods.id) as goods
                                      LEFT JOIN (SELECT COALESCE(SUM(good_loading_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM good_loading_details
                                                LEFT JOIN good_units ON good_units.id = good_loading_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as loading ON loading.good_id = goods.id
                                      LEFT JOIN (SELECT COALESCE(SUM(transaction_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM transaction_details
                                                LEFT JOIN good_units ON good_units.id = transaction_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as transaction ON transaction.good_id = goods.id
                                      GROUP BY goods.id, loading.quantity, transaction.quantity
                                      HAVING (loading - transaction) <= " . $stock));
                }
                else
                {
                    $goods = DB::select(DB::raw("SELECT loading.quantity as loading, COALESCE(SUM(transaction.quantity), 0) as transaction, goods.id 
                                      FROM (SELECT goods.id
                                            FROM goods 
                                            JOIN good_units ON good_units.good_id = goods.id
                                            JOIN good_loading_details ON good_units.id = good_loading_details.good_unit_id
                                            JOIN good_loadings ON good_loadings.id = good_loading_details.good_loading_id
                                            JOIN distributors ON distributors.id = good_loadings.distributor_id
                                            WHERE distributors.location = '" . $location . "' 
                                            AND distributors.id = " . $distributor_id . "
                                            AND goods.category_id = " . $category_id . "
                                            AND goods.deleted_at IS NULL
                                            AND good_units.deleted_at IS NULL
                                            GROUP BY goods.id) as goods
                                      LEFT JOIN (SELECT COALESCE(SUM(good_loading_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM good_loading_details
                                                LEFT JOIN good_units ON good_units.id = good_loading_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as loading ON loading.good_id = goods.id
                                      LEFT JOIN (SELECT COALESCE(SUM(transaction_details.real_quantity), 0) as quantity, good_units.good_id
                                                FROM transaction_details
                                                LEFT JOIN good_units ON good_units.id = transaction_details.good_unit_id
                                                WHERE good_units.deleted_at IS NULL
                                                GROUP BY good_units.good_id) as transaction ON transaction.good_id = goods.id
                                      GROUP BY goods.id, loading.quantity, transaction.quantity
                                      HAVING (loading - transaction) <= " . $stock));
                }
            }
        }

        foreach($goods as $good)
        {
            $good->obj = Good::find($good->id);
        }
        
        return $goods;
    }

    public function updatePriceGoodBase($role, $role_id, $good_id, Request $request)
    {
        // dd($request);die;
        $this->validate($request, [
            'selling_prices.*' => array('required', 'regex:/^[\d\s,]*$/'),
        ]);

        $good = Good::find($good_id);

        for($i = 0; $i < sizeof($request->good_unit_ids); $i++)
        {;
            $good_unit = GoodUnit::find($request->good_unit_ids[$i]);

            $data_price['role'] = $role;
            $data_price['role_id'] = $role_id;
            $data_price['good_unit_id'] = $good_unit->id;
            $data_price['old_price'] = $good_unit->selling_price;
            $data_price['recent_price'] = unformatNumber($request->selling_prices[$i]);
            $data_price['reason'] = $request->reason;

            GoodPrice::create($data_price);

            $data_good_unit['selling_price'] = $data_price['recent_price'];

            $good_unit->update($data_good_unit);
        }

        return $good;
    }

    public function deletePriceGoodBase($good_unit_id)
    {
        $good_unit = GoodUnit::find($good_unit_id);
        $good_unit->delete();

        return true;
    }

    public function printBarcodeGoodBase(Request $request)
    {
        $goods = [];
        for($i = 0; $i < sizeof($request->ids); $i++)
        {
            if($request->ids[$i] != null)
            {
                $good_unit = GoodUnit::find($request->ids[$i]);

                for($j = 0; $j < $request->quantities[$i]; $j++)
                {
                    if($good_unit->good != null)
                    {
                        $data['barcode'] = $good_unit->good->getBarcode();
                        $data['name'] = $good_unit->good->name;
                        $data['code'] = $good_unit->good->code;
                        $data['weight'] = $good_unit->good->weight;
                        $data['old_gold'] = '';
                        if($good_unit->good->is_old_gold == 1)
                            $data['old_gold'] = 'MT';
                        $data['stone_weight'] = $good_unit->good->stone_weight;
                        $data['stone_price'] = formatNumber($good_unit->good->stone_price);

                        array_push($goods, $data);
                    }
                }
            }
        }
        
        return $goods;
    }

    public function expGoodBase()
    {
        $today = Carbon::now();
        $later = $today->addDays(15);

        $loadings = GoodLoadingDetail::whereDate('good_loading_details.expiry_date', '>=', date('Y-m-d'))
                                  ->whereDate('good_loading_details.expiry_date', '<=', $later)
                                  ->orderBy('good_loading_details.expiry_date', 'asc')
                                  ->get();

        return $loadings;
    }

    public function changeStatusGoodBase($good_id, $status)
    {
        if($status == 'sell') $status = 'Siap dijual';
        $data['status'] = $status;

        $good = Good::find($good_id);
        $good->update($data);

        return $good;
    }

    public function historyGoodBase($good_id, $start_date, $end_date, $pagination)
    {
        if($pagination == 'all')
        {
            $loadings = GoodLoadingDetail::join('good_units', 'good_units.id', 'good_loading_details.good_unit_id')
                                         ->select('good_loading_details.id', 'good_loading_details.created_at')
                                         ->where('good_units.good_id', $good_id)
                                         ->whereDate('good_loading_details.created_at', '>=', $start_date)
                                         ->whereDate('good_loading_details.created_at', '<=', $end_date)
                                         ->orderBy('good_loading_details.created_at', 'asc')
                                         ->get();

            $transactions = TransactionDetail::join('good_units', 'good_units.id', 'transaction_details.good_unit_id')
                                             ->select('transaction_details.id', 'transaction_details.created_at')
                                             ->where('good_units.good_id', $good_id)
                                             ->whereDate('transaction_details.created_at', '>=', $start_date)
                                             ->whereDate('transaction_details.created_at', '<=', $end_date)
                                             ->orderBy('transaction_details.created_at', 'asc')
                                             ->get();
        }
        else
        {     
            $loadings = GoodLoadingDetail::join('good_units', 'good_units.id', 'good_loading_details.good_unit_id')
                                         ->select('good_loading_details.id', 'good_loading_details.created_at')
                                         ->where('good_units.good_id', $good_id)
                                         ->whereDate('good_loading_details.created_at', '>=', $start_date)
                                         ->whereDate('good_loading_details.created_at', '<=', $end_date)
                                         ->orderBy('good_loading_details.created_at', 'asc')
                                         ->paginate($pagination);

            $transactions = TransactionDetail::join('good_units', 'good_units.id', 'transaction_details.good_unit_id')
                                             ->select('transaction_details.id', 'transaction_details.created_at')
                                             ->where('good_units.good_id', $good_id)
                                             ->whereDate('transaction_details.created_at', '>=', $start_date)
                                             ->whereDate('transaction_details.created_at', '<=', $end_date)
                                             ->orderBy('transaction_details.created_at', 'asc')
                                             ->paginate($pagination);
        }

        $histories = [];
        $i = 0;
        $j = 0;

        if(sizeof($loadings) > sizeof($transactions)) 
        {
            $total = sizeof($loadings);
        }
        else
        {
            $total = sizeof($transactions);
        }

        for($k = 0; $k < $total; $k++)
        {
            if(isset($loadings[$i]) && isset($transactions[$j]))
            {
                if($loadings[$i]->created_at < $transactions[$j]->created_at)
                {
                    $loadings[$i]->type = 'loading';
                    array_push($histories, $loadings[$i]);
                    $i++;
                }
                else
                {
                    $transactions[$j]->type = 'transaction';
                    array_push($histories, $transactions[$j]);
                    $j++;
                }
            }
            elseif(isset($loadings[$i]))
            {
                $loadings[$i]->type = 'loading';
                array_push($histories, $loadings[$i]);
                $i++;
            }
            else
            {
                $transactions[$j]->type = 'transaction';
                array_push($histories, $transactions[$j]);
                $j++;
            }
        }

        return $histories;
    }
}
