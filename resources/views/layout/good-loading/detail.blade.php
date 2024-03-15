<div class="content-wrapper">
  @include('layout' . '.error')

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> Form Detail Loading</h3>
          </div>

          {!! Form::model($good_loading, array('class' => 'form-horizontal')) !!}
            <div class="box-body">
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group">
                            {!! Form::label('distributor_id', 'Distributor', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('distributor', $good_loading->distributor->name, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                            </div>

                        </div>
                        <div class="form-group">
                            {!! Form::label('loading_date', 'Tanggal Pembelian', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('loading_date', displayDate($good_loading->loading_date), array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('note', 'Catatan', array('class' => 'col-sm-2 left control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('note', null, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('checker', 'PIC Check Barang', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('checker', null, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('total_item_price', 'Total Harga', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('total_item_price', showRupiah($good_loading->total_item_price), array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-12" style="overflow-x:scroll">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Barcode</th>
                                <th>Nama</th>
                                <th>Berat</th>
                                <th>Persentase</th>
                                <th>Status Barang</th>
                                @if($good_loading->type != 'loading')
                                    <th>Harga Beli</th>
                                @endif
                                <th>Berat Batu</th>
                                <th>Harga Batu</th>
                            </thead>
                            <tbody>
                                @foreach($good_loading->detailsWithDeleted() as $detail)
                                    <tr @if($detail->good->deleted_at != null) style="background-color: red" @endif>
                                        <td>
                                            <a href="{{ url($role . '/good/' . $detail->good->id . '/loading/2023-01-01/' . date('Y-m-d') . '/10') }}" class="btn" target="_blank()">
                                            {{ $detail->good->code }}</a>
                                        </td>
                                        <td>
                                            {{ $detail->good->name }}
                                        </td>
                                        <td>
                                            {{ $detail->good->weight }} gram
                                        </td>
                                        <td>
                                            {{ $detail->good->percentage->name }}
                                        </td>
                                        <td>
                                            {{ $detail->good->status }}
                                        </td>
                                        @if($good_loading->type != 'loading')
                                            <td style="text-align: right;">
                                                {{ showRupiah($detail->price) }}
                                            </td>
                                        @endif
                                        <td>
                                            @if($detail->good->stone_weight != '0.00')
                                                {{ $detail->good->stone_weight }} gram
                                            </td>
                                            <td>
                                                {{ showRupiah($detail->good->stone_price) }}
                                            @else
                                                Tidak ada batu
                                            </td>
                                            <td>
                                                Tidak ada harga batu
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {!! Form::close() !!}

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
