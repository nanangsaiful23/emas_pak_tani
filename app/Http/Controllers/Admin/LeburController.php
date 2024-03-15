<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Base\LeburControllerBase;

class LeburController extends Controller
{
    use LeburControllerBase;

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function create()
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        $default['page_name'] = 'Tambah Emas Lebur';
        $default['page'] = 'lebur';
        $default['section'] = 'create';

        $lebures = $this->indexGoodLeburBase('Tidak layak jual', 'all');

        return view('admin.layout.page', compact('default', 'lebures'));
    }

    public function store(Request $request)
    {
        $lebur = $this->storeLeburBase($request);

        session(['alert' => 'add', 'data' => 'Emas Lebur']);

        return redirect('/admin/lebur/history/sellOngoing/20');
    }

    public function createNew()
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        $default['page_name'] = 'Buat Emas Baru dari Emas Cokim';
        $default['page'] = 'lebur';
        $default['section'] = 'create-new';

        return view('admin.layout.page', compact('default'));
    }

    public function storeNew(Request $request)
    {
        $lebur = $this->storeNewLeburBase('Admin', \Auth::user()->id, $request);

        session(['alert' => 'add', 'data' => 'Emas Lebur']);

        return redirect('/admin/lebur/history/newGold/20');
    }

    public function sell()
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        $default['page_name'] = 'Jual Emas Cokim';
        $default['page'] = 'lebur';
        $default['section'] = 'sell';

        $cokims = $this->indexCokimLeburBase('sell', 'all');

        return view('admin.layout.page', compact('default', 'cokims'));
    }

    public function storeSell(Request $request)
    {
        $lebur = $this->storeSellLeburBase($request);

        session(['alert' => 'add', 'data' => 'Emas Lebur']);

        return redirect('/admin/lebur/history/sold/20');
    }

    public function storeDone(Request $request)
    {
        $lebur = $this->storeDoneLeburBase($request);

        session(['alert' => 'add', 'data' => 'Emas Lebur']);

        return redirect('/admin/lebur/history/sellOngoing/20');
    }

    public function history($type, $pagination)
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        $default['page'] = 'lebur';
        $default['section'] = 'history';
        if($type == 'sellOngoing')
        {
            $default['page_name'] = 'Riwayat Peleburan Emas Cokim';
        }
        elseif($type == 'sold')
        {
            $default['page_name'] = 'Riwayat Penjualan Emas Cokim';
        }
        elseif($type == 'sell')
        {
            $default['page_name'] = 'Riwayat Peleburan Emas Cokim';
        }
        elseif($type == 'newGold')
        {
            $default['page_name'] = 'Riwayat Pembuatan Emas Cokim';
        }

        $cokims = $this->indexCokimLeburBase($type, $pagination);

        return view('admin.layout.page', compact('default', 'cokims', 'type', 'pagination'));
    }
}
