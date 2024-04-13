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
            <div class="box-body"><style type="text/css">
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
                            <th>Ongkos</th>
                        </thead>
                        <tbody id="table-transaction">
                            @foreach($goods as $good)
                                <tr>
                                    <td width="18%">
                                        {!! Form::hidden('ids[]', $good->id) !!}
                                        {!! Form::textarea('codes[]', $good->code, array('class' => 'form-control', 'readonly' => 'readonly', 'style' => 'height: 70px')) !!}
                                    </td>
                                    <td width="10%">
                                        {!! Form::text('weights[]', $good->weight, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                                    </td>
                                    <td width="10%">
                                        {!! Form::text('percentages[]', $good->percentage->name, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                                    </td>
                                    <td width="30%">
                                        {!! Form::textarea('names[]', $good->name, array('class' => 'form-control', 'readonly' => 'readonly', 'style' => 'height: 70px')) !!}
                                    </td>
                                    <td>
                                        {!! Form::select('statuses[]', getStatusOtherWoAll(), $good->status, ['class' => 'form-control select2','required'=>'required', 'style'=>'width:100%']) !!}
                                    </td>
                                    <td width="10%">
                                        {!! Form::text('fees[]', null, array('class' => 'form-control', 'id' => 'fee-' . $good->id, 'onkeyup' => 'formatNumber("fee-' . $good->id . '")')) !!}
                                    </td>
                                </tr>
                            @endforeach
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
                    var total_item_retur = 1;
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
                        $("#row-data" + index).remove();
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