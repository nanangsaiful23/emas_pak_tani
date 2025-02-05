@extends('layout.user', ['role' => 'cashier', 'title' => 'Cashier'])

@section('content')

  <div class="content-wrapper">
    @if(sizeof($server_payment) > 0)
      <div class="alert alert-danger alert-dismissible" id="message">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-warning"></i> Guna pelayanan yang maksimal, harap melakukan pembayaran tagihan server maksimal tanggal 20 pada setiap bulannya.<br>Status pembayaran saat ini adalah: tertunda {{ $server_payment->count() }} bulan sejak {{ $server_payment[0]->month_due }}</h4>
      </div>
    @endif
    <section class="content-header">
      <h1>
        Hi, {{ \Auth::user()->name }}<br>
        Selamat datang di aplikasi {{ config('app.name') }}<br>
        <small>Anda login sebagai Kasir</small>
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12 col-sm-4">
          <div class="small-box" style="background-color: #DFF5FF">
            <div class="inner">
              <h3>{{ showRupiah($transactions['cash']->sum('total_sum_price') + $transactions['credit']->sum('money_paid') + $transactions['retur']->sum('total_sum_price') + $other_transactions->sum('debit')) }}</h3>

              <p>
                Rincian Transaksi {{ displayDate(date('Y-m-d')) }}
              </p>
            </div>
            <div class="icon">
              <span><img src="{{asset('assets/icon/shopping-cart.png')}}" style="width: 80px"></span>
            </div>
            <a href="{{ url('/admin/transaction/all/all/' . date('Y-m-d') . '/' . date('Y-m-d') . '/20') }}" class="small-box-footer" target="_blank()">Daftar Transaksi <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection
