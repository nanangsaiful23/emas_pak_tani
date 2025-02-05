<style type="text/css">
  .datepicker-days, .datepicker-months
  {
    display: none !important;
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
            @include('layout.search-form')
            <div class="form-group col-sm-12" style="margin-top: 10px;">
              {!! Form::label('show', 'Show', array('class' => 'col-sm-1 control-label')) !!}
              <div class="col-sm-1">
                {!! Form::select('show', getPaginations(), $pagination, ['class' => 'form-control select2', 'style'=>'width: 100%', 'id' => 'show', 'onchange' => 'changeDate()']) !!}
              </div>
              <!-- {!! Form::label('start_date', 'Tanggal Awal', array('class' => 'col-sm-1 control-label')) !!}
              <div class="col-sm-2">
                <div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" name="start_date" value="{{ date('Y', strtotime($start_date)) }}" onchange="changeDate()">
                </div>
              </div>
              {!! Form::label('end_date', 'Tanggal Akhir', array('class' => 'col-sm-1 control-label')) !!}
              <div class="col-sm-2">
                <div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker2" name="end_date" value="{{ date('Y', strtotime($end_date)) }}" onchange="changeDate()">
                </div>
              </div> -->
            </div>
          </div>
          <div class="box-body" style="overflow-x:scroll; color: black !important">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Tagihan</th>
                <th>Nominal</th>
                <th>Status</th>
                @if(\Auth::user()->email == 'super_admin')
                  <th class="center">Detail</th>
                  <th class="center">Ubah</th>
                  <th class="center">Hapus</th>
                @endif
              </tr>
              </thead>
              <tbody id="table-good">
                @foreach($server_payments as $server_payment)
                  <tr @if($server_payment->month_pay == null) style="background-color: #F05A7E" @endif>
                    <td>{{ date('F Y', strtotime($server_payment->month_due)) }}</td>
                    <td>{{ showRupiah($server_payment->nominal) }}</td>
                    @if($server_payment->month_pay != null)
                      <td>Terbayar pada tanggal {{ displayDate($server_payment->month_pay) }}</td>
                    @else
                      <td>Belum dibayar</td>
                    @endif
                    @if(\Auth::user()->email == 'super_admin')
                      <td class="center"><a href="{{ url($role . '/server-payment/' . $server_payment->id . '/detail') }}"><i class="fa fa-hand-o-right tosca" aria-hidden="true"></i></a></td>
                      <td class="center"><a href="{{ url($role . '/server-payment/' . $server_payment->id . '/edit') }}"><i class="fa fa-file orange" aria-hidden="true"></i></a></td>
                      <td class="center">
                        <button type="button" class="no-btn center" data-toggle="modal" data-target="#modal-danger-{{$server_payment->id}}"><i class="fa fa-times" aria-hidden="true" style="color: red !important"></i></button>

                        @include('layout' . '.delete-modal', ['id' => $server_payment->id, 'data' => $server_payment->name, 'formName' => 'delete-form-' . $server_payment->id])

                        <form id="delete-form-{{$server_payment->id}}" action="{{ url($role . '/server-payment/' . $server_payment->id . '/delete') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                        </form>
                      </td>
                    @endif
                  </tr>
                @endforeach
              </tbody>
              <div id="renderField">
                @if($pagination != 'all')
                  {{ $server_payments->render() }}
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
      
        $("#search-input").keyup( function(e){
          if(e.keyCode == 13)
          {
            ajaxFunction();
          }
        });

        $("#search-btn").click(function(){
            ajaxFunction();
        });

        $('#datepicker').datepicker({
          autoclose: true,
          viewMode: "years",
          format: 'yyyy'
        })

        $('#datepicker2').datepicker({
          autoclose: true,
          viewMode: "years",
          format: 'yyyy'
        })

    });

    function changeDate()
    {
      window.location = window.location.origin + '/{{ $role }}/server-payment/' + $("#datepicker").val() + '/' + $("#datepicker2").val() + '/' + $("#show").val();
    }
  </script>
@endsection