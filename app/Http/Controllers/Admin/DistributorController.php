<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Base\DistributorControllerBase;

use App\Models\Distributor;

class DistributorController extends Controller
{
    use DistributorControllerBase;

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index($type, $pagination)
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        if($type == 'sales')
            $default['page_name'] = 'Daftar Sales';
        else
            $default['page_name'] = 'Daftar Penjual Emas';
        $default['page'] = 'distributor';
        $default['section'] = 'all';

        $distributors = $this->indexDistributorBase($type, $pagination);

        return view('admin.layout.page', compact('default', 'distributors', 'type', 'pagination'));
    }

    public function create($type)
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        if($type == 'sales')
            $default['page_name'] = 'Tambah Sales';
        else
            $default['page_name'] = 'Tambah Penjual Emas';
        $default['page'] = 'distributor';
        $default['section'] = 'create';

        return view('admin.layout.page', compact('default', 'type'));
    }

    public function store($type, Request $request)
    {
        $distributor = $this->storeDistributorBase($type, $request);

        session(['alert' => 'add', 'data' => $type . ' barang']);

        return redirect('/admin/distributor/' . $distributor->id . '/detail');
    }

    public function detail($type, $distributor_id)
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        if($type == 'sales')
            $default['page_name'] = 'Detail Sales';
        else
            $default['page_name'] = 'Detail Penjual Emas';
        $default['page'] = 'distributor';
        $default['section'] = 'detail';

        $distributor = Distributor::find($distributor_id);

        return view('admin.layout.page', compact('default', 'type', 'distributor'));
    }

    public function edit($type, $distributor_id)
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        if($type == 'sales')
            $default['page_name'] = 'Ubah Sales';
        else
            $default['page_name'] = 'Ubah Penjual Emas';
        $default['page'] = 'distributor';
        $default['section'] = 'edit';

        $distributor = Distributor::find($distributor_id);

        return view('admin.layout.page', compact('default', 'type', 'distributor'));
    }

    public function update($type, $distributor_id, Request $request)
    {
        $distributor = $this->updateDistributorBase($distributor_id, $request);

        session(['alert' => 'edit', 'data' => 'distributor barang']);

        return redirect('/admin/distributor/' . $distributor->id . '/detail');
    }

    public function delete($type, $distributor_id)
    {
        $this->deleteDistributorBase($distributor_id);

        session(['alert' => 'delete', 'data' => 'distributor barang']);

        return redirect('/admin/distributor/all/10');
    }
}
