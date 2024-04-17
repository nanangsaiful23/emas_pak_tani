<style type="text/css">
  .select2-container--default .select2-selection--multiple .select2-selection__choice
  {
    background-color: rgb(60, 141, 188) !important;
  }
  select {
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    font-style: normal;
  }
  </style>

<div class="content-wrapper">

  @include('layout' . '.alert-message', ['type' => $default['type'], 'data' => $default['data'], 'color' => $default['color']])

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{ $default['page_name'] }}</h3>
            <h5 id="total"></h5>
          </div>
          <div class="box-body">
            {!! Form::model(old(),array('url' => route($role . '.print-barcode'), 'method' => 'POST', 'id' => 'print-form')) !!}
              <div class="form-group">
                <select class="form-control select2" data-placeholder="Silahkan pilih barang" style="width: 100%;" onchange="changeDiv()" id="good-list">
                  <div>
                    <option value="">Silahkan pilih barang</option>
                    @foreach(getGoodUnits() as $good)
                      <option value="{{ $good->id . ';;;' . date('Y') . $good->good->getBarcode() . ';;;<b>' . $good->good->name . '</b>;;;' . $good->good->weight . ';;;<b>' . $good->good->code . '</b>;;;' . $good->good->is_old_gold . ';;;' . $good->good->stone_weight . ';;;' . $good->good->stone_price }}">@if($good->is_barcode_printed == '1') [v] @endif {{ $good->good->name . ' (' . $good->good->code . ')' }}</option>
                    @endforeach
                  </div>
                </select>
              </div>
              <?php $i = 1; ?>
              <div id="div-result"></div>
              <div id="row-data-{{ $i }}" style="display: none;">
                <div class="col-sm-6" style="border: solid 1px">
                  <svg class="col-sm-12" id="barcode-{{ $i }}"></svg><br>
                  <div class="form-group col-sm-12" style="text-align: center;" id="code-{{ $i }}" name="codes[]" ></div>
                  <div class="form-group col-sm-12" style="text-align: center; margin-top: -30px" id="weight-{{ $i }}" name="weights[]" ></div>
                  <div class="form-group col-sm-12" style="text-align: center; margin-top: -30px" id="stone_weight-{{ $i }}" name="stone_weights[]" ></div>
                  <div class="form-group col-sm-12" style="text-align: center; margin-top: -30px" id="stone_price-{{ $i }}" name="stone_prices[]" ></div>
                  <div class="form-group col-sm-2">
                    <input type="text" id="id-{{ $i }}" name="ids[]" class="form-control" placeholder="id" readonly style="display: none;">
                  </div>
                  <div class="form-group col-sm-3">
                    <input type="text" id="quantity-{{ $i }}" name="quantities[]" class="form-control" onchange="addElement('{{ $i }}')" placeholder="jumlah" style="display: none">
                  </div>
                  <div class="form-group col-sm-3 btn" onclick="deleteItem({{ $i }})" >
                    <i class="fa fa-times" style="color: red"></i> Batal
                  </div>
                </div>
              </div>
            {!! Form::close() !!}
          </div> 
          <div onclick="event.preventDefault(); submitForm(this);" class= 'btn btn-success btn-flat btn-block form-control' style="height: 80px; font-size: 40px;">Print</div>
        </div>
      </div>
    </div>
  </section>
</div>

@section('js-addon')
  <script src="{{asset('assets/bower_components/JsBarcode.code39.min.js')}}"></script>
  <script src="{{asset('assets/bower_components/JsBarcode.ean-upc.min.js')}}"></script>
  <script type="text/javascript">
    var total_item = 1;
    var real_item = 1;

    $(document).ready(function(){
      $('.select2').select2();

    });

    function changeDiv()
    {
      $('#row-data-' + total_item).show();
      var good = $("#good-list").val().split(";;;");
      if(good != null)
      {
        var code = good[1];
        JsBarcode("#barcode-" + total_item, code, {
          format: "UPC",
          // lineColor: "#0aa",
          width: 3,
          height: 60,
          displayValue: false
        });
      }
      $("#id-" + total_item).val(good[0]);
      $("#barcode-" + total_item).val(good[1]);
      $("#name-" + total_item).html(good[2]);
      $("#code-" + total_item).html(good[4]);
      $("#quantity-" + total_item).val(1);
      if(good[5] == '1')
        $("#weight-" + total_item).html("<h3>MT " + good[3] + "GR</h3>");
      else
        $("#weight-" + total_item).html("<h3>" + good[3] + "GR</h3>");
      $("#stone_weight-" + total_item).html("{{ config('app.store_name') }}");
      // if(good[6] != '0.00' && good[6] != '' && good[6] != null && good[6] != '0')
      // {
      //   $("#stone_weight-" + total_item).html("<h5>BATU " + good[6] + "GR</h5>");
      //   $("#stone_price-" + total_item).html("<h5>ONGKOS " + good[7] + "</h5>");
      // }
      
      addElement(total_item);
      total_item += 1;
      real_item += 1;
    }

    function addElement(index)
    {
      index = parseInt(index) + 1;
      index = index.toString();
      htmlResult = '<div id="row-data-' + index + '" style="display:none;"><div class="col-sm-6" style="border: solid 1px"><svg class="col-sm-12" id="barcode-' + index + '"></svg><div class="form-group col-sm-12" id="code-' + index + '" style="text-align: center;" name="codes[]"></div><div class="form-group col-sm-12" id="weight-' + index + '" style="text-align: center; margin-top: -30px" name="weights[]"></div><div class="form-group col-sm-12" id="stone_weight-' + index + '" style="text-align: center; margin-top: -30px" name="stone_weights[]"></div><div class="form-group col-sm-12" id="stone_price-' + index + '" style="text-align: center; margin-top: -30px" name="stone_prices[]"></div><div class="form-group col-sm-2"><input type="text" id="id-' + index + '" name="ids[]" class="form-control" placeholder="id" readonly style="display: none;"></div><div class="form-group col-sm-3"><input type="text" id="quantity-' + index + '" name="quantities[]" class="form-control" style="display: none"></div><div onclick="deleteItem(\'' + index + '\')" class="form-group col-sm-3 btn"><i class="fa fa-times" style="color: red"></i> Batal</div></div>';

      $("#div-result").prepend(htmlResult);
    }

    function deleteItem(index)
    {
      $("#row-data-" + index).remove();
      real_item -= 1;
    }

    function submitForm(btn)
    {
        if(real_item % 2 == 1)
        {
          btn.disabled = true;
          document.getElementById('print-form').submit();
        }
        else
        {
            alert('Silahkan pilih jumlah barang kelipatan 2');
        }
    }
  </script>
@endsection