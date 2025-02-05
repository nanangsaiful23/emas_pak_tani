<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;

use App\Models\ServerPayment;

trait ServerPaymentControllerBase 
{
    public function indexServerPaymentBase($start_date, $end_date, $pagination)
    {
        if($pagination == 'all')
           $server_payments = ServerPayment::orderBy('month_due', 'desc')->get();
        else
           $server_payments = ServerPayment::orderBy('month_due', 'desc')->paginate($pagination);

        return $server_payments;
    }

    public function storeServerPaymentBase(Request $request)
    {
    	$data = $request->input();
        $data['nominal'] = unformatNumber($request->nominal);

    	$server_payment = ServerPayment::create($data);

        return $server_payment;
    }

    public function updateServerPaymentBase($server_payment_id, Request $request)
    {
    	$data = $request->input();
        $data['nominal'] = unformatNumber($request->nominal);

    	$server_payment = ServerPayment::find($server_payment_id);
    	$server_payment->update($data);

        return $server_payment;
    }

    public function deleteServerPaymentBase($server_payment_id)
    {
    	$server_payment = ServerPayment::find($server_payment_id);
    	$server_payment->delete();
    }
}
