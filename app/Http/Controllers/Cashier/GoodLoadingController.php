<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Base\GoodLoadingControllerBase;

use App\Models\GoodLoading;

class GoodLoadingController extends Controller
{
    use GoodLoadingControllerBase;

    public function __construct()
    {
        $this->middleware('cashier');
    }

    public function index($type, $start_date, $end_date, $distributor_id, $pagination)
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        if($type == 'buy')
            $default['page_name'] = 'Daftar Pembelian Emas dengan Surat';
        elseif($type == 'buy-other')
            $default['page_name'] = 'Daftar Pembelian Emas tanpa Surat';
        else
            $default['page_name'] = 'Daftar Kulak Emas';
        $default['page'] = 'good-loading';
        $default['section'] = 'all';

        $good_loadings = $this->indexGoodLoadingBase($type, $start_date, $end_date, $distributor_id, $pagination);

        return view('cashier.layout.page', compact('default', 'type', 'good_loadings', 'start_date', 'end_date', 'distributor_id', 'pagination'));
    }

    public function create($type)
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        if($type == 'buy')
            $default['page_name'] = 'Tambah Pembelian Emas dengan Surat';
        elseif($type == 'buy-other')
            $default['page_name'] = 'Tambah Pembelian Emas tanpa Surat';
        else
            $default['page_name'] = 'Tambah Kulak Emas';
        $default['page'] = 'good-loading';
        $default['section'] = 'create';

        return view('cashier.layout.page', compact('default', 'type'));
    }

    public function store(Request $request)
    {
        $good_loading = $this->storeGoodLoadingBase('cashier', \Auth::user()->id, $request);

        session(['alert' => 'add', 'data' => 'loading barang']);

        if($request->type == 'loading')
            return redirect('/cashier/good-loading/' . $good_loading->id . '/printBarcode');
        else
            return redirect('/cashier/good-loading/' . $good_loading->id . '/print');
    }

    public function detail($good_loading_id)
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        // if($type == 'buy')
        //     $default['page_name'] = 'Detail Pembelian Emas dengan Surat';
        // elseif($type == 'buy-other')
        //     $default['page_name'] = 'Detail Pembelian Emas tanpa Surat';
        // else
        //     $default['page_name'] = 'Detail Kulak Emas';

        $default['page_name'] = 'Detail Pembelian Emas';
        $default['page'] = 'good-loading';
        $default['section'] = 'detail';

        $good_loading = GoodLoading::find($good_loading_id);

        return view('cashier.layout.page', compact('default', 'good_loading'));
    }

    public function excel()
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        $default['page_name'] = 'Import Excel Loading';
        $default['page'] = 'good-loading';
        $default['section'] = 'excel';

        return view('cashier.layout.page', compact('default'));
    }

    public function storeExcel(Request $request)
    {
        $good_loading = $this->storeExcelGoodLoadingBase('cashier', \Auth::user()->id, $request);

        session(['alert' => 'add', 'data' => 'loading barang']);

        return redirect('/cashier/good-loading/' . $good_loading->id . '/detail');
    }

    public function print($good_loading_id)
    {
        $role = 'cashier';

        $good_loading = GoodLoading::find($good_loading_id);

        return view('layout.good-loading.print', compact('role', 'good_loading'));
    }

    public function printBarcode($good_loading_id)
    {
        $role = 'cashier';

        $goods = $this->printBarcodeFromLoadingGoodLoadingBase($good_loading_id);
        
        return view('layout.good.print-barcode', compact('role', 'goods'));
    }
}
