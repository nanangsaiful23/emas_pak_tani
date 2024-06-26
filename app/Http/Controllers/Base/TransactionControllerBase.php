<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Account;
use App\Models\GoldPrice;
use App\Models\Good;
use App\Models\GoodLoading;
use App\Models\GoodLoadingDetail;
use App\Models\GoodUnit;
use App\Models\Journal;
use App\Models\Member;
use App\Models\PiutangPayment;
use App\Models\ReturItem;
use App\Models\Transaction;
use App\Models\TransactionDetail;

trait TransactionControllerBase 
{
    public function indexTransactionBase($role, $role_id, $start_date, $end_date, $pagination)
    {
        $transactions = [];

        $sub_total = Transaction::join('transaction_details', 'transaction_details.transaction_id', 'transactions.id')
                                ->select(DB::raw('SUM(transactions.total_sum_price) as total_sum_price, SUM(transactions.total_discount_price) as total_discount_price, SUM(transaction_details.discount_price) as discount_item'))
                                ->whereDate('transactions.created_at', '>=', $start_date)
                                ->whereDate('transactions.created_at', '<=', $end_date) 
                                ->where('transactions.payment', 'cash')
                                ->whereRaw('transactions.money_paid >= total_sum_price')
                                ->where('transactions.type', 'normal')
                                ->groupBy('transactions.created_at')
                                ->orderBy('transactions.created_at','desc')
                                ->get();

        if($pagination == 'all')
        {
            if($role_id == 'all')
            {
                $transactions['cash'] = Transaction::whereDate('transactions.created_at', '>=', $start_date)
                                                    ->whereDate('transactions.created_at', '<=', $end_date) 
                                                    ->where('payment', 'cash')
                                                    ->whereRaw('money_paid >= total_sum_price')
                                                    ->where('type', 'normal')
                                                    ->orderBy('transactions.created_at','desc')
                                                    ->get();

                $transactions['retur'] = Transaction::whereDate('transactions.created_at', '>=', $start_date)
                                                    ->whereDate('transactions.created_at', '<=', $end_date) 
                                                    ->where('type', 'retur')
                                                    ->orderBy('transactions.created_at','desc')
                                                    ->get();
            }
            else
            {
                $transactions['cash'] = Transaction::whereDate('transactions.created_at', '>=', $start_date)
                                                    ->whereDate('transactions.created_at', '<=', $end_date) 
                                                    ->where('payment', 'cash')
                                                    ->whereRaw('money_paid >= total_sum_price')
                                                    ->where('role', $role)
                                                    ->where('role_id', $role_id)
                                                    ->where('type', 'normal')
                                                    ->orderBy('transactions.created_at','desc')
                                                    ->get();

                $transactions['retur'] = Transaction::whereDate('transactions.created_at', '>=', $start_date)
                                                    ->whereDate('transactions.created_at', '<=', $end_date) 
                                                    ->where('type', 'retur')
                                                    ->where('role', $role)
                                                    ->where('role_id', $role_id)
                                                    ->orderBy('transactions.created_at','desc')
                                                    ->get();
            }
        }
        else
        {
            if($role_id == 'all')
            {
                $transactions['cash'] = Transaction::whereDate('transactions.created_at', '>=', $start_date)
                                                    ->whereDate('transactions.created_at', '<=', $end_date)
                                                    ->where('payment', 'cash')
                                                    ->whereRaw('money_paid >= total_sum_price')
                                                    ->where('type', 'normal')
                                                    ->orderBy('transactions.created_at','desc')
                                                    ->paginate($pagination);

                $transactions['retur'] = Transaction::whereDate('transactions.created_at', '>=', $start_date)
                                                    ->whereDate('transactions.created_at', '<=', $end_date) 
                                                    ->where('type', 'retur')
                                                    ->orderBy('transactions.created_at','desc')
                                                    ->paginate($pagination);
            }
            else
            {
                $transactions['cash'] = Transaction::whereDate('transactions.created_at', '>=', $start_date)
                                                    ->whereDate('transactions.created_at', '<=', $end_date)
                                                    ->where('payment', 'cash')
                                                    ->whereRaw('money_paid >= total_sum_price')
                                                    ->where('role', $role)
                                                    ->where('role_id', $role_id)
                                                    ->where('type', 'normal')
                                                    ->orderBy('transactions.created_at','desc')
                                                    ->paginate($pagination);

                $transactions['retur'] = Transaction::whereDate('transactions.created_at', '>=', $start_date)
                                                    ->whereDate('transactions.created_at', '<=', $end_date) 
                                                    ->where('type', 'retur')
                                                    ->where('role', $role)
                                                    ->where('role_id', $role_id)
                                                    ->orderBy('transactions.created_at','desc')
                                                    ->paginate($pagination);
            }
        }

        return [$sub_total, $transactions];
    }

