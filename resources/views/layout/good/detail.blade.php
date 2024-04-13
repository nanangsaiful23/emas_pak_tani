<div class="content-wrapper">
  @include('layout' . '.error')

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div style="text-align: center;">
                </div>
                <hr>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-3" style="background-color: #F0EBE3; height: 250px; border: solid 2px #F0EBE3; border-radius: 5px; text-align: center;">
                            @if($good->profilePicture() != null)
                                <img src="{{ URL::to('/image/' . $good->profilePicture()->location) }}" style="height: 200px;"><br>
                            @endif
                            <a href="{{ url($role . '/good/' . $good->id . '/photo/create') }}"><i class="fa fa-camera"></i><br>Tambah Foto</a><br>
                        </div>
                        <div class="col-sm-4" style="text-align: right;">
                            <small>nama </small><br><span style="font-size: 25px; text-transform: capitalize;">{{ $good->name }}</span><br>
                            <small>kode </small><br><span style="font-size: 15px">{{ $good->code }}</span><br>
                            <small>persentase </small><br><span style="font-size: 20px">{{ $good->percentage->name }}</span><br>
                            <small>berat </small><br><span style="font-size: 20px">{{ $good->weight }}gram</span><br>
                            @if($good->getStock() > 0) <h4>{{ $good->status }}</h4> @else Sudah terjual @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        @if($role == 'admin')
                          <a href="{{ url($role . '/good/' . $good->id . '/edit') }}" class="btn btn-info btn-flat btn-block form-control" target="_blank()">Ubah Data Barang</a>
                          <a href="{{ url($role . '/good/' . $good->id . '/transaction/2018-01-01/' . date('Y-m-d') . '/10') }}" class="btn btn-flat btn-block form-control back-pink white" target="_blank()">Lihat Riwayat Penjualan Barang</a>
                          <a href="{{ url($role . '/good/' . $good->id . '/loading/2018-01-01/' . date('Y-m-d') . '/10') }}" class="btn btn-success btn-flat btn-block form-control" target="_blank()">Lihat Riwayat Loading Barang</a>
                        @endif
                      <a href="{{ url($role . '/good/all/all/Siap dijual/20') }}" class="btn btn-success btn-flat btn-block form-control" target="_blank()">Kembali ke Daftar Barang</a>
                      <!-- <a href="{{ url($role . '/good/' . $good->id . '/price/10') }}" class="btn btn-danger btn-flat btn-block form-control" target="_blank()">Lihat Riwayat Pricing Barang</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </section>
</div>

<style type="text/css">
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: rgb(60, 141, 188) !important;
    }
</style>
@section('js-addon')
@endsection
