<div class="content-wrapper">

  @include('layout' . '.error')
  @include('layout' . '.alert-message', ['type' => $default['type'], 'data' => $default['data'], 'color' => $default['color']])

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> {{ $default['page_name'] }}</h3>
            @include('layout.search-form')
          </div>
          <div class="box-body" style="overflow-x:scroll; color: black !important">
            <h3>Total emas cokim: {{ getCokimWeight() }} gram</h3>
            {!! Form::model(old(),array('url' => route($role . '.lebur.sell'), 'enctype'=>'multipart/form-data', 'method' => 'POST', 'class' => 'form-horizontal')) !!}
              <div class="box-body">
                <div class="panel-body" style="color: black !important;">
                  <div class="row">
                      <div class="form-group">
                          {!! Form::label('weight', 'Berat Emas Cokim', array('class' => 'col-sm-12')) !!}
                          <div class="col-sm-5">
                            {!! Form::text('weight', null, array('class' => 'form-control')) !!}
                          </div>
                      </div>

                      <div class="form-group">
                          {!! Form::label('selling_price', 'Harga Jual Emas Cokim', array('class' => 'col-sm-12')) !!}
                          <div class="col-sm-5">
                            {!! Form::text('selling_price', null, array('class' => 'form-control', 'id' => 'selling_price', 'onkeyup' => 'formatNumber("selling_price")')) !!}
                          </div>
                      </div>
                      
                      <div class="form-group">
                          {{ csrf_field() }}
                          <div class="col-sm-5">
                              <hr>
                              {!! Form::submit('Jual Emas Cokim', ['class' => 'btn form-control'])  !!}
                          </div>
                      </div>
                    </div>
                </div>
              </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@section('js-addon')
  <script type="text/javascript">
    $(document).ready(function(){
      
        $("#search-input").keyup( function(e){
          if(e.keyCode == 13)
          {
            ajaxFunction();
          }
        });

        $("#search-btn").click(function(){
            ajaxFunction();
        });
    });

    function formatNumber(name)
    {
        num = document.getElementById(name).value;
        num = num.toString().replace(/,/g,'');
        document.getElementById(name).value = num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    }

    function unFormatNumber(num)
    {
        return num.replace(/,/g,'');
    }
  </script>
@endsection