    public function storeTransactionBase($role, $role_id, Request $request)
    {
        $hpp = 0;
        $sum = 0;

        if($request->member_name != null)
        {
            $data_member_new['name'] = $request->member_name;

            $member = Member::where('name', $request->member_name)->first();

            if($member == null)
                $member = Member::create($data_member_new);

            $data_transaction['member_id'] = $member->id;
        }
        else
        {
            $data_transaction['member_id'] = $request->member_id;
        }

        #tabel transaction
        // if(sizeof($request->barcodesretur_s) > 1)
        // {
        //     $data_transaction['type'] = 'retur'; 
        // }
        // else
        // {
            $data_transaction['type'] = $request->type;
        // }
        $data_transaction['role'] = $role;
        $data_transaction['role_id'] = $role_id;
        $data_transaction['total_item_price'] = unformatNumber($request->total_item_price);
        $data_transaction['total_discount_price'] = unformatNumber($request->total_discount_price);
        $data_transaction['total_sum_price'] = unformatNumber($request->total_sum_price);
        $data_transaction['money_paid'] = unformatNumber($request->money_paid);
        $data_transaction['money_returned'] = unformatNumber($request->money_returned);
        $data_transaction['store']   = 'emas pak tani demak';
        $data_transaction['payment'] = 'cash';
        $data_transaction['note']    = $request->note;

        $transaction = Transaction::create($data_transaction);

        #tabel transaction detail
        $data_detail['transaction_id'] = $transaction->id;

        for ($i = 0; $i < sizeof($request->barcodes); $i++) 
        { 
            if($request->barcodes[$i] != null)
            {
                $good_unit = GoodUnit::find($request->barcodes[$i]);
                $data_detail['good_unit_id']   = $good_unit->id;
                $data_detail['type']           = $request->type;
                $data_detail['quantity']       = $request->quantities[$i];
                $data_detail['real_quantity']  = $request->quantities[$i] * $good_unit->unit->quantity;
                $data_detail['last_stock']     = $good_unit->good->getStock();
                $data_detail['gold_price']     = unformatNumber($request->gold_prices[$i]);
                $data_detail['buy_price']      = ($data_detail['gold_price'] * $good_unit->good->weight * $good_unit->good->percentage->nominal * $good_unit->good->percentage->profit) + checkNull($good_unit->good->change_status_fee);
                $data_detail['selling_price']  = unformatNumber($request->prices[$i]);
                $data_detail['discount_price'] = unformatNumber($request->discounts[$i]);
                $data_detail['stone_price']    = unformatNumber($request->stone_prices[$i]);
                $data_detail['sum_price']      = unformatNumber($request->sums[$i]);

                TransactionDetail::create($data_detail);

                $sum += $data_detail['sum_price'];
                $hpp += $data_detail['buy_price'] * $data_detail['quantity'];
            }
        }

        #tabel journal transaksi
        // if($request->payment == 'cash')
        // {
            $data_journal['debit_account_id']   = Account::where('code', '1111')->first()->id;
        // }
        // elseif($request->payment == 'transfer')
        // {
        //     $data_journal['debit_account_id']   = Account::where('code', '1112')->first()->id;
        // }
        $journal = Journal::whereDate('journal_date', date('Y-m-d'))
                          ->where('type', 'transaction')
                          ->where('debit_account_id', $data_journal['debit_account_id'])
                          ->first();

        if($journal != null)
        {
            $data_journal['debit'] = floatval($journal->debit) + floatval($sum);
            $data_journal['credit'] = floatval($journal->credit) + floatval($sum);

            $journal->update($data_journal);
        }
        else
        {
            $data_journal['type']               = 'transaction';
            $data_journal['journal_date']       = date('Y-m-d');
            $data_journal['name']               = 'Penjualan tanggal ' . displayDate(date('Y-m-d'));
            $data_journal['debit']              = $sum;
            $data_journal['credit_account_id']  = Account::where('code', '4101')->first()->id;
            $data_journal['credit']             = $sum;

            Journal::create($data_journal);
        }

        #tabel journal hpp
        $hpp_journal = Journal::whereDate('journal_date', date('Y-m-d'))->where('type', 'hpp')->first();

        if($hpp_journal != null)
        {
            $data_hpp['debit'] = floatval($hpp_journal->debit) + floatval($hpp);
            $data_hpp['credit'] = floatval($hpp_journal->credit) + floatval($hpp);

            $hpp_journal->update($data_hpp);
        }
        else
        {
            $data_hpp['type']               = 'hpp';
            $data_hpp['journal_date']       = date('Y-m-d');
            $data_hpp['name']               = 'Penjualan tanggal ' . displayDate(date('Y-m-d'));
            $data_hpp['debit_account_id']   = Account::where('code', '5101')->first()->id;
            $data_hpp['debit']              = $hpp;
            $data_hpp['credit_account_id']  = Account::where('code', '1141')->first()->id;
            $data_hpp['credit']             = $hpp;

            Journal::create($data_hpp);
        }

        #tabel journal piutang
        if($data_transaction['money_paid'] < $data_transaction['total_sum_price'])
        {
            if($request->payment == 'cash')
            {
                $data_piutang['credit_account_id']   = Account::where('code', '1111')->first()->id;
            }
            elseif($request->payment == 'transfer')
            {
                $data_piutang['credit_account_id']   = Account::where('code', '1112')->first()->id;
            }
            $piutang = Journal::whereDate('journal_date', date('Y-m-d'))
                              ->where('type', 'piutang')
                              ->where('name', 'like', 'Piutang dagang member ' . $transaction->member->name . ' (ID member ' . $transaction->member->id . ') %')
                              ->where('credit_account_id', $data_piutang['credit_account_id'])
                              ->first();

            if($piutang != null)
            {
                $data_piutang['name']   = $piutang->name . ', ' . $transaction->id;
                $data_piutang['debit']  = floatval($piutang->debit) + floatval($data_transaction['total_sum_price']);
                $data_piutang['credit'] = floatval($piutang->credit) + floatval($data_transaction['total_sum_price']);

                $piutang->update($data_piutang);
            }
            else
            {
                $data_piutang['type']               = 'piutang';
                $data_piutang['journal_date']       = date('Y-m-d');
                $data_piutang['name']               = 'Piutang dagang member ' . $transaction->member->name . ' (ID member ' . $transaction->member->id . ') -> ID transaksi ' . $transaction->id;
                $data_piutang['debit_account_id']   = Account::where('code', '1131')->first()->id;
                $data_piutang['debit']              = $data_transaction['total_sum_price'];
                $data_piutang['credit']             = $data_transaction['total_sum_price'];

                Journal::create($data_piutang);
            }

            if($data_transaction['money_paid'] > 0)
            {
                if($request->payment == 'cash')
                {
                    $data_piutang_member['debit_account_id']   = Account::where('code', '1111')->first()->id;
                }
                elseif($request->payment == 'transfer')
                {
                    $data_piutang_member['debit_account_id']   = Account::where('code', '1112')->first()->id;
                }
                $data_member['member_id']    = $transaction->member_id;
                $data_member['payment_date'] = date('Y-m-d');
                $data_member['money']        = $data_transaction['money_paid'];

                $payment = PiutangPayment::create($data_member);

                $piutang = Journal::whereDate('journal_date', date('Y-m-d'))
                                  ->where('type', 'piutang_transaction')
                                  ->where('name', 'Pembayaran piutang member ' . $payment->member->name . ' (ID ' . $payment->member->id . ')')
                                  ->where('debit_account_id', $data_piutang_member['debit_account_id'])
                                  ->first();

                if($piutang != null)
                {
                    $data_piutang_member['debit'] = floatval($piutang->debit) + floatval($data_transaction['money_paid']);
                    $data_piutang_member['credit'] = floatval($piutang->credit) + floatval($data_transaction['money_paid']);

                    $piutang->update($data_piutang_member);
                }
                else
                {
                    $data_piutang_member['type']               = 'piutang_transaction';
                    $data_piutang_member['journal_date']       = date('Y-m-d');
                    $data_piutang_member['name']               = 'Pembayaran piutang member ' . $payment->member->name . ' (ID ' . $payment->member->id . ')';
                    $data_piutang_member['debit']              = $data_transaction['money_paid'];
                    $data_piutang_member['credit_account_id']  = Account::where('code', '1131')->first()->id;
                    $data_piutang_member['credit']             = $data_transaction['money_paid'];

                    Journal::create($data_piutang_member);
                }
            }
        }

        #tabel transaction detail retur
        // $is_retur = false;
        // $data_detail_retur['transaction_id'] = $transaction->id;
        // $sum_retur = 0;
        // $hpp_retur = 0;

        // for ($i = 0; $i < sizeof($request->barcodesretur_s); $i++) 
        // { 
        //     if($request->barcodesretur_s[$i] != null)
        //     {
        //         $good_unit_retur = GoodUnit::find($request->barcodesretur_s[$i]);
        //         $data_detail_retur['good_unit_id']   = $request->barcodesretur_s[$i];
        //         $data_detail_retur['type']           = $data_transaction['type'];
        //         $data_detail_retur['quantity']       = $request->quantitiesretur_s[$i];
        //         $data_detail_retur['real_quantity']  = $request->quantitiesretur_s[$i] * $good_unit_retur->unit->quantity;
        //         $data_detail_retur['buy_price']      = unformatNumber($request->buy_pricesretur_s[$i]);
        //         $data_detail_retur['selling_price']  = unformatNumber($request->pricesretur_s[$i]);
        //         $data_detail_retur['discount_price'] = unformatNumber($request->discountsretur_s[$i]);
        //         $data_detail_retur['sum_price']      = unformatNumber($request->sumsretur_s[$i]);

        //         TransactionDetail::create($data_detail_retur);

        //         $sum_retur += $data_detail_retur['sum_price'];
        //         $hpp_retur += $data_detail_retur['buy_price'] * $data_detail_retur['quantity'];

        //         $is_retur = true;

        //         $good = Good::find($request->namesretur_s[$i]);

        //         if($request->conditionsretur_s[$i] == 'rusak') #barang rusak
        //         {
        //             for($j = 0; $j < $data_detail_retur['real_quantity']; $j++)
        //             {
        //                 $data_retur['good_id'] = $request->namesretur_s[$i];
        //                 $data_retur['last_distributor_id'] = $good->getLastBuy()->good_loading->distributor->id;

        //                 ReturItem::create($data_retur);
        //             }
        //         }
        //         else #barang gak rusak
        //         {
        //             $data_loading['role']         = $role;
        //             $data_loading['role_id']      = $role_id;
        //             $data_loading['checker']      = 'Load by sistem';
        //             $data_loading['loading_date'] = date('Y-m-d');
        //             $data_loading['distributor_id']   = $good->getLastBuy()->good_loading->distributor->id;
        //             $data_loading['total_item_price'] = unformatNumber($request->buy_pricesretur_s[$i]) * $request->quantitiesretur_s[$i];
        //             $data_loading['note']             = 'Loading barang retur';
        //             $data_loading['payment']          = $request->payment;

        //             $good_loading = GoodLoading::create($data_loading);

        //             $data_detail['good_loading_id'] = $good_loading->id;
        //             $data_detail['good_unit_id']    = $good->getPcsSellingPrice()->id;
        //             $data_detail['last_stock']      = $good->getStock();
        //             $data_detail['quantity']        = $request->quantitiesretur_s[$i];
        //             $data_detail['real_quantity']   = $data_detail_retur['real_quantity'];
        //             $data_detail['price']           = unformatNumber($request->buy_pricesretur_s[$i]);
        //             $data_detail['selling_price']   = unformatNumber($request->pricesretur_s[$i]);
        //             $data_detail['expiry_date']     = null;

        //             GoodLoadingDetail::create($data_detail);

        //             if($request->payment == 'cash')
        //             {
        //                 $account = Account::where('code', '1111')->first();
        //             }
        //             elseif($request->payment == 'transfer')
        //             {
        //                 $account = Account::where('code', '1112')->first();
        //             }

        //             $data_journal_loading_retur['type']               = 'good_loading';
        //             $data_journal_loading_retur['journal_date']       = date('Y-m-d');
        //             $data_journal_loading_retur['name']               = 'Loading barang retur (ID transaksi ' . $transaction->id . ') tanggal ' . displayDate(date('Y-m-d'));
        //             $data_journal_loading_retur['debit_account_id']   = Account::where('code', '1141')->first()->id;
        //             $data_journal_loading_retur['debit']              = unformatNumber($data_loading['total_item_price']);
        //             $data_journal_loading_retur['credit_account_id']  = $account->id;
        //             $data_journal_loading_retur['credit']             = unformatNumber($data_loading['total_item_price']);

        //             Journal::create($data_journal_loading_retur);
        //         }
        //     }
        // }

        // if($is_retur)
        // {
        //     #tabel journal transaksi retur
        //     if($request->payment == 'cash')
        //     {
        //         $data_journal_retur['credit_account_id']   = Account::where('code', '1111')->first()->id;
        //     }
        //     elseif($request->payment == 'transfer')
        //     {
        //         $data_journal_retur['credit_account_id']   = Account::where('code', '1112')->first()->id;
        //     }

        //     $data_journal_retur['type']               = 'retur';
        //     $data_journal_retur['journal_date']       = date('Y-m-d');
        //     $data_journal_retur['name']               = 'Retur barang ID transaksi ' . $transaction->id . ' tanggal ' . displayDate(date('Y-m-d'));
        //     $data_journal_retur['debit_account_id']   = Account::where('code', '1141')->first()->id;
        //     $data_journal_retur['debit']              = unformatNumber($sum_retur);
        //     $data_journal_retur['credit']             = unformatNumber($sum_retur);

        //     Journal::create($data_journal_retur);
        // }

        return $transaction;
    }

