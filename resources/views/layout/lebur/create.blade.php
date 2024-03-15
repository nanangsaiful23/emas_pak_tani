<div class="content-wrapper">

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
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Nama</th>
                <th width="20%">Berat</th>
                <th>Harga Beli</th>
                <th width="10%" class="center">Pilih</th>
              </tr>
              </thead>
            {!! Form::model(old(),array('url' => route($role . '.lebur.store'), 'enctype'=>'multipart/form-data', 'method' => 'POST', 'class' => 'form-horizontal')) !!}
              <tbody id="table-good">
                <?php $i = 1; ?>
                @foreach($lebures as $lebur)
                  <tr>
                    <td>{{ $lebur->name }}</td>
                    <td><input type="text" name="weights[]" id="weight-{{ $i }}" value="{{ $lebur->weight }}" readonly style="border: 0px; text-align: right;"> gram</td>
                    <td><input type="text" name="prices[]" id="price-{{ $i }}" value="{{ printRupiah($lebur->getPcsSellingPrice()->buy_price) }}" readonly style="border: 0px; text-align: right;"></td>
                    <td class="center"><input type="checkbox" name="leburs[]" id="lebur-{{ $i }}" value="{{ $lebur->id }}" onchange="changeResume()"></td>
                  </tr>
                  <?php $i++ ?>
                @endforeach
              </tbody>
            </table>
            <div id="resume">
            </div>
              <div class="box-body" id="form-lebur">
                <div class="panel-body" style="color: black !important;">
                  <div class="row">
                      <!-- <div class="form-group col-sm-12">
                          {!! Form::label('weight', 'Berat Emas Hasil Lebur', array('class' => 'col-sm-12')) !!}
                          <div class="col-sm-5">
                            {!! Form::text('weight', null, array('class' => 'form-control')) !!}
                          </div>
                      </div> -->
                      
                      <div class="form-group col-sm-12">
                          {{ csrf_field() }}
                          <div class="col-sm-5">
                              <hr>
                              {!! Form::submit('Lebur Emas', ['class' => 'btn form-control'])  !!}
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
        $("#form-lebur").hide();
    });

    function formatNumber(num)
    {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    }

    function unFormatNumber(num)
    {
        return num.replace(/,/g,'');
    }

    function changeResume()
    {
      $("#form-lebur").show();
      total = {{ $lebures->count()}};
      total_weight = 0;
      total_price = 0;

      for(i = 1; i <= total; i++)
      {
        if($('#lebur-' + i).is(":checked"))
        {
          total_weight += parseFloat($('#weight-' + i).val());
          total_price += parseFloat(unFormatNumber($('#price-' + i).val()));
        }
      }
      $('#resume').html("<h3>Total berat: " + total_weight + " gram<br><h3>Total harga: Rp" + formatNumber(total_price));
    }
  </script>
@endsection