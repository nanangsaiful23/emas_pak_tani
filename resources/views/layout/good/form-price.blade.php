<div class="panel-body" style="color: black !important;">
    <div class="row">
        @foreach($good->good_units as $unit)
            {{ Form::hidden('good_unit_ids[]', $unit->id) }}
            <!-- <div class="form-group">
                {!! Form::label('units[]', 'Satuan', array('class' => 'col-sm-12')) !!}
                <div class="col-sm-5">
                    {!! Form::text('units[]', $unit->unit->name, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                </div>
            </div> -->
            
            <div class="form-group">
                {!! Form::label('old_selling_prices[]', 'Harga Lama', array('class' => 'col-sm-12')) !!}
                <div class="col-sm-5">
                    @if($unit->selling_price == '1')
                        {!! Form::text('old_selling_prices[]', 'Belum ada harga jual', array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                    @else
                        {!! Form::text('old_selling_prices[]', showRupiah($unit->selling_price), array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                {!! Form::label('selling_prices[]', 'Harga Baru', array('class' => 'col-sm-12')) !!}
                <div class="col-sm-5">
                    @if($SubmitButtonText == 'View')
                        {!! Form::text('selling_prices[]', null, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                    @else
                        {!! Form::text('selling_prices[]', null, array('class' => 'form-control', 'required'=>'required', 'id' => 'selling_price', 'onkeyup' => 'formatNumber("selling_price")')) !!}
                    @endif
                </div>
            </div>
        @endforeach
            <div class="form-group">
                {!! Form::label('reason', 'Alasan', array('class' => 'col-sm-12')) !!}
                <div class="col-sm-5">
                    @if($SubmitButtonText == 'View')
                        {!! Form::text('reason', null, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                    @else
                        {!! Form::text('reason', null, array('class' => 'form-control')) !!}
                    @endif
                </div>
            </div>

            <div class="form-group">
                {{ csrf_field() }}

                <div class="col-sm-5">
                    <hr>
                    @if($SubmitButtonText == 'Edit')
                        {!! Form::submit($SubmitButtonText, ['class' => 'btn form-control'])  !!}
                    @elseif($SubmitButtonText == 'Tambah')
                        {!! Form::submit($SubmitButtonText, ['class' => 'btn form-control'])  !!}
                    @endif
                </div>
            </div>
    </div>
</div>

{!! Form::close() !!}

@section('js-addon')
    <script type="text/javascript">
          function formatNumber(name)
          {
              num = document.getElementById(name).value;
              num = num.toString().replace(/,/g,'');
              document.getElementById(name).value = num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
          }
    </script>
@endsection