    public function reverseTransactionBase($role, $role_id, $transaction_id)
    {
        $transaction = Transaction::find($transaction_id);

        foreach($transaction->details as $detail)
        {
            $good = $detail->good_unit->good;

            $data_loading['role']         = $role;
            $data_loading['role_id']      = $role_id;
            $data_loading['checker']      = "Created by system";
            $data_loading['loading_date'] = date('Y-m-d');
            $data_loading['distributor_id']   = $good->getLastBuy()->good_loading->distributor_id;
            $data_loading['total_item_price'] = $detail->quantity * $detail->buy_price;
            $data_loading['note']             = "Reverse transaction id " . $transaction->id;
            $data_loading['payment']          = "cash";

            $good_loading = GoodLoading::create($data_loading);

            $data_detail['good_loading_id'] = $good_loading->id;
            $data_detail['good_unit_id']    = $detail->good_unit->id;
            $data_detail['last_stock']      = $good->getStock();
            $data_detail['quantity']        = $detail->quantity;
            $data_detail['real_quantity']   = $detail->real_quantity;
            $data_detail['price']           = $detail->buy_price;
            $data_detail['selling_price']   = $detail->selling_price;

            GoodLoadingDetail::create($data_detail);

            $data_journal['type']               = 'good_loading';
            $data_journal['journal_date']       = date('Y-m-d');
            $data_journal['name']               = 'Loading reverse transaction (id ' . $transaction->id . ') ' . $good_loading->distributor->name . ' tanggal ' . displayDate($good_loading->loading_date);
            $data_journal['debit_account_id']   = Account::where('code', '4101')->first()->id;
            $data_journal['debit']              = unformatNumber($good_loading->total_item_price);
            $data_journal['credit_account_id']  = Account::where('code', '1111')->first()->id;
            $data_journal['credit']             = unformatNumber($good_loading->total_item_price);

            Journal::create($data_journal);

            $data_hpp['type']               = 'hpp';
            $data_hpp['journal_date']       = date('Y-m-d');
            $data_hpp['name']               = 'Penjualan reverse transaction (id ' . $transaction->id . ') ' . $good_loading->distributor->name . ' tanggal ' . displayDate($good_loading->loading_date);
            $data_hpp['debit_account_id']   = Account::where('code', '1141')->first()->id;
            $data_hpp['debit']              = unformatNumber($good_loading->total_item_price);
            $data_hpp['credit_account_id']  = Account::where('code', '5101')->first()->id;
            $data_hpp['credit']             = unformatNumber($good_loading->total_item_price);

            Journal::create($data_hpp);
        }

        $data_transaction['type'] = 'not valid';
        $transaction->update($data_transaction);

        return true;
    }

