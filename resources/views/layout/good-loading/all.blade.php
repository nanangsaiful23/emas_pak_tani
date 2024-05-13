<div class="content-wrapper">

  @include('layout' . '.alert-message', ['type' => $default['type'], 'data' => $default['data'], 'color' => $default['color']])

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{ $default['page_name'] }}</h3>
            <!-- @include('layout.search-form') -->
          </div>
          <div class="box-body">
           <div class="col-sm-12">
            {!! Form::label('show', 'Show', array('class' => 'col-sm-1 control-label')) !!}
           <div class="col-sm-1">
              {!! Form::select('show', getPaginations(), $pagination, ['class' => 'form-control select2', 'style'=>'width: 100%', 'id' => 'show', 'onchange' => 'advanceSearch()']) !!}
           </div>
           @if($type != 'loading')
             {!! Form::label('type', 'Tipe', array('class' => 'col-sm-1 control-label')) !!}
             <div class="col-sm-3">
                {!! Form::select('type', getGoodLoadingTypes(), $type, ['class' => 'form-control select2', 'style'=>'width: 100%', 'id' => 'type', 'onchange' => 'advanceSearch()']) !!}
              </div>
            @endif
            {!! Form::label('distributor', 'Distributor', array('class' => 'col-sm-1 control-label')) !!}
            <div class="col-sm-3">
              {!! Form::select('distributor', getDistributorLoading($distributor_id, $start_date, $end_date), $distributor_id, ['class' => 'form-control select2', 'style'=>'width: 100%', 'id' => 'distributor', 'onchange' => 'advanceSearch()']) !!}
            </div>
          </div>
           <div class="col-sm-12" style="margin-top: 10px">
            {!! Form::label('start_date', 'Tanggal Awal', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-2">
              <div class="input-group date">
                <input type="text" class="form-control pull-right" id="datepicker" name="start_date" value="{{ $start_date }}" onchange="changeDate()">
              </div>
            </div>
            {!! Form::label('end_date', 'Tanggal Akhir', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-2">
              <div class="input-group date">
                <input type="text" class="form-control pull-right" id="datepicker2" name="end_date" value="{{ $end_date }}" onchange="changeDate()">
              </div>
            </div>
          </div>
          </div>
          <div class="box-body" style="overflow-x:scroll">
            <h4>Total loading: {{ showRupiah($good_loadings->sum('total_item_price')) }}</h4><br>
          </div>
          <div class="box-body" style="overflow-x:scroll">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                @if(\Auth::user()->email == 'admin')
                  <th>Tanggal Loading Barang ke Sistem</th>
                @endif
                <th>Tanggal Kulak Barang</th>
                <th>Nama distributor</th>
                <th>Total Berat Emas Loading</th>
                <th>Catatan</th>
                <th>User</th>
                <th class="center">Detail</th>
                <th class="center">Edit</th>
                <th class="center">Print Nota</th>
                <th class="center">Print Barcode</th>
                <th class="center">Hapus</th>
              </tr>
              </thead>
              <tbody id="table-good">
                @foreach($good_loadings as $good_loading)
                  <tr>
                    @if(\Auth::user()->email == 'admin')
                      <td>{{ $good_loading->created_at }}</td>
                    @endif
                    <td>{{ displayDate($good_loading->loading_date) }}</td>
                    <td>{{ $good_loading->distributor->name }}</td>
                    <td style="text-align: right;">{{ displayGramComa($good_loading->getTotalEmas()->total_weight) }} gram</td>
                    <td>{{ $good_loading->note }}</td>
                    <td>{{ $good_loading->actor()->name }}</td>
                    <td class="center"><a href="{{ url($role . '/good-loading/' . $good_loading->id . '/detail') }}"><i class="fa fa-hand-o-right tosca" aria-hidden="true"></i></a></td>
                    <td class="center"><a href="{{ url($role . '/good-loading/' . $good_loading->id . '/edit') }}"><i class="fa fa-pencil-square-o tosca" aria-hidden="true"></i></a></td>
                    <td class="center"><a href="{{ url($role . '/good-loading/' . $good_loading->id . '/print') }}" target="_blank()"><i class="fa fa-print tosca" aria-hidden="true"></i></a></td>
                    <td class="center"><a href="{{ url($role . '/good-loading/' . $good_loading->id . '/printBarcode') }}" target="_blank()"><i class="fa fa-barcode tosca" aria-hidden="true"></i></a></td>
                    <td>
                      <button type="button" class="no-btn" data-toggle="modal" data-target="#modal-danger-{{$good_loading->id}}"><i class="fa fa-times red" aria-hidden="true"></i></button>

                      @include('layout' . '.delete-modal', ['id' => $good_loading->id, 'data' => $good_loading->created_at . ' ' . $good_loading->distributor->name, 'formName' => 'delete-form-' . $good_loading->id])

                      <form id="delete-form-{{$good_loading->id}}" action="{{ url($role . '/good-loading/' . $good_loading->id . '/delete') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <div id="renderField">
                @if($pagination != 'all')
                  {{ $good_loadings->render() }}
                @endif
              </div>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@section('js-addon')
  <script type="text/javascript">
    $(document).ready(function(){
        $('.select2').select2();
      $('#datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
      })

      $('#datepicker2').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
      })

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

    function changeDate()
    {
        var distributor = $('#distributor').val();
      window.location = window.location.origin + '/{{ $role }}/good-loading/{{ $type }}/' + $("#datepicker").val() + '/' + $("#datepicker2").val() +'/'+distributor +'/{{ $pagination }}';
    }

    function advanceSearch()
    {
      var show        = $('#show').val();
      var distributor = $('#distributor').val();
      var type        = $('#type').val();
      window.location = window.location.origin + '/{{ $role }}/good-loading/' + type + '/{{ $start_date }}/{{ $end_date }}/'+distributor+'/' + show;
    }
  </script>
@endsection
