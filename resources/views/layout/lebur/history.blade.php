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
                @if($type == 'sold')
                  <th width="15%">Tanggal Jual</th>
                @else
                  <th width="15%">Tanggal Lebur</th>
                @endif
                <th width="15%">Berat</th>
                <th width="15%">Status</th>
                @if($type == 'sold')
                  <th>Harga Jual</th>
                @elseif($type == 'sellOngoing')
                  <th width="15%">Selesai Lebur (masukkan berat baru)</th>
                @endif
              </tr>
              </thead>
              <tbody id="table-good">
                @foreach($cokims as $cokim)
                  <tr>
                    <td>{{ displayDate($cokim->created_at) }}</td>
                    <td>{{ $cokim->weight }} gram</td>
                    <td>{{ $cokim->getRealStatus() }}</td>
                    @if($type == 'sold')
                      <td>{{ showRupiah($cokim->selling_price) }}</td>
                    @elseif($cokim->status == 'ongoing')
                      <td>
                        {!! Form::model(old(),array('url' => route($role . '.lebur.storeDone'), 'enctype'=>'multipart/form-data', 'method' => 'POST', 'class' => 'form-horizontal')) !!}
                            {!! Form::text('weight', null, array('class' => 'form-control')) !!}
                            {!! Form::hidden('cokim_id', $cokim->id) !!}
                            {{ csrf_field() }}
                            {!! Form::submit('Lebur Emas', ['class' => 'btn form-control'])  !!}
                        {!! Form::close() !!}
                      </td>
                    @endif
                  </tr>
                @endforeach
              </tbody>
              <div id="renderField">
                @if($pagination != 'all')
                  {{ $cokims->render() }}
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

    });
  </script>
@endsection