    public function resumeTransactionBase($category_id, $distributor_id, $start_date, $end_date)
    {
        if($category_id == 'all' && $distributor_id == 'all')
        {
            $total = TransactionDetail::whereDate('transaction_details.created_at', '>=', $start_date)
                                      ->whereDate('transaction_details.created_at', '<=', $end_date) 
                                      ->get();

            $transaction_details = TransactionDetail::join('good_units', 'good_units.id', 'transaction_details.good_unit_id')
                                                    ->join('goods', 'goods.id', 'good_units.good_id')
                                                    ->join('units', 'units.id', 'good_units.unit_id')
                                                    ->select(DB::raw("goods.code, goods.name, units.name as unit_name, SUM(transaction_details.quantity) as quantity, transaction_details.buy_price, transaction_details.selling_price"))
                                                    ->whereDate('transaction_details.created_at', '>=', $start_date)
                                                    ->whereDate('transaction_details.created_at', '<=', $end_date) 
                                                    ->groupBy('goods.code')
                                                    ->groupBy('goods.name')
                                                    ->groupBy('units.name')
                                                    ->groupBy('transaction_details.buy_price')
                                                    ->groupBy('transaction_details.selling_price')
                                                    ->orderBy('quantity', 'desc')
                                                    ->get();
        }
        else if($category_id == 'all')
        {
            $total = TransactionDetail::join('good_units', 'good_units.id', 'transaction_details.good_unit_id')
                                      ->join('goods', 'goods.id', 'good_units.good_id')
                                      ->whereDate('transaction_details.created_at', '>=', $start_date)
                                      ->whereDate('transaction_details.created_at', '<=', $end_date) 
                                      ->where('goods.last_distributor_id', $distributor_id)
                                      ->get();

            $transaction_details = TransactionDetail::join('good_units', 'good_units.id', 'transaction_details.good_unit_id')
                                                    ->join('goods', 'goods.id', 'good_units.good_id')
                                                    ->join('units', 'units.id', 'good_units.unit_id')
                                                    ->select(DB::raw("goods.code, goods.name, units.name as unit_name, SUM(transaction_details.quantity) as quantity, transaction_details.buy_price, transaction_details.selling_price"))
                                                    ->whereDate('transaction_details.created_at', '>=', $start_date)
                                                    ->whereDate('transaction_details.created_at', '<=', $end_date) 
                                                    ->where('goods.last_distributor_id', $distributor_id)
                                                    ->groupBy('goods.code')
                                                    ->groupBy('goods.name')
                                                    ->groupBy('units.name')
                                                    ->groupBy('transaction_details.buy_price')
                                                    ->groupBy('transaction_details.selling_price')
                                                    ->orderBy('quantity', 'desc')
                                                    ->get();
        }
        else
        {   
            $total = TransactionDetail::join('good_units', 'good_units.id', 'transaction_details.good_unit_id')
                                      ->join('goods', 'goods.id', 'good_units.good_id')
                                      ->whereDate('transaction_details.created_at', '>=', $start_date)
                                      ->whereDate('transaction_details.created_at', '<=', $end_date) 
                                      ->where('goods.last_distributor_id', $distributor_id)
                                      ->where('goods.category_id', $category_id)
                                      ->get();

            $transaction_details = TransactionDetail::join('good_units', 'good_units.id', 'transaction_details.good_unit_id')
                                                    ->join('goods', 'goods.id', 'good_units.good_id')
                                                    ->join('units', 'units.id', 'good_units.unit_id')
                                                    ->select(DB::raw("goods.code, goods.name, units.name as unit_name, SUM(transaction_details.quantity) as quantity, transaction_details.buy_price, transaction_details.selling_price"))
                                                    ->where('goods.category_id', $category_id)
                                                    ->where('goods.last_distributor_id', $distributor_id)
                                                    ->whereDate('transaction_details.created_at', '>=', $start_date)
                                                    ->whereDate('transaction_details.created_at', '<=', $end_date) 
                                                    ->groupBy('goods.code')
                                                    ->groupBy('goods.name')
                                                    ->groupBy('units.name')
                                                    ->groupBy('transaction_details.buy_price')
                                                    ->groupBy('transaction_details.selling_price')
                                                    ->orderBy('quantity', 'desc')
                                                    ->get();
        }

        return [$transaction_details, $total];
    }

