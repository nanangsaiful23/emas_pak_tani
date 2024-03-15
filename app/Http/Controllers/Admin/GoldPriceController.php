<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Base\GoldPriceControllerBase;

use App\Models\GoldPrice;

class GoldPriceController extends Controller
{
    use GoldPriceControllerBase;

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index($pagination)
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        $default['page_name'] = 'Daftar Harga Emas';
        $default['page'] = 'gold-price';
        $default['section'] = 'all';

        $gold_prices = $this->indexGoldPriceBase($pagination);

        return view('admin.layout.page', compact('default', 'gold_prices', 'pagination'));
    }

    public function create()
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        $default['page_name'] = 'Tambah Harga Emas';
        $default['page'] = 'gold-price';
        $default['section'] = 'create';

        return view('admin.layout.page', compact('default'));
    }

    public function store(Request $request)
    {
        $gold_price = $this->storeGoldPriceBase($request);

        session(['alert' => 'add', 'data' => 'Harga Emas']);

        return redirect('/admin');
    }

    public function delete($gold_price_id)
    {
        $this->deleteGoldPriceBase($gold_price_id);

        session(['alert' => 'delete', 'data' => 'Harga Emas']);

        return redirect('/admin/gold-price/all/10');
    }
}
