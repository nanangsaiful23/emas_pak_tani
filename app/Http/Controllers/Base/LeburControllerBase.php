<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Cokim;
use App\Models\Good;
use App\Models\GoodUnit;
use App\Models\GoodPrice;

trait LeburControllerBase 
{
    public function indexCokimLeburBase($status, $pagination)
    {
        if($status == 'sellOngoing')
        {
            if($pagination == 'all')
               $cokims = Cokim::where('status', 'sell')
                              ->orWhere('status', 'ongoing')->get();
            else
               $cokims = Cokim::where('status', 'sell')
                              ->orWhere('status', 'ongoing')->paginate($pagination);
        }
        elseif($status == 'newGold')
        {
            if($pagination == 'all')
               $cokims = Cokim::where('status', 'new gold from cokim')
                              ->get();
            else
               $cokims = Cokim::where('status', 'new gold from cokim')
                              ->paginate($pagination);
        }
        else
        {
            if($pagination == 'all')
               $cokims = Cokim::where('status', $status)->get();
            else
               $cokims = Cokim::where('status', $status)->paginate($pagination);
        }

        return $cokims;
    }

    public function indexGoodLeburBase($status, $pagination)
    {
        if($pagination == 'all')
           $goods = Good::where('status', $status)->get();
        else
           $goods = Good::where('status', $status)->paginate($pagination);

        return $goods;
    }

    public function storeLeburBase(Request $request)
    {
        $total = 0;
        for($i = 0; $i < sizeof($request->leburs); $i++)
        {
            $data_good['status'] = 'Proses lebur cokim';

            $good = Good::find($request->leburs[$i]);
            $good->update($data_good);

            $total += $good->weight;
        }
        $data = $request->input();
        $data['status'] = 'ongoing';
        $data['weight'] = $total;

        $cokim = Cokim::create($data);

        return true;
    }

    public function storeNewLeburBase($role, $role_id, Request $request)
    {
        $request->price = unformatNumber($request->price);
        $request->selling_price = unformatNumber($request->selling_price);
        $this->validate($request, [
            'weight' => array('required', 'numeric'),
            'price' => array('required', 'regex:/^[\d\s,]*$/'),
            'selling_price' => array('required', 'regex:/^[\d\s,]*$/'),
        ]);
        $data = $request->input();
        $data['price'] = unformatNumber($request->price);
        $data['selling_price'] = unformatNumber($request->selling_price);
        $data['unit_id'] = 1;
        $data['status']  = 'Siap dijual';

        $good = Good::where('name', $data['name'])->first();

        if($good == null)
        {
            if($data['price'] == null) $data['price'] = 1;
            if($data['selling_price'] == null) $data['selling_price'] = 1;

            $good = Good::create($data);

            $category = Category::find($data['category_id']);
            $yearmo = date('Y-m');
            $data_good['code'] = $category->code . '-' . $yearmo . '-' . $good->id;
            $good->update($data_good);
            $good->code = $data_good['code'];

            $good_unit = GoodUnit::where('good_id', $good->id)
                                 ->where('unit_id', $data['unit_id'])
                                 ->first();

            if($good_unit)
            {
                if($good_unit->selling_price != $data['selling_price'])
                {
                    $data_price['role']         = $role;
                    $data_price['role_id']      = $role_id;
                    $data_price['good_unit_id'] = $good_unit->id;
                    $data_price['old_price']    = $good_unit->selling_price;
                    $data_price['recent_price'] = $data['selling_price'];
                    $data_price['reason']       = 'Diubah saat loading';

                    GoodPrice::create($data_price);
                }

                $data_unit['buy_price']     = $data['price'];
                $data_unit['selling_price'] = $data['selling_price'];

                $good_unit->update($data_unit);
            }
            else
            {
                $data_unit['good_id']       = $good->id;
                $data_unit['unit_id']       = $data['unit_id'];
                $data_unit['buy_price']     = $data['price'];
                $data_unit['selling_price'] = $data['selling_price'];

                $good_unit = GoodUnit::create($data_unit);

                $data_price['role']         = $role;
                $data_price['role_id']      = $role_id;
                $data_price['good_unit_id'] = $good_unit->id;
                $data_price['old_price']    = $good_unit->selling_price;
                $data_price['recent_price'] = $data['selling_price'];
                $data_price['reason']       = 'Harga pertama';

                GoodPrice::create($data_price);
            }

            $good->unit_id = $good_unit->unit_id;
            $good->unit    = $good_unit->unit->name . '(' . $good_unit->unit->code . ')';
            $good->price   = $data['price'];
            $good->selling_price   = $data['selling_price'];
        }

        $data_cokim['weight'] = $request->weight;
        $data_cokim['status'] = 'new gold from cokim';
        $data_cokim['production_price'] = $request->price;
        $data_cokim['selling_price'] = $request->selling_price;

        Cokim::create($data_cokim);

        return $good;
    }

    public function storeSellLeburBase(Request $request)
    {
        $request->selling_price = unformatNumber($request->selling_price);
        $this->validate($request, [
            'weight' => array('required', 'numeric'),
            'selling_price' => array('required', 'regex:/^[\d\s,]*$/'),
        ]);

        $data = $request->input();
        $data['selling_price'] = unformatNumber($request->selling_price);
        $data['status'] = 'sold';

        $cokim = Cokim::create($data);

        return $cokim;
    }

    public function storeDoneLeburBase(Request $request)
    {
        $data_cokim['status'] = 'sell';

        $cokim = Cokim::find($request->cokim_id);
        $cokim->update($data_cokim);
    }
}
