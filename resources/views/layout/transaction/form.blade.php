<style type="text/css">
  .select2-container--default .select2-selection--multiple .select2-selection__choice
  {
    background-color: rgb(60, 141, 188) !important;
  }

  .modal-body {
    overflow-y: auto;
    }

    .modal-content {
        /*width: 1500px;
        margin-left: -500px;*/
    }
</style>

<div class="panel-body">
    <div class="alert alert-danger alert-dismissible" id="message" style="display:none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-warning"></i> Barang kosong</h4>
            <div id="empty-item"></div>
    </div>
    <div class="row">
        <div class="form-group col-sm-5" style="height: 40px!important; font-size: 20px;">
            {!! Form::label('all_barcode', 'Cari barcode', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <input type="text" name="all_barcode" class="form-control" id="all_barcode" onchange="searchByBarcode('all_barcode')">
            </div>
        </div>
        <div class="form-group col-sm-7" style="height: 40px!important; font-size: 20px;">
            {!! Form::label('keyword', 'Cari keyword', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-8">
                <input type="text" name="search_good" class="form-control" id="search_good">
            </div>
             <div class="modal modal-primary fade" id="modal_search">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Hasil Keyword (klik nama barang)</h4>
                  </div>
                  <div class="modal-body">
                    <div id="result_good"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group col-sm-5">
                {!! Form::label('member_id', 'Member', array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    @if($SubmitButtonText == 'View')
                        {!! Form::text('member', null, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                    @else
                        {!! Form::text('member_name', null, array('class' => 'form-control', 'id' => 'member_name')) !!}
                        <select class="form-control select2" style="width: 100%;" name="member_id" id="all_member">
                            <div>
                                @foreach(getMembers() as $member)
                                <option value="{{ $member->id }}">
                                    {{ $member->name . ' (' . $member->address . ')'}}</option>
                                @endforeach
                            </div>
                        </select>
                    @endif
                </div>
            </div>
            <div class="form-group col-sm-7">
                <div class="col-sm-3 btn btn-warning" onclick="ajaxButton('anting')">Anting-anting</div>
                <div class="col-sm-3 btn btn-warning" onclick="ajaxButton('cipluk')">Cipluk</div>
                <div class="col-sm-3 btn btn-warning" onclick="ajaxButton('cincin')">Cincin</div>
                <div class="col-sm-3 btn btn-warning" onclick="ajaxButton('emas murni')">Emas murni</div>
                <div class="col-sm-3 btn btn-warning" onclick="ajaxButton('gelang')">Gelang</div>
                <div class="col-sm-3 btn btn-warning" onclick="ajaxButton('kalung')">Kalung</div>
                <div class="col-sm-3 btn btn-warning" onclick="ajaxButton('liontin')">Liontin</div>
            </div>
        </div>
        <div class="form-group col-sm-5">
            {!! Form::label('note', 'Keterangan', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                @if($SubmitButtonText == 'View')
                    {!! Form::text('note', null, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                @else
                    {!! Form::text('note', null, array('class' => 'form-control', 'style' => 'height: 70px')) !!}
                @endif
            </div>
        </div>
        <table class="table table-bordered table-striped" style="overflow-x: auto;">
            <thead>
                <th>Kode</th>
                <th>Berat</th>
                <th>Kadar</th>
                <th>Harga Emas</th>
                <th>Barang</th>
                <th style="display: none">Jumlah</th>
                <th>Jumlah</th>
                <th>Harga Batu</th>
                <th>Potongan</th>
                <th style="display: none">Total Harga</th>
                <th>Total Akhir</th>
                <th>Hapus</th>
            </thead>
            <tbody id="table-transaction">
                <?php $i = 1; ?>
                <tr id="row-data-{{ $i }}">
                    <td>
                        {!! Form::hidden('barcodes[]', null, array('id' => 'barcode-'.$i)) !!}
                        {!! Form::textarea('codes[]', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'code-'.$i, 'style' => 'height: 70px')) !!}
                    </td>
                    <td>
                        {!! Form::text('weights[]', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'weight-'.$i)) !!}
                    </td>
                    <td>
                        {!! Form::text('percentages[]', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'percentage-'.$i, 'style' => 'display:none')) !!}
                        {!! Form::text('percentage_shows[]', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'percentage_show-'.$i)) !!}
                    </td>
                    <td>
                        {!! Form::text('gold_prices[]', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'gold_price-'.$i)) !!}
                    </td>
                    <td width="10%">
                        {!! Form::textarea('name_temps[]', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'name_temp-'.$i, 'style' => 'height: 70px')) !!}
                        {!! Form::text('names[]', null, array('id'=>'name-' . $i, 'style' => 'display:none')) !!}
                    </td>
                    <td style="display: none">
                        <input type="text" name="quantities[]" class="form-control" id="quantity-{{ $i }}" onchange="checkDiscount('all_barcode', '{{ $i }}')">
                    </td>
                    <td>
                        {!! Form::text('buy_prices[]', null, array('id'=>'buy_price-' . $i, 'style' => 'display:none')) !!}
                        {!! Form::text('prices[]', null, array('class' => 'form-control', 'id' => 'price-'.$i, 'onchange' => "editPrice('" . $i . "')")) !!}
                    </td>
                    <td>
                        {!! Form::text('stone_prices[]', null, array('class' => 'form-control', 'id' => 'stone_price-'.$i, 'onchange' => "editPrice('" . $i . "')")) !!}
                    </td>
                    <td>
                        @if(\Auth::user()->email == 'admin')
                            <input type="text" name="discounts[]" class="form-control" id="discount-{{ $i }}" onchange="editPrice('{{ $i }}')">
                        @else
                            {!! Form::text('discounts[]', 0, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'discount-'.$i)) !!}
                        @endif
                    </td>
                    <td style="display: none">
                        {!! Form::text('total_prices[]', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'total_price-'.$i)) !!}
                    </td>
                    <td>
                        {!! Form::text('sums[]', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'sum-'.$i)) !!}
                    </td>
                    <td><i class="fa fa-times red" id="delete-{{ $i }}" onclick="deleteItem('-{{ $i }}')"></i></td>
                </tr>
            </tbody>
        </table>
        <div class="form-group">
            {!! Form::label('total_item_price', 'Total Harga', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-3">
                {!! Form::text('total_item_price', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'total_item_price')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('total_discount_items_price', 'Total Potongan Harga Per Barang', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-3">
                {!! Form::text('total_discount_items_price', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'total_discount_items_price')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('total_discount_price', 'Potongan Harga Akhir', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-3">
                <input type="text" name="total_discount_price" class="form-control" id="total_discount_price" onchange="changeTotal()" onkeypress="changeTotal()" required="required" onkeyup="formatNumber('total_discount_price')">
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('total_sum_price', 'Total Akhir', array('class' => 'col-sm-3 control-label', 'style' => "font-size: 40px; height: 40px;")) !!}
            <div class="col-sm-3">
                {!! Form::text('total_sum_price', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'total_sum_price', 'style' => "font-size: 40px; height: 40px;")) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('money_paid', 'Bayar', array('class' => 'col-sm-3 control-label', 'style' => "font-size: 40px; height: 40px;")) !!}
            <div class="col-sm-3">
                <input type="text" name="money_paid" class="form-control" id="money_paid" onchange="changeReturn()" onkeypress="changeReturn()" required="required" onkeyup="formatNumber('money_paid')" style="font-size: 40px; height: 40px;">
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('money_returned', 'Kembali', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-3">
                {!! Form::text('money_returned', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'money_returned')) !!}
            </div>
        </div>
        {{ Form::hidden('type', 'normal') }}
    </div>
</div>

{{ csrf_field() }}

<hr>
@if($SubmitButtonText == 'Edit')
    {!! Form::submit($SubmitButtonText, ['class' => 'btn btn-warning btn-flat btn-block form-control',])  !!}
@elseif($SubmitButtonText == 'Tambah')
    <div onclick="event.preventDefault(); submitForm(this);" class= 'btn btn-success btn-flat btn-block form-control' style="height: 80px; font-size: 40px;">Proses Transaksi</div>
@elseif($SubmitButtonText == 'View')
@endif

{!! Form::close() !!}

@section('js-addon')
    <script type="text/javascript">
        var total_item = 1;
        var total_item_retur = 1;
        $(document).ready (function (){
            $('.select2').select2();
            $("#all_barcode").focus();
            document.getElementById("total_discount_price").value = 0;

            $("#search_good").keyup( function(e){
              if(e.keyCode == 13)
              {
                ajaxFunction("all_barcode");
              }
            });

            $("#search_good_retur").keyup( function(e){
              if(e.keyCode == 13)
              {
                ajaxFunction("all_barcode_retur");
              }
            });
        });

        $('#modal_search').on('shown.bs.modal', function() {
          $('#search_good').focus();
        })

        function fillItem(name, good)
        {
            var bool = false;
            var type = '';
            var items = total_item;

            if(name == 'all_barcode_retur')
            {
                type = 'retur_s';
                items = total_item_retur;
            }

            if(good.length != 0)
            {
                for (var i = 1; i <= items; i++)
                {
                    if(document.getElementById("barcode-" + type + i))
                    {
                        if(document.getElementById("barcode-" + type + i).value != '' && document.getElementById("barcode-" + type + i).value == good.getPcsSellingPrice.id && document.getElementById("price-" + type + i).value == good.getPcsSellingPrice.selling_price)
                        {
                            // temp_total = document.getElementById("quantity-" + type + i).value;
                            // temp_total = parseInt(temp_total) + 1;
                            // document.getElementById("quantity-" + type + i).value = temp_total;
                            bool = true;

                            // editPrice(name, i);
                            break;
                        }
                    }
                }

                if(bool == false)
                {
                    document.getElementById("name-" + type + items).value = good.id;
                    document.getElementById("name_temp-" + type + items).value = good.name;
                    document.getElementById("barcode-" + type + items).value = good.getPcsSellingPrice.id;
                    document.getElementById("code-" + type + items).value = good.code;
                    document.getElementById("weight-" + type + items).value = good.weight;
                    document.getElementById("percentage-" + type + items).value = good.percentage.nominal;
                    document.getElementById("percentage_show-" + type + items).value = good.percentage.name;
                    if(good.stone_price == null || good.stone_price == "")
                        document.getElementById("stone_price-" + type + items).value = 0;
                    else
                        document.getElementById("stone_price-" + type + items).value = good.stone_price;
                    document.getElementById("quantity-" + type + items).value = 1;

                    document.getElementById("discount-" + type + items).value = '0';
                    // document.getElementById("buy_price-" + type + items).value = good.getPcsSellingPrice.buy_price;
                    // document.getElementById("total_price-" + type + items).value = good.getPcsSellingPrice.selling_price;

                    var today_gold_buy_price = parseInt('{{ getTodayGoldPrice()->buy_price }}');
                    var today_gold_selling_price = parseInt('{{ getTodayGoldPrice()->selling_price }}');

                    document.getElementById("gold_price-" + type + items).value = today_gold_selling_price;

                    document.getElementById("buy_price-" + type + items).value = document.getElementById("weight-" + type + items).value * document.getElementById("percentage-" + type + items).value * today_gold_buy_price;
                    document.getElementById("price-" + type + items).value = document.getElementById("weight-" + type + items).value * document.getElementById("percentage-" + type + items).value * today_gold_selling_price;

                    editPrice(items);

                    formatNumber("stone_price-" + type + items);
                    formatNumber("selling_price-" + type + items);
                    formatNumber("gold_price-" + type + items);

                    document.getElementById(name).value = '';
                    $("#" + name).focus();

                }
                document.getElementById(name).value = '';
                $("#" + name).focus();
            }
            else
            {
                alert('Barang tidak ditemukan');
                document.getElementById("barcode-" + type + index).value = '';
                document.getElementById("name-" + type + index).focus();
            }
        }

        function searchByKeyword(name, good_unit_id)
        {
            type = '';
            if(name == 'all_barcode_retur')
            {
                type = '_retur';
            }
            
            $.ajax({
              url: "{!! url($role . '/good/searchByGoodUnit/') !!}/" + good_unit_id,
              success: function(result){
                var good = result.good;
                if(good.stock <= 0)
                {
                    alert('Stock ' + good.name + ' kosong');
                    document.getElementById("message").style.display = "block";
                    htmlResult2 = "> " + good.name + " stock: " + good.stock + "<br>";
                    $("#empty-item").append(htmlResult2);
                }
                else
                {
                    fillItem(name, result.good);
                }
                $('#modal_search' + type).modal('hide');
                $('#search_good' + type).val('');
                $('#result_good' + type).val('');
            },
              error: function(){
              }
            });
        }

        function searchByBarcode(name) 
        {
            $.ajax({
              url: "{!! url($role . '/good/searchByBarcode/') !!}/" + $("#" + name).val(),
              success: function(result){
                var good = result.good;
                fillItem(name, result.good)},
              error: function(){
              }
            });
        }

        function checkDiscount(name_div, index)
        {
            type = '';
            if(name_div == 'all_barcode_retur')
            {
                type = 'retur_s';
            }

            good_id = document.getElementById("name-" + type + index).value;
            name = document.getElementById("name_temp-" + type + index).value;
            quantity = document.getElementById("quantity-" + type + index).value;
            price = document.getElementById("price-" + type + index).value;
            $.ajax({
              url: "{!! url($role . '/good/checkDiscount/') !!}/" + good_id + '/' + quantity + '/' + price,
              success: function(result){
                var discount = result.discount;

                document.getElementById("discount-" + type + index).value = discount;

                if(discount != '0')
                {
                    document.getElementById("row-data-" + type + index).style.background = 'green';
                }

                if(result.stock < quantity)
                {
                    document.getElementById("message").style.display = "block";
                    htmlResult2 = "> " + name + " stock: " + result.stock + "<br>";
                    $("#empty-item").append(htmlResult2);
                }

                editPrice(index);
              },
              error: function(){
              }
            });
        }

        function changeTotal()
        {
            total_item_price = parseInt(0);
            total_discount_price = parseInt(0);
            total_sum_price = parseInt(0);
            total_discount_items = parseInt(0);

            for (var i = 1; i <= total_item; i++)
            {
                if(document.getElementById("barcode-" + i))
                {
                    if(document.getElementById("barcode-" + i).value != '')
                    {
                        items = (document.getElementById("price-" + i).value * document.getElementById("quantity-" + i).value) + parseInt(unFormatNumber(document.getElementById("stone_price-" + i).value));

                        total_item_price += parseInt(items);

                        sums = document.getElementById("sum-" + i).value;
                        sums = sums.replace(/,/g,'');

                        total_sum_price += parseInt(sums);

                        discount = document.getElementById("discount-" + i).value;
                        discount = discount.replace(/,/g,'');

                        total_discount_items += parseInt(discount);
                    }
                }
            }

            for (var i = 1; i <= total_item_retur; i++)
            {
                if(document.getElementById("barcode-retur_s" + i))
                {
                    if(document.getElementById("barcode-retur_s" + i).value != '')
                    {
                        items = document.getElementById("price-retur_s" + i).value * document.getElementById("quantity-retur_s" + i).value;

                        total_item_price -= parseInt(items);

                        sums = document.getElementById("sum-retur_s" + i).value;
                        sums = sums.replace(/,/g,'');

                        total_sum_price -= parseInt(sums);

                        discount = document.getElementById("discount-retur_s" + i).value;
                        discount = discount.replace(/,/g,'');

                        total_discount_items += parseInt(discount);
                    }
                }
            }

            discount = document.getElementById("total_discount_price").value;
            discount = discount.replace(/,/g,'');
            total_sum_price = parseInt(total_sum_price) - parseInt(discount);

            document.getElementById("total_item_price").value = total_item_price;
            document.getElementById("total_discount_items_price").value = total_discount_items;
            document.getElementById("total_sum_price").value = total_sum_price;

            formatNumber("total_item_price");
            formatNumber("total_discount_items_price");
            formatNumber("total_sum_price");

            changeReturn();
        }

        function changeReturn()
        {
            total = document.getElementById("money_paid").value;
            total = total.replace(/,/g,'');

            sum = document.getElementById("total_sum_price").value;
            sum = sum.replace(/,/g,'');
            money_returned = parseInt(total) - parseInt(sum);

            document.getElementById("money_returned").value = money_returned;
            formatNumber("money_returned");
        }

        function submitForm(btn)
        {
            if($('#money_paid').val() != '' && $('#total_discount_price').val() != '')
            {
                if(parseInt(unFormatNumber($('#money_paid').val())) < parseInt(unFormatNumber($('#total_sum_price').val())) && ($('#all_member').val() == '1' && $('#member_name').val() == ''))
                {
                    alert('Jumlah pembayaran kurang dari total belanja. Silahkan pilih member');
                }
                else
                {
                    btn.disabled = true;
                    document.getElementById('transaction-form').submit();
                    // alert('hay');
                }
            }
            else
            {
                alert('Silahkan masukkan jumlah uang dan potongan toko');
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
            console.log('masuk delet');
            $("#row-data" + index).remove();
            changeTotal();
        }

        function editPrice(index)
        {
            temp1=parseInt(index)+1
            var type = '';
            
            document.getElementById("total_price-" + type + index).value = unFormatNumber(document.getElementById("price-" + type + index).value);

            document.getElementById("sum-" + type + index).value = parseInt(unFormatNumber(document.getElementById("total_price-" + type + index).value)) - parseInt(unFormatNumber(document.getElementById("discount-" + type + index).value)) + parseInt(unFormatNumber(document.getElementById("stone_price-" + type + index).value));

            formatNumber("total_price-" + type + index);
            formatNumber("sum-" + type + index);
            formatNumber("discount-" + type + index);

            changeTotal();

            htmlResult = '<tr id="row-data' + "-" + type + temp1 + '">';
            htmlResult += '<td><input type="hidden" name="barcodes[]" id="barcode-' + temp1 + '"><input type="text" name="codes' + type + '[]" class="form-control" id="code-' + type + temp1 + '" readonly="readonly"></td>';
            htmlResult += '<td><input type="text" name="weights' + type + '[]" class="form-control" id="weight-' + type + temp1+'" readonly="readonly"></td><td style="display:none"><input type="text" name="percentages' + type + '[]" class="form-control" id="percentage-' + type + temp1+'" readonly="readonly"></td>';
            htmlResult += '<td><input type="text" name="percentage_shows' + type + '[]" class="form-control" id="percentage_show-' + type + temp1+'" readonly="readonly"></td>';
            htmlResult += '<td><input type="text" name="gold_prices' + type + '[]" class="form-control" id="gold_price-' + type + temp1+'" readonly="readonly"></td>';
            htmlResult += '<td width="10%"><textarea class="form-control" readonly="readonly" id="name_temp-' + type + temp1 + '" name="name_temps' + type + '[]" type="text" style="height: 70px"></textarea><input id="name-' + type + temp1 + '" name="names' + type + '[]" type="text" style="display:none"></td>';
            htmlResult += '<td style="display: none"><input type="text" name="quantities' + type + '[]" class="form-control" id="quantity-' + type + temp1+'" onchange="checkDiscount(\'' + '\', \'' + type + temp1 + '\')"></td>';
            htmlResult += '<td><input id="buy_price-' + type + temp1 + '" name="buy_prices' + type + '[]" type="text" style="display:none"><input class="form-control" id="price-' + type +temp1 + '" name="prices' + type + '[]" type="text" onchange="editPrice(\'' + type + temp1 + '\')"></td>';
            htmlResult += '<td><input class="form-control" id="stone_price-' + type +temp1 + '" name="stone_prices' + type + '[]" type="text" onchange="editPrice(\'' + type + temp1 + '\')"></td>';
            htmlResult += '<td><input type="text" name="discounts' + type + '[]" class="form-control" id="discount-' + type + temp1+'" onchange="editPrice(\'' + type + temp1 + '\')"></td>';
            htmlResult += '<td style="display: none"><input class="form-control" readonly="readonly" id="total_price-' + type + temp1 + '" name="total_prices' + type + '[]" type="text"></td>';
            htmlResult += '<td><input class="form-control" readonly="readonly" id="sum-' + type + temp1 +'" name="sums' + type + '[]" type="text"></td>';
            htmlResult += '<td><i class="fa fa-times red" id="delete-' + type + temp1 +'" onclick="deleteItem(\'-' + type + temp1 + '\')"></i></td></tr>';
            htmlResult += "<script>$('#type-" + type + temp1 + "').select2();<\/script>";

            if(index == total_item)
            {
                total_item += 1;
                $("#table-transaction").prepend(htmlResult);
            }

            document.getElementById("all_barcode").value = '';
            $("#all_barcode").focus();

        }

        function ajaxFunction(name)
        {
            type = '';
            if(name == 'all_barcode_retur')
            {
                type = '_retur';
            }
            
            $('#modal_search' + type).modal('show');   

              $.ajax({
                url: "{!! url($role . '/good/searchByKeywordGoodUnit/') !!}/" + $("#search_good" + type).val(),
                success: function(result){
                    htmlResult = '';

                    htmlResult += "<style type='text/css'>.modal-div:hover { background-color: white; }</style>";
                  var r = result.good_units;

                  for (var i = 0; i < r.length; i++) {
                    if((i%2) == 0) 
                    {
                        color = '#FFF1CE';
                    }
                    else color = "#FDEFF4";
                    htmlResult += "<textarea class='col-sm-12 modal-div' style='display:inline-block; color:black; cursor: pointer; min-height:40px; max-height:80px; background-color:" + color + "; padding: 5px;' onclick='searchByKeyword(\"" + name + "\",\"" + r[i].good_unit_id + "\")'>" + r[i].name + "</textarea>";
                  }
                  $("#result_good" + type).html(htmlResult);
                  $('.modal-body').css('height',$( window ).height()*0.5);
                },
                error: function(){
                    console.log('error');
                }
              });
        }

        function ajaxButton(keyword)
        {
            $('#modal_search').modal('show');   
              $.ajax({
                url: "{!! url($role . '/good/searchByKeywordGoodUnit/') !!}/" + keyword,
                success: function(result){
                    htmlResult = '';

                    htmlResult += "<style type='text/css'>.modal-div:hover { background-color: white; }</style>";
                  var r = result.good_units;

                  for (var i = 0; i < r.length; i++) {
                    if((i%2) == 0) 
                    {
                        color = '#FFF1CE';
                    }
                    else color = "#FDEFF4";
                    htmlResult += "<textarea class='col-sm-12 modal-div' style='display:inline-block; color:black; cursor: pointer; min-height:40px; max-height:80px; background-color:" + color + "; padding: 5px;' onclick='searchByKeyword(\"all_barcode\",\"" + r[i].good_unit_id + "\")'>" + r[i].name + "</textarea>";
                  }
                  $("#result_good").html(htmlResult);
                  $('.modal-body').css('height',$( window ).height()*0.5);
                },
                error: function(){
                    console.log('error');
                }
              });
        }
    </script>
@endsection
