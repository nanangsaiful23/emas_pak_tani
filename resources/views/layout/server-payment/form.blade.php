<div class="panel-body" style="color: black !important;">
    <div class="row">
        <div class="form-group">
            {!! Form::label('month_due', 'Tanggal Tagihan', array('class' => 'col-sm-12')) !!}
            <div class="col-sm-3">
                @if($SubmitButtonText == 'View')
                    {!! Form::text('month_due', null, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                @else
                    <div class="input-group date">
                        <input type="text" class="form-control pull-right" required="required" name="month_due" id="month_due" @if($SubmitButtonText == 'Edit') value="{{ $server_payment->month_due }}" @endif>
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('month_pay', 'Tanggal Pembayaran', array('class' => 'col-sm-12')) !!}
            <div class="col-sm-3">
                @if($SubmitButtonText == 'View')
                    {!! Form::text('month_pay', null, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                @else
                    <div class="input-group date">
                        <input type="text" class="form-control pull-right" name="month_pay" id="month_pay" @if($SubmitButtonText == 'Edit') value="{{ $server_payment->month_pay }}" @endif>
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('nominal', 'Nominal', array('class' => 'col-sm-12')) !!}
            <div class="col-sm-3">
                @if($SubmitButtonText == 'View')
                    {!! Form::text('nominal', null, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                @else
                    <input type="text" name="nominal" class="form-control" id="nominal" onkeyup="formatNumber('nominal')" @if($SubmitButtonText == 'Edit') value="{{ $server_payment->nominal }}" @endif></input>
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
                @elseif($SubmitButtonText == 'View')
                    <a href="{{ url($role . '/server-payment/' . $server_payment->id . '/edit') }}" class="btn form-control">Ubah Data Tagihan Pembayaran</a>
                @endif
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}

@section('js-addon')
    <script type="text/javascript">
        
        $(document).ready(function(){            
            $('#month_due').datepicker({
              autoclose: true,
              format: 'yyyy-mm-dd'
            })

            $('#month_pay').datepicker({
              autoclose: true,
              format: 'yyyy-mm-dd'
            })

        });

          function formatNumber(name)
          {
              num = document.getElementById(name).value;
              num = num.toString().replace(/,/g,'');
              document.getElementById(name).value = num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
          }
    </script>
@endsection