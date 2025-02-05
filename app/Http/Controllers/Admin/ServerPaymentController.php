<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Base\ServerPaymentControllerBase;

use App\Models\ServerPayment;

class ServerPaymentController extends Controller
{
    use ServerPaymentControllerBase;

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index($start_date, $end_date, $pagination)
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        $default['page_name'] = 'Riwayat Pembayaran';
        $default['page'] = 'server-payment';
        $default['section'] = 'all';

        $server_payments = $this->indexServerPaymentBase($start_date, $end_date, $pagination);

        return view('admin.layout.page', compact('default', 'server_payments', 'start_date', 'end_date', 'pagination'));
    }

    public function create()
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        $default['page_name'] = 'Tambah warna';
        $default['page'] = 'server-payment';
        $default['section'] = 'create';

        return view('admin.layout.page', compact('default'));
    }

    public function store(Request $request)
    {
        $server_payment = $this->storeServerPaymentBase($request);

        session(['alert' => 'add', 'data' => 'Tagihan pembayaran']);

        return redirect('/admin/server-payment/' . $server_payment->id . '/detail');
    }

    public function detail($server_payment_id)
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        $default['page_name'] = 'Detail tagihan';
        $default['page'] = 'server-payment';
        $default['section'] = 'detail';

        $server_payment = ServerPayment::find($server_payment_id);

        return view('admin.layout.page', compact('default', 'server_payment'));
    }

    public function edit($server_payment_id)
    {
        [$default['type'], $default['color'], $default['data']] = alert();

        $default['page_name'] = 'Ubah tagihan';
        $default['page'] = 'server-payment';
        $default['section'] = 'edit';

        $server_payment = ServerPayment::find($server_payment_id);

        return view('admin.layout.page', compact('default', 'server_payment'));
    }

    public function update($server_payment_id, Request $request)
    {
        $server_payment = $this->updateServerPaymentBase($server_payment_id, $request);

        session(['alert' => 'edit', 'data' => 'Tagihan pembayaran']);

        return redirect('/admin/server-payment/' . $server_payment->id . '/detail');
    }

    public function delete($server_payment_id)
    {
        $this->deleteServerPaymentBase($server_payment_id);

        session(['alert' => 'delete', 'data' => 'Tagihan pembayaran']);

        return redirect('/admin/server-payment/all/10');
    }
}
