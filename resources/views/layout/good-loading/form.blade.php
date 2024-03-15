<style type="text/css">
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: rgb(60, 141, 188) !important;
    }
</style>

<div class="panel-body">
    <?php $goods = getGoods() ?>
    <?php $distributors = getDistributors() ?>
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group col-sm-12">
                @if($type == 'buy-other')
                    {!! Form::label('distributor_id', 'Nama penjual emas', array('class' => 'col-sm-4 control-label')) !!}
                @else
                    {!! Form::label('distributor_id', 'Nama penjual emas/sales', array('class' => 'col-sm-4 control-label')) !!}
                @endif
                <div class="col-sm-8">
                    @if($SubmitButtonText == 'View')
                        {!! Form::text('distributor', null, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                    @else
                        <input type="text" name="distributor_name" class="form-control" id="distributor_name" placeholder='isi kolom jika nama tidak ada di list'>
                        <select class="form-control select2" style="width: 100%;" name="distributor_id" id="all_distributor">
                            <div>
                                @if($type == 'buy-other')
                                    <option value="null">Silahkan pilih nama penjual emas</option>
                                @else
                                    <option value="null">Silahkan pilih nama penjual emas/sales</option>
                                @endif
                                @foreach($distributors as $distributor)
                                <option value="{{ $distributor->id }}">
                                    {{ $distributor->name }}</option>
                                @endforeach
                            </div>
                        </select>
                    @endif
                </div>
            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('loading_date', 'Tanggal Pembelian', array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    <div class="input-group date">
                        <input type="text" class="form-control pull-right" required="required" name="loading_date" id="loading_date">
                    </div>
                </div>
            </div>
        </div>
       <div class="col-sm-7">
            {!! Form::label('note', 'Catatan', array('class' => 'col-sm-1 left control-label')) !!}
            <div class="col-sm-12">
                <input type="text" name="note" class="form-control" id="note">
            </div>
            {!! Form::label('checker', 'Nama Pengecek Barang', array('class' => 'col-sm-12 control-label', 'style' => 'text-align: left')) !!}
            <div class="col-sm-12">
                <input type="text" name="checker" class="form-control" id="checker">
            </div>
            <!-- {!! Form::label('payment', 'Jenis Pembayaran', array('class' => 'col-sm-12 control-label', 'style' => 'text-align: left')) !!}
            <div class="col-sm-12">
                <select class="form-control select2" style="width: 100%;" name="payment">
                    <div>
                        <option value="1111">1111 - Kas di Tangan</option>
                        <option value="1112">1112 - Kas di Bank</option>
                        <option value="2101">2101 - Utang Dagang</option>
                    </div>
                </select>
            </div> -->
       </div>
    </div>

    @if($type == 'buy-other' || $type == 'loading')
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-add" style="background-color: #FF7B54 !important;"><h4 >Tambah Barang yang Dibeli</h4></button>
        <div class="modal fade" id="modal-add">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Barang yang Dibeli</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {!! Form::label('category_id', 'Kategori', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::select('category_id', getCategories(), null, ['class' => 'form-control select2',
                                'style'=>'width: 100%', 'id' => 'category_id']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('is_old_gold', 'Jenis Emas', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::select('is_old_gold', getGoldTypes(), null, ['class' => 'form-control select2',
                                'style'=>'width: 100%', 'id' => 'is_old_gold']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('name', 'Nama Barang', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('name', null, array('class' => 'form-control','required'=>'required', 'id' => 'name')) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('description', 'Deskripsi Barang', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::textarea('description', null, array('class' => 'form-control', 'id' => 'description', 'style' => 'height: 40px')) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('percentage_id', 'Persentase', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::select('percentage_id', getPercentages(), null, ['class' => 'form-control select2',
                                'style'=>'width: 100%', 'id' => 'percentage_id']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('weight', 'Berat Emas', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('weight', null, array('class' => 'form-control', 'required'=>'required', 'id' => 'weight', 'placeholder' => '0.00')) !!}<br>Koma menggunakan simbol .
                            </div>
                        </div>

                        @if($type == 'buy-other')
                            <div class="form-group">
                                {!! Form::label('status', 'Status Barang', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!! Form::select('status', getStatusOther(), null, ['class' => 'form-control select2',
                                    'style'=>'width: 100%', 'id' => 'status']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('gold_history_number', 'History Barang', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!! Form::select('gold_history_number', getGoldHistoryNumber(), null, ['class' => 'form-control select2', 'style'=>'width: 100%', 'id' => 'gold_history_number']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('price', 'Harga Beli', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <textarea type="text" name="price" class="form-control" id="price" onkeypress="formatNumber('price')"></textarea>
                                </div>
                            </div>
                        @elseif($type == 'loading')
                            <div class="form-group">
                                {!! Form::label('status', 'Status Barang', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                {!! Form::text('status', 'Siap dijual', array('class' => 'form-control', 'required'=>'required', 'id' => 'status', 'readonly' => 'readonly')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('gold_history_number', 'History Barang', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                {!! Form::hidden('gold_history_number', '0') !!}
                                {!! Form::text('gold_history_number_show', 'Kulak pertama', array('class' => 'form-control',  'readonly' => 'readonly')) !!}
                                </div>
                            </div>
                            {!! Form::hidden('price', '1', array('id' => 'price')) !!}
                        @else
                            <div class="form-group">
                                {!! Form::label('status', 'Status Barang', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!! Form::select('status', getStatus(), null, ['class' => 'form-control select2',
                                    'style'=>'width: 100%', 'id' => 'status']) !!}
                                </div>
                            </div>
                        @endif
                        
                        <div class="form-group">
                            {!! Form::label('stone_weight', 'Berat Batu', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('stone_weight', '0.00', array('class' => 'form-control', 'id' => 'stone_weight', 'placeholder' => '0.00')) !!}<br>Koma menggunakan simbol .
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('stone_price', 'Harga Batu', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('stone_price', 0, array('class' => 'form-control', 'id' => 'stone_price', 'placeholder' => 'Boleh Kosong', 'onkeyup' => 'formatNumber("stone_price")')) !!}
                            </div>
                        </div>

                        <!-- div class="form-group">
                            {!! Form::label('file', 'File', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-3">
                                {!! Form::file('file', NULL, array('class' => 'form-control', 'id' => 'file')) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <input name="is_profile_picture" type="checkbox" value="1" checked="checked" id="is_profile_picture"> Jadikan gambar utama
                            </div>
                        </div> -->
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <div onclick="event.preventDefault(); addNewGood()" class='btn btn-success btn-flat btn-block form-control' data-dismiss="modal">Input Barang Beli</div>
              </div>
            </div>
          </div>
        </div>
    @endif

    <h4>Resume {{ $default['page_name'] }}</h4>
    <div class="row">
        @if($type == 'buy')
            <div class="form-group col-sm-5">
                {!! Form::label('all_barcode', 'Cari barcode', array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    <input type="text" name="all_barcode" class="form-control" id="all_barcode"
                        onchange="searchByBarcode()">
                </div>
            </div>
            <div class="form-group col-sm-7">
                {!! Form::label('all_name', 'Cari nama barang', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    <select class="form-control select2" style="width: 100%;" name="items" id="all_name"
                        onchange="searchItemByName()">
                        <div>
                            <option value="null">Silahkan pilih barang</option>
                            @foreach($goods as $good)
                            <option value="{{ $good->id }}">{{ $good->name . ' ' }}</option>
                            @endforeach
                        </div>
                    </select>
                </div>
            </div>
        @endif
        <div class="form-group col-sm-12" style="overflow-x:scroll">
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Barcode</th>
                    <th>Nama</th>
                    <th style="display: none">Jumlah</th>
                    <th>Persentase</th>
                    <th>Berat</th>
                    <th>Status Barang</th>
                    @if($type == 'buy-other')
                        <th>Harga Beli</th>
                    @endif
                    <th style="display: none">Total Harga</th>
                    <th style="display: none">Harga Jual</th>
                    <th>Berat Batu</th>
                    <th>Harga Batu</th>
                    <th>Hapus</th>
                </thead>
                <tbody id="table-transaction">
                    <?php $i = 1; ?>
                    <tr id="row-data-{{ $i }}">
                        <td>
                            <textarea type="text" name="barcodes[]" class="form-control" id="barcode-{{ $i }}" style="height: 70px"></textarea>
                        </td>
                        <td width="20%">
                            {!! Form::textarea('name_temps[]', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'name_temp-'.$i, 'style' => 'height: 70px')) !!}
                            {!! Form::text('names[]', null, array('id'=>'name-' . $i, 'style' => 'display:none')) !!}
                        </td>
                        <td style="display: none">
                            <textarea type="text" name="quantities[]" class="form-control" id="quantity-{{ $i }}"
                                onchange="editPrice('{{ $i }}')" onkeypress="editPrice('{{ $i }}')"></textarea>
                        </td>
                        <td>
                            {!! Form::select('percentages[]', getPercentages(), null, ['class' => 'form-control select2', 'style'=>'width: 100%', 'id' => 'percentage-' . $i]) !!}
                        </td>
                        <td>
                            <textarea type="text" name="weights[]" class="form-control" id="weight-{{ $i }}"></textarea>
                        </td>
                        <td>
                            @if($type == 'loading')
                                <textarea type="text" name="statuses[]" class="form-control" id="status-{{ $i }}" readonly="readonly">Siap dijual</textarea>
                            @else
                                {!! Form::select('statuses[]', getStatusOther(), null, ['class' => 'form-control select2','required'=>'required', 'style'=>'width:100%', 'id' => 'status-' . $i]) !!}
                            @endif
                        </td>
                        @if($type == 'buy-other')
                            <td>
                                 <textarea type="text" name="prices[]" class="form-control" id="price-{{ $i }}"
                                    onchange="editPrice('{{ $i }}')" onkeypress="editPrice('{{ $i }}')"></textarea>
                            </td>
                            <td style="display: none;">
                                {!! Form::textarea('total_prices[]', null, array('class' => 'form-control', 'readonly' =>
                                'readonly', 'id' => 'total_price-'.$i, 'style' => 'height: 70px')) !!}
                            </td>
                        @elseif($type == 'loading')
                            <td style="display: none;">
                                 <textarea type="text" name="prices[]" class="form-control" id="price-{{ $i }}"
                                    onchange="editPrice('{{ $i }}')" onkeypress="editPrice('{{ $i }}')"></textarea>
                            </td>
                            <td style="display: none;">
                                {!! Form::textarea('total_prices[]', null, array('class' => 'form-control', 'readonly' =>
                                'readonly', 'id' => 'total_price-'.$i, 'style' => 'height: 70px')) !!}
                            </td>
                        @endif
                        <td>
                            <textarea type="text" name="stone_weights[]" class="form-control" id="stone_weight-{{ $i }}"></textarea>
                        </td>
                        <td>
                             <textarea type="text" name="stone_prices[]" class="form-control" id="stone_price-{{ $i }}"
                                onchange="editPrice('{{ $i }}')" onkeypress="editPrice('{{ $i }}')"></textarea>
                        </td>
                        <td style="display: none">
                            {!! Form::textarea('selling_prices[]', null, array('class' => 'form-control', 'id' => 'selling_price-'.$i, 'style' => 'height: 70px')) !!}
                        </td>
                        <td><i class="fa fa-times red" id="delete-{{ $i }}" onclick="deleteItem('{{ $i }}')"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="form-group">
            {!! Form::label('total_item_price', 'Total Harga', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-3">
                {!! Form::text('total_item_price', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id'
                => 'total_item_price')) !!}
            </div>
        </div>
        {!! Form::hidden('type', $type) !!}
    </div>

    {{ csrf_field() }}

    <hr>
    @if($SubmitButtonText == 'Edit')
    {!! Form::submit($SubmitButtonText, ['class' => 'btn btn-warning btn-flat btn-block form-control']) !!}
    @elseif($SubmitButtonText == 'Tambah')
    <div onclick="event.preventDefault(); submitForm();" class='btn btn-success btn-flat btn-block form-control'>Proses Beli</div>
    @elseif($SubmitButtonText == 'View')
    @endif
</div>

{!! Form::close() !!}

@section('js-addon')
<script type="text/javascript">
    var total_item = 1;
    var total_real_item=0;
          $(document).ready (function (){
              $('.select2').select2();
              $("#all_barcode").focus();
                $('#loading_date').datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    todayHighlight: true
                });
          });

          function fillItem(good,index)
          {
              var bool = false;

              if(good.length != 0)
              {
                  document.getElementById("name-" + total_item).value = good.id;
                  document.getElementById("name_temp-" + total_item).value = good.name;
                  document.getElementById("barcode-" + total_item).value = good.code;
                  $("#price-" + total_item).val(good.getPcsSellingPrice.buy_price);
                  document.getElementById("quantity-" + total_item).value = 1;
                  $("#percentage-" + total_item).val(good.percentage_id).change();
                  document.getElementById("weight-" + total_item).value = good.weight;
                  document.getElementById("stone_weight-" + total_item).value = good.stone_weight;
                  document.getElementById("stone_price-" + total_item).value = good.stone_price;
                  $("#status-" + total_item).val(good.status).change();
                  document.getElementById("old_stock-" + total_item).value = good.old_stock;
                  document.getElementById("new_stock-" + total_item).value = parseInt(good.old_stock) + 1;

                  editPrice(total_item);
                  total_real_item += 1;
                  document.getElementById("all_barcode").value = '';
              }
              else
              {
                  alert('Barang tidak ditemukan');
                  document.getElementById("barcode-" + index).value = '';
                  document.getElementById("name-" + index).focus();
              }
          }

          function addNewGood()
          {
              var isi=true;
              if($("#category_id").val()==""){
                isi=false;
                alert("silahkan pilih kategori");
              }
              if($("#name").val()==""){
                isi=false;
                alert("silahkan isi nama");
              }
              if($("#percentage_id").val()==""){
                isi=false;
                alert("silahkan isi persentase");
              }
              if($("#weight").val()==""){
                isi=false;
                alert("silahkan isi berat");
              }
              if($("#status").val()=="" || $("#status").val() == 'all'){
                isi=false;
                alert("silahkan isi status");
              }
              // console.log($("#file").val());
              if(isi){
              $.ajax({
                url: "{!! url($role . '/good/store/') !!}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    role: '{{ $role }}',
                    category_id: $("#category_id").val(),
                    is_old_gold: $("#is_old_gold").val(),
                    name: $("#name").val(),
                    description: $("#description").val(),
                    percentage_id: $("#percentage_id").val(),
                    weight: $("#weight").val(),
                    stone_weight: $("#stone_weight").val(),
                    stone_price: $("#stone_price").val(),
                    price: $("#price").val(),
                    gold_history_number: $("#gold_history_number").val(),
                    status: $("#status").val(),
                    // file: $("#file").val(),
                    // is_profile_picture: $("#is_profile_picture").val(),
                },
                success: function(result){
                    $("#name-" + total_item).val(result.good.id);
                    $("#barcode-" + total_item).val(result.good.code);
                    $("#name_temp-" + total_item).val(result.good.name);
                    $("#percentage-" + total_item).val(result.good.percentage_id).change();
                    $("#weight-" + total_item).val(result.good.weight);
                    $("#stone_weight-" + total_item).val(result.good.stone_weight);
                    $("#stone_price-" + total_item).val(result.good.stone_price);
                    $("#quantity-" + total_item).val("1");
                    $("#price-" + total_item).val(result.good.price);
                    // $("#selling_price-" + total_item).val(result.good.selling_price);
                    $("#status-" + total_item).val(result.good.status).change();
                    // $("#old_stock-" + total_item).val(0);

                    editPrice(total_item);

                    total_real_item+=1;

                    $("#code").val("");
                    $("#name").val("");
                    $("#description").val("");
                    // $("#price").val("");
                    // $("#selling_price").val("");
                    // $("#percentage").val("");
                    $("#weight").val("");
                    $("#stone_weight").val("");
                    $("#stone_price").val("");
                    // $("#status").val("");
                },
                error: function(){
                    // console.log('error');
                }
              });
              };
          }

          function searchByBarcode()
          {

              $.ajax({
                url: "{!! url($role . '/good/searchByBarcode/') !!}/" + $("#all_barcode").val(),
                success: function(result){
                  var good = result.good;
                  var index=-1;

                  fillItem(result.good,index)},
                error: function(){
                }
              });
          }


          function searchItemByName()
          {
              $.ajax({
                url: "{!! url($role . '/good/searchById/') !!}/" + $("#all_name").val(),
                success: function(result){
                    var index=-1;
                    var r = result.units;

                    for (var i = 0; i < r.length; i++) {
                        const getPcsSellingPrice = {unit_id: r[i].unit_id, buy_price: r[i].buy_price, selling_price: r[i].selling_price};
                        const good = {id: r[i].good_id, name: r[i].name, code: r[i].code, percentage_id: r[i].percentage_id, weight: r[i].weight, stone_weight: r[i].stone_weight, stone_price: r[i].stone_price, getPcsSellingPrice: getPcsSellingPrice, old_stock: r[i].stock, status: r[i].status};
                        
                        fillItem(good,index);
                    }
                },
                error: function(){
                }
              });
          }

          function checkQuantity(index)
          {
              $.ajax({
                url: "{!! url($role . '/good/checkQuantity/') !!}/" + $("#name-" + index).val() + '/' + $("#quantity-" + index).val(),
                success: function(result){
                  var status = result.status;

                  if(status == 'ok')
                  {
                      // changePrice(index);
                  }
                  else
                  {
                      alert('Barang tidak mencukupi');
                  }
                },
                error: function(){
                }
              });
          }

          function changeFocus(index)
          {
              $("#barcode-" + index).focus();
          }

          function changeTotal()
          {
              total_item_price = parseInt(0);
              total_promo_price = parseInt(0);
              for (var i = 1; i <= total_item; i++)
              {
                  if(document.getElementById("barcode-" + i))
                  {
                      if(document.getElementById("barcode-" + i).value != '')
                      {
                          money = document.getElementById("total_price-" + i).value;
                          money = money.replace(/,/g,'');
                          stone = document.getElementById("stone_price-" + i).value;
                          stone = stone.replace(/,/g,'');
                          console.log(money + ' ' + stone);
                          total_item_price += parseInt(money) + parseInt(stone);

                      }
                  }
              }

              document.getElementById("total_item_price").value = total_item_price;

              formatNumber("total_item_price");

          }

          function changeTotalSum()
          {
              if(document.getElementById("total_discount_price").value == '')
              {
                  // alert("Silahkan isi potongan harga");
              }
              else
              {
                  changeTotal();

                  total = document.getElementById("total_sum_price").value;
                  total = total.replace(/,/g,'');

                  discount = document.getElementById("total_discount_price").value;
                  discount = discount.replace(/,/g,'');
                  total_sum_price = parseInt(total) - parseInt(discount);

                  document.getElementById("total_sum_price").value = total_sum_price;
                  formatNumber("total_sum_price");

                  changeReturn();
              }
          }

          function submitForm()
          {
              var isi=true;
              if ( $("#distributor").val()==""){
                isi=false;
                alert("silahkan isi distributor");
              }
              if ( $("#loading_date").val()==""){
                isi=false;
                alert("silahkan isi tanggal pembelian");
              }
              if(total_real_item == 0)
              {
                  alert('Silahkan pilih barang');
                  isi=false;
              }
              if(isi)
              {
                  document.getElementById('loading-form').submit();
                  // alert('hay');
              }

          }

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
          function deleteItem(index)
          {
              $("#row-data-" + index).remove();
              total_real_item-=1;
              changeTotal();
          }
          function editPrice(index)
          {
            if(document.getElementById("price-" + index).value == 1)
            {
                document.getElementById("total_price-" + index).value = 0;
            }
            else
            {
                document.getElementById("total_price-" + index).value = unFormatNumber(document.getElementById("price-" + index).value);
            }

              formatNumber("total_price-" + index);

              changeTotal();
              temp1=parseInt(index)+1
              htmlResult = '<tr id="row-data-' + temp1+ '"><td><textarea type="text" name="barcodes[]" class="form-control" id="barcode-' + temp1+ '" onchange="searchName(' + temp1+ ')"></textarea></td><td width="20%"><textarea  class="form-control" readonly="readonly" id="name_temp-' + temp1+ '" name="name_temps[]" type="text" style="height: 70px"></textarea><textarea id="name-' + temp1 + '" name="names[]" type="text" style="display:none"></textarea></td><td style="display: none"><textarea type="text" name="quantities[]" class="form-control" id="quantity-' + temp1+'" onkeypress="editPrice(' + temp1+')" onchange="editPrice(' + temp1+ ')"></textarea></td><td><select class="form-control select2" id="percentage-' + temp1 + '" name="percentages[]">@foreach(getPercentageObjects() as $percentage)<option value="{{ $percentage->id }}">{{ $percentage->name }}</option> @endforeach </select></td><td><textarea class="form-control" id="weight-' + temp1 + '" name="weights[]" type="text"></textarea></td><td>@if($type == "loading")<textarea id="status-' + temp1 + '" name="statuses[]" type="text" readonly="readonly" class="form-control">Siap dijual</textarea>@else<select class="form-control select2" id="status-' + temp1 + '" name="statuses[]">@foreach(getStatusOther() as $status)<option value="{{ $status }}">{{ $status }}</option>@endforeach</select>@endif</td>@if($type == "buy-other")<td><textarea type="text" name="prices[]" class="form-control" id="price-' + temp1+'" onkeypress="editPrice(' + temp1+')" onchange="editPrice(' + temp1+ ')"></textarea></td><td style="display: none"><textarea class="form-control" readonly="readonly" id="total_price-' + temp1+ '" name="total_prices[]" type="text"></textarea></td>@endif<td style="display: none"><textarea class="form-control" id="selling_price-' + temp1+ '" name="selling_prices[]" type="text"></textarea></td>@if($type == "loading")<td style="display: none"><textarea type="text" name="prices[]" class="form-control" id="price-' + temp1+'" onkeypress="editPrice(' + temp1+')" onchange="editPrice(' + temp1+ ')"></textarea></td><td style="display: none"><textarea class="form-control" readonly="readonly" id="total_price-' + temp1+ '" name="total_prices[]" type="text"></textarea></td>@endif<td><textarea class="form-control" id="stone_weight-' + temp1 + '" name="stone_weights[]" type="text"></textarea></td><td><textarea class="form-control" id="stone_price-' + temp1 + '" name="stone_prices[]" type="text"></textarea></td><td><i class="fa fa-times red" id="delete-' + temp1+'" onclick="deleteItem('
              + temp1+ ')"></i></td></tr>';
              htmlResult += "<script>$('#percentage-" + temp1 + "').select2();@if($type != 'loading')$('#status-" + temp1 + "').select2();@endif<\/script>";
              if(index == total_item)
              {
                  total_item += 1;
                  $("#table-transaction").prepend(htmlResult);
              }

          }
</script>
@endsection
