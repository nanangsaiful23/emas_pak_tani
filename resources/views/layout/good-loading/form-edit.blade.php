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
                                    <option value="{{ $distributor->id }}" @if($good_loading->distributor_id == $distributor->id) selected = "selected" @endif>{{ $distributor->name }}</option>
                                @endforeach
                            </div>
                        </select>
                    @endif
                </div>
            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('loading_date', 'Tanggal Pembelian Emas', array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    <div class="input-group date">
                        <input type="text" class="form-control pull-right" required="required" name="loading_date" id="loading_date" value="{{ $good_loading->loading_date }}">
                    </div>
                </div>
            </div>
        </div>
       <div class="col-sm-7">
            {!! Form::label('note', 'Catatan', array('class' => 'col-sm-1 left control-label')) !!}
            <div class="col-sm-12">
                <input type="text" name="note" class="form-control" id="note" value="{{ $good_loading->note }}">
            </div>
            {!! Form::label('checker', 'Nama Pengecek Barang', array('class' => 'col-sm-12 control-label', 'style' => 'text-align: left')) !!}
            <div class="col-sm-12">
                <input type="text" name="checker" class="form-control" id="checker" value="{{ $good_loading->checker }}">
            </div>
       </div>
    </div>

    <h4>Resume {{ $default['page_name'] }}</h4>
    <div class="row">
        <div class="form-group col-sm-12" style="overflow-x:scroll">
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Kategori</th>
                    <th>Jenis Emas</th>
                    <th>Nama</th>
                    <th>Persentase</th>
                    <th>Berat</th>
                    <th>Status Barang</th>
                    @if($type == 'buy-other' || $type == 'buy')
                        <th>Harga Beli</th>
                    @endif
                    <th>History Barang</th>
                    <th>Berat Batu</th>
                    <th>Harga Batu</th>
                    <th>Hapus</th>
                </thead>
                <tbody id="table-transaction">
                    <?php $i = 1; ?>
                    @foreach($good_loading->details as $detail)
                        <tr id="row-data-{{ $i }}">
                            <td style="display: none;">
                                {!! Form::textarea('ids[]', $detail->id, array('class' => 'form-control', 'readonly' =>
                                'readonly', 'id' => 'id-'.$i)) !!}
                                {!! Form::textarea('good_ids[]', $detail->good_unit->good->id, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'good_id-'.$i)) !!}
                            </td>
                            <td>
                                {!! Form::select('category_ids[]', getCategoriesWoAll(), $detail->good_unit->good->category_id, ['class' => 'form-control select2', 'style'=>'width: 100%', 'id' => 'category_id-' . $i]) !!}
                            </td>
                            <td>
                                {!! Form::select('is_old_golds[]', getGoldTypes(), $detail->good_unit->good->is_old_gold, ['class' => 'form-control select2', 'style'=>'width: 100%', 'id' => 'is_old_gold-' . $i]) !!}
                            </td>
                            <td width="20%">
                                {!! Form::textarea('names[]', $detail->good_unit->good->name, array('class' => 'form-control', 'id' => 'name-'.$i, 'style' => 'height: 70px')) !!}
                            </td>
                            <td>
                                {!! Form::select('percentage_ids[]', getPercentages(), $detail->good_unit->good->percentage_id, ['class' => 'form-control select2', 'style'=>'width: 100%', 'id' => 'percentage_id-' . $i]) !!}
                            </td>
                            <td style="width: 30%">
                                <textarea type="text" name="weights[]" class="form-control" id="weight-{{ $i }}">{{ $detail->good_unit->good->weight }}</textarea>
                            </td>
                            <td>
                                @if($type == 'loading')
                                    <textarea type="text" name="statuses[]" class="form-control" id="status-{{ $i }}" readonly="readonly">Siap dijual</textarea>
                                @else
                                    {!! Form::select('statuses[]', getStatusOther(), $detail->good_unit->good->status, ['class' => 'form-control select2','required'=>'required', 'style'=>'width:100%', 'id' => 'status-' . $i]) !!}
                                @endif
                            </td>
                            @if($type == 'buy-other' || $type == 'buy')
                                <td style="width: 30%">
                                     <textarea type="text" name="prices[]" class="form-control" id="price-{{ $i }}"
                                        onchange="editPrice('{{ $i }}')" onkeypress="editPrice('{{ $i }}')" onkeyup="formatNumber('price-{{$i}}')" value="{{ $detail->price }}">{{ $detail->price }}</textarea>
                                </td>
                                <td style="display: none;">
                                    {!! Form::textarea('total_prices[]', null, array('class' => 'form-control', 'readonly' =>
                                    'readonly', 'id' => 'total_price-'.$i, 'style' => 'height: 70px')) !!}
                                </td>
                            @elseif($type == 'loading')
                                <td style="display: none;">
                                     <textarea type="text" name="prices[]" class="form-control" id="price-{{ $i }}"
                                        onchange="editPrice('{{ $i }}')" onkeypress="editPrice('{{ $i }}')" onkeyup="formatNumber('price-{{$i}}')" value="{{ $detail->price }}"></textarea>
                                </td>
                                <td style="display: none;">
                                    {!! Form::textarea('total_prices[]', null, array('class' => 'form-control', 'readonly' =>
                                    'readonly', 'id' => 'total_price-'.$i, 'style' => 'height: 70px')) !!}
                                </td>
                            @endif
                            <td>
                                {!! Form::select('gold_history_numbers[]', getGoldHistoryNumber(), $detail->good_unit->good->gold_history_number, ['class' => 'form-control select2', 'style'=>'width: 100%', 'id' => 'gold_history_number-' . $i]) !!}
                            </td>
                            <td>
                                <textarea type="text" name="stone_weights[]" class="form-control" id="stone_weight-{{ $i }}" value="{{ $detail->good_unit->good->stone_weight }}"></textarea>
                            </td>
                            <td>
                                 <textarea type="text" name="stone_prices[]" class="form-control" id="stone_price-{{ $i }}"
                                    onchange="editPrice('{{ $i }}')" onkeypress="editPrice('{{ $i }}')" value="{{ $detail->good_unit->good->stone_price }}"></textarea>
                            </td>
                            <td><i class="fa fa-times red" id="delete-{{ $i }}" onclick="deleteItem('{{ $i }}')"></i></td>
                        </tr>
                        <?php $i++ ?>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="form-group" @if($type == 'loading') style="display:none" @endif>
            {!! Form::label('total_item_price', 'Total Harga', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-3">
                {!! Form::text('total_item_price', $good_loading->total_item_price, array('class' => 'form-control', 'readonly' => 'readonly', 'id'
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
    var total_item = {{ $good_loading->details->count() }};
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

          function changeTotal()
          {
              total_item_price = parseInt(0);
              for (var i = 1; i <= total_item; i++)
              {
                  if(document.getElementById("name-" + i))
                  {
                      if(document.getElementById("name-" + i).value != '')
                      {
                          if(document.getElementById("price-" + i).value == null || document.getElementById("price-" + i).value == '')
                            money = 0;
                          else
                          {
                              money = document.getElementById("price-" + i).value;
                              money = money.replace(/,/g,'');
                          }
                          if(document.getElementById("stone_price-" + i).value == null || document.getElementById("stone_price-" + i).value == '')
                            stone = 0;
                          else
                          {
                            stone = document.getElementById("stone_price-" + i).value;
                            stone = stone.replace(/,/g,'');
                          }
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
              if(($("#distributor_name").val() == "") && ($("#all_distributor").val() == "null"))
              {
                isi=false;
                alert("silahkan isi distributor");
              }
              if($("#loading_date").val()=="")
              {
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
          }
</script>
@endsection
