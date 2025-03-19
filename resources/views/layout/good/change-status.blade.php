<div class="content-wrapper">
  @include('layout' . '.error')

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> Form Input Transaksi</h3>
          </div>

          {!! Form::model(old(),array('url' => route($role . '.good.update-status'), 'enctype'=>'multipart/form-data', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'transaction-form')) !!}
            <div class="box-body">

            <div class="form-group col-sm-7">
                {!! Form::label('all_name', 'Cari nama barang', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    <select class="form-control select2" style="width: 100%;" name="items" id="all_name"
                        onchange="fillItem()">
                        <!-- <div> -->
                            <option value="null">Silahkan pilih barang</option>
                            @foreach($goods as $good)
                                <option value="{{ $good->id . ';;' . $good->code . ';;' . $good->weight . ';;' . $good->percentage->name . ';;' . $good->name . ';;' . $good->status }}">{{ $good->name . ' ' . $good->weight . ' gram'}}</option>
                            @endforeach
                        <!-- </div> -->
                    </select>
                </div>
            </div>
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
                <div class="row">
                    <table class="table table-bordered table-striped" style="overflow-x: auto;">
                        <thead>
                            <th>Kode</th>
                            <th>Berat</th>
                            <th>Kadar</th>
                            <th>Barang</th>
                            <th>Status</th>
                            <th>Berat Baru</th>
                            <th>Ongkos</th>
                        </thead>
                        <tbody id="table-transaction">
                            <?php $i = 1; ?>
                            <tr id='row-data-{{ $i }}' style="display: none">
                                <td width="18%">
                                    {!! Form::hidden('ids[]', null, array('id' => 'id-' . $i)) !!}
                                    {!! Form::textarea('codes[]', null, array('class' => 'form-control', 'readonly' => 'readonly', 'style' => 'height: 70px', 'id' => 'code-' . $i)) !!}
                                </td>
                                <td width="10%">
                                    {!! Form::text('weights[]', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'weight-' . $i)) !!}
                                </td>
                                <td width="10%">
                                    {!! Form::text('percentages[]', null, array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'percentage-' . $i)) !!}
                                </td>
                                <td width="30%">
                                    {!! Form::textarea('names[]', null, array('class' => 'form-control', 'readonly' => 'readonly', 'style' => 'height: 70px', 'id' => 'name-' . $i)) !!}
                                </td>
                                <td>
                                    {!! Form::select('statuses[]', getStatusOtherWoAll(), null, ['class' => 'form-control select2','required'=>'required', 'style'=>'width:100%', 'id' => 'status-' . $i]) !!}
                                </td>
                                <td width="10%">
                                    {!! Form::text('new_weights[]', null, array('class' => 'form-control', 'id' => 'new_weight-' . $i)) !!}
                                </td>
                                <td width="10%">
                                    {!! Form::text('fees[]', null, array('class' => 'form-control', 'id' => 'fee-' . $i, 'onkeyup' => 'formatNumber("fee-' . $i . '")')) !!}
                                </td>
                                <td><i class="fa fa-times red" id="delete-{{ $i }}" onclick="deleteItem('{{ $i }}')"></i></td>          
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{ csrf_field() }}

            <hr>
            <div onclick="event.preventDefault(); submitForm(this);" class= 'btn btn-success btn-flat btn-block form-control' style="height: 80px; font-size: 40px;">Ubah Status</div>

            @section('js-addon')
                <script type="text/javascript">
                    var total_item = 1;
                    $(document).ready (function (){
                        $('.select2').select2();
                    });

                    function submitForm(btn)
                    {
                        document.getElementById('transaction-form').submit();
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
                    }

                      function fillItem()
                      {

                          $('#row-data-' + total_item).show();
                          var good = $("#all_name").val().split(";;");
                          $("#id-" + total_item).val(good[0]);
                          $("#code-" + total_item).val(good[1]);
                          $("#weight-" + total_item).val(good[2]);
                          $("#percentage-" + total_item).val(good[3]);
                          $("#name-" + total_item).val(good[4]);
                          $("#status-" + total_item).val(good[5]).change();
                          $("#new_weight-" + total_item).val(good[2]);
                          
                          addElement(total_item);
                          total_item += 1;
                      }

                    function addElement(index)
                    {
                      index = parseInt(index) + 1;
                      index = index.toString();
                      htmlResult = '<tr id="row-data-' + index + '" style="display:none;">';
                      htmlResult += '<td width="18%"><textarea type="text" name="ids[]" class="form-control" id="id-' + index +'" style="display: none"></textarea><textarea type="text" name="codes[]" class="form-control" id="code-' + index +'" readonly="readonly" style="height: 70px"></textarea></td>';
                      htmlResult += '<td width="10%"><textarea type="text" name="weights[]" class="form-control" id="weight-' + index +'" readonly="readonly"></textarea></td>';
                      htmlResult += '<td width="10%"><textarea type="text" name="percentages[]" class="form-control" id="percentage-' + index +'" readonly="readonly"></textarea></td>';
                      htmlResult += '<td width="30%"><textarea type="text" name="names[]" class="form-control" id="name-' + index +'" readonly="readonly" style="height: 70px"></textarea></td>';
                      htmlResult += '<td><select class="form-control select2" id="status-' + index + '" name="statuses[]" required="required" style="width: 100%">@foreach(getStatusOtherWoAll() as $x => $y)<option value="{{ $x }}">{{ $y }}</option> @endforeach </select></td>';    
                      htmlResult += '<td width="10%"><textarea type="text" name="new_weights[]" class="form-control" id="new_weight-' + index +'"></textarea></td>';
                      htmlResult += '<td width="10%"><textarea type="text" name="fees[]" class="form-control" id="fee-' + index +'" style="height: 70px" onkeyup="formatNumber(\'fee-' + index + '\')"></textarea></td>'; 
                      htmlResult += '<td><i class="fa fa-times red" id="delete-' + index + '" onclick="deleteItem(\'' + index + '\')"></i></td>';
                      htmlResult += '</tr>';

                      $("#table-transaction").prepend(htmlResult);
                    }
                </script>
            @endsection

            </div>
          {!! Form::close() !!}

        </div>
      </div>
    </div>
  </section>
</div>