    public function resumeTotalTransactionBase($start_date, $end_date)
    {
        $transactions['normal'] = Transaction::whereDate('transactions.created_at', '>=', $start_date)
                                            ->whereDate('transactions.created_at', '<=', $end_date) 
                                            ->where('type', 'normal')
                                            ->get();

        $transactions['retur'] = Transaction::whereDate('transactions.created_at', '>=', $start_date)
                                            ->whereDate('transactions.created_at', '<=', $end_date) 
                                            ->where('type', 'retur')
                                            ->get();

        $transactions['not_valid'] = Transaction::whereDate('transactions.created_at', '>=', $start_date)
                                            ->whereDate('transactions.created_at', '<=', $end_date) 
                                            ->where('type', 'not valid')
                                            ->get();

        $transactions['internal'] = Transaction::whereDate('transactions.created_at', '>=', $start_date)
                                            ->whereDate('transactions.created_at', '<=', $end_date) 
                                            ->where('type', '!=', 'normal')
                                            ->where('type', '!=', 'retur')
                                            ->where('type', '!=', 'not valid')
                                            ->get();

        $transactions['other_payment'] = Journal::where('type', 'like', '%_payment%')
                                        ->whereDate('journals.journal_date', '>=', $start_date)
                                        ->whereDate('journals.journal_date', '<=', $end_date) 
                                        ->get();

        $transactions['other_transaction'] = Journal::where('type', 'like', '%_transaction')
                                        ->whereDate('journals.journal_date', '>=', $start_date)
                                        ->whereDate('journals.journal_date', '<=', $end_date) 
                                        ->get();   

        return $transactions;                             
    }

    public function storeMoneyTransactionBase(Request $request)
    {
        $data_journal['type']               = 'cash_draw';
        $data_journal['journal_date']       = date('Y-m-d');
        $data_journal['name']               = 'Pengambilan uang tanggal ' . date('Y-m-d');
        $data_journal['debit_account_id']   = Account::where('code', '1113')->first()->id;
        $data_journal['debit']              = unformatNumber($request->money);
        $data_journal['credit_account_id']  = Account::where('code', '1111')->first()->id;
        $data_journal['credit']             = unformatNumber($request->money);

        Journal::create($data_journal);

        return true;
    }
}