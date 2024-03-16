@extends('layout.user', ['role' => 'admin', 'title' => 'Admin'])

@section('content')

  <style type="text/css">
    .box
    {
      border: solid 2px white;
    }

    .small-box:hover, .small-box>a
    {
      color: black !important;
    }
  </style>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Hi, {{ \Auth::user()->name }}<br>
        Selamat datang di aplikasi {{ config('app.name') }}<br>
        <small>Anda login sebagai Admin</small>
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12 col-sm-4">
          <div class="small-box" style="background-color: #DFF5FF">
            <div class="inner">
              @if(isset($gold_price))
                <h3>{{ showRupiah($gold_price->selling_price) }}</h3>

                <p>Harga jual emas {{ displayDate($gold_price->created_at) }}</p>
              @else
                <h3>-</h3>

                <p>Belum ada harga emas</p>
              @endif
            </div>
            <div class="icon">
              <span><img src="{{asset('assets/icon/indonesian-rupiah.png')}}" style="width: 80px"></span>
            </div>
            <a href="{{ url('/admin/gold-price/create') }}" class="small-box-footer" target="_blank()">Tambah harga emas <i class="fa fa-arrow-circle-right"></i></a></a>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4">
          <div class="small-box" style="background-color: #DFF5FF">
            <div class="inner">
              <h3>{{ getCokimWeight() }} gram</h3>

              <p>Total emas cokim</p>
            </div>
            <div class="icon">
              <span><img src="{{asset('assets/icon/ingots.png')}}" style="width: 80px"></span>
            </div>
            <a href="{{ url('/admin/lebur/history/sellOngoing/20') }}" class="small-box-footer" target="_blank()">Riwayat Lebur Cokim <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
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
        <div class="col-xs-12 col-sm-4">
          <div class="small-box" style="background-color: #FFE6E6">
            <div class="inner">
              <h3>{{ getGram('AT', 'Siap dijual')->sum('weight') }} gram</h3>

              <p>Total asset anting/cuplik</p>
            </div>
            <div class="icon">
              <span><img src="{{asset('assets/icon/earings.png')}}" style="width: 80px"></span>
            </div>
            <a href="{{ url('/admin/gold-price/create') }}" class="small-box-footer" target="_blank()"></a>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4">
          <div class="small-box" style="background-color: #FFE6E6">
            <div class="inner">
              <h3>{{ getGram('CC', 'Siap dijual')->sum('weight') }} gram</h3>

              <p>Total asset cincin</p>
            </div>
            <div class="icon">
              <span><img src="{{asset('assets/icon/diamond-ring.png')}}" style="width: 80px"></span>
            </div>
            <a href="{{ url('/admin/gold-price/create') }}" class="small-box-footer" target="_blank()"></a>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4">
          <div class="small-box" style="background-color: #FFE6E6">
            <div class="inner">
              <h3>{{ getGram('GL', 'Siap dijual')->sum('weight') }} gram</h3>

              <p>Total asset gelang</p>
            </div>
            <div class="icon">
              <span><img src="{{asset('assets/icon/bracelet.png')}}" style="width: 80px"></span>
            </div>
            <a href="{{ url('/admin/gold-price/create') }}" class="small-box-footer" target="_blank()"></a>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4">
          <div class="small-box" style="background-color: #FFE6E6">
            <div class="inner">
              <h3>{{ getGram('KL', 'Siap dijual')->sum('weight') }} gram</h3>

              <p>Total asset kalung</p>
            </div>
            <div class="icon">
              <span><img src="{{asset('assets/icon/necklace.png')}}" style="width: 80px"></span>
            </div>
            <a href="{{ url('/admin/gold-price/create') }}" class="small-box-footer" target="_blank()"></a>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4">
          <div class="small-box" style="background-color: #FFE6E6">
            <div class="inner">
              <h3>{{ getGram('LT', 'Siap dijual')->sum('weight') }} gram</h3>

              <p>Total asset liontin</p>
            </div>
            <div class="icon">
              <span><img src="{{asset('assets/icon/pendant.png')}}" style="width: 80px"></span>
            </div>
            <a href="{{ url('/admin/gold-price/create') }}" class="small-box-footer" target="_blank()"></a>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection
