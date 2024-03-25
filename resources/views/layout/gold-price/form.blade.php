<div class="panel-body" style="color: black !important;">
    <div class="row">
        <!-- <div class="form-group">
            {!! Form::label('weight', 'Berat', array('class' => 'col-sm-12')) !!}
            <div class="col-sm-5">
                @if($SubmitButtonText == 'View')
                    {!! Form::text('weight', null, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                @else
                    {!! Form::text('weight', null, array('class' => 'form-control')) !!}
                @endif
            </div>
        </div> -->

        <div class="form-group">
            {!! Form::label('buy_price', 'Harga Beli', array('class' => 'col-sm-12')) !!}
            <div class="col-sm-5">
                @if($SubmitButtonText == 'View')
                    {!! Form::text('buy_price', null, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                @else
                    {!! Form::text('buy_price', null, array('class' => 'form-control', 'required'=>'required', 'id' => 'buy_price', 'onkeyup' => 'formatNumber("buy_price")')) !!}
                @endif
            </div>
        </div>

       <!--  <div class="form-group">
            {!! Form::label('selling_price', 'Harga Jual', array('class' => 'col-sm-12')) !!}
            <div class="col-sm-5">
                @if($SubmitButtonText == 'View')
                    {!! Form::text('selling_price', null, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                @else
                    {!! Form::text('selling_price', null, array('class' => 'form-control', 'required'=>'required', 'id' => 'selling_price', 'onkeyup' => 'formatNumber("selling_price")')) !!}
                @endif
            </div>
        </div> -->

       <!--  <div class="form-group">
            {!! Form::label('percentage', 'Persentase/Karat', array('class' => 'col-sm-12')) !!}
            <div class="col-sm-5">
                @if($SubmitButtonText == 'View')
                    {!! Form::text('percentage', null, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                @else
                    {!! Form::text('percentage', null, array('class' => 'form-control')) !!}
                @endif
            </div>
        </div> -->
        
        <div class="form-group">
            {{ csrf_field() }}

            <div class="col-sm-5">
                <hr>
                @if($SubmitButtonText == 'Edit')
                    {!! Form::submit($SubmitButtonText, ['class' => 'btn form-control'])  !!}
                @elseif($SubmitButtonText == 'Tambah')
                    {!! Form::submit($SubmitButtonText, ['class' => 'btn form-control'])  !!}
                @elseif($SubmitButtonText == 'View')
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