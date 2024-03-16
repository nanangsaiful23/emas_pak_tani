<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Base\PercentageControllerBase;

use App\Models\Percentage;

class PercentageController extends Controller
{
    use PercentageControllerBase;

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index($pagination)
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        $default['page_name'] = 'Daftar Persentase';
        $default['page'] = 'percentage';
        $default['section'] = 'all';

        $percentages = $this->indexPercentageBase($pagination);

        return view('admin.layout.page', compact('default', 'percentages', 'pagination'));
    }

    public function create()
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        $default['page_name'] = 'Tambah Persentase';
        $default['page'] = 'percentage';
        $default['section'] = 'create';

        return view('admin.layout.page', compact('default'));
    }

    public function store(Request $request)
    {
        $percentage = $this->storePercentageBase($request);

        session(['alert' => 'add', 'data' => 'Persentase barang']);

        return redirect('/admin/percentage/10');
    }

    public function edit($percentage_id)
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        $default['page_name'] = 'Ubah Persentase';
        $default['page'] = 'percentage';
        $default['section'] = 'edit';

        $percentage = Percentage::find($percentage_id);

        return view('admin.layout.page', compact('default', 'percentage'));
    }

    public function update($percentage_id, Request $request)
    {
        $color = $this->updatePercentageBase($percentage_id, $request);

        session(['alert' => 'edit', 'data' => 'Persentase barang']);

        return redirect('/admin/percentage/15');
    }

    public function delete($percentage_id)
    {
        $this->deletePercentageBase($percentage_id);

        session(['alert' => 'delete', 'data' => 'Persentase barang']);

        return redirect('/admin/percentage/15');
    }
}
