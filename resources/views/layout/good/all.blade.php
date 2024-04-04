<style type="text/css">
  .table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
   background-color: #E1EEDD;
}
</style>

<div class="content-wrapper">

  @include('layout' . '.alert-message', ['type' => $default['type'], 'data' => $default['data'], 'color' => $default['color']])

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> {{ $default['page_name'] }}</h3>
          </div>
          <div class="box-body" style="overflow-x:scroll">
            <div class="form-group col-sm-12" style="margin-top: 10px;">
              @include('layout.search-form')
            </div>
            <div class="form-group col-sm-12" style="margin-top: 10px;">

              {!! Form::label('show', 'Show', array('class' => 'col-sm-1 control-label')) !!}
              <div class="col-sm-1">
                {!! Form::select('show', getPaginations(), $pagination, ['class' => 'form-control select2', 'style'=>'width: 100%', 'id' => 'show', 'onchange' => 'advanceSearch()']) !!}
              </div>
              {!! Form::label('category', 'Kategori', array('class' => 'col-sm-1 control-label')) !!}
              <div class="col-sm-2">
                {!! Form::select('category', getCategories(), $category_id, ['class' => 'form-control select2', 'style'=>'width: 100%', 'id' => 'category', 'onchange' => 'advanceSearch()']) !!}
              </div>
              {!! Form::label('status', 'Status Barang', array('class' => 'col-sm-1 control-label')) !!}
              <div class="col-sm-2">
                {!! Form::select('status', getStatusOther(), $status, ['class' => 'form-control select2', 'style'=>'width: 100%', 'id' => 'status', 'onchange' => 'advanceSearch()']) !!}
              </div>
              @if(\Auth::user()->email == 'admin')
                <!-- <div class="form-group col-sm-12" style="margin-top: 10px;"> -->
                  {!! Form::label('distributor', 'Distributor', array('class' => 'col-sm-1 control-label')) !!}
                  <div class="col-sm-3">
                    {!! Form::select('distributor', getDistributorLists(), $distributor_id, ['class' => 'form-control select2', 'style'=>'width: 100%', 'id' => 'distributor', 'onchange' => 'advanceSearch()']) !!}
                  </div>
                <!-- </div> -->
              @endif
            </div>
          </div>
          <div class="box-body" style="overflow-x:scroll">
              <div class="form-group">
                @if($pagination != 'all')
                  {{ $goods->render() }}
                @endif
              </div>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 10%; text-align: center;">Kategori</th>
                  <th style="width: 10%; text-align: center;">Kode</th>
                  <th style="width: 15%; text-align: center;">Nama</th>
                  <th style="width: 10%; text-align: center;">Berat Emas</th>
                  <th style="width: 9%; text-align: center;">Persentase</th>
                  <th style="width: 9%; text-align: center;">Berat Batu</th>
                  <th style="width: 9%; text-align: center;">Harga Batu</th>
                  <th style="width: 9%; text-align: center;">Status</th>
                  <th style="width: 12%; text-align: center;">Stock</th>
                  <!-- <th style="width: 15%; text-align: center;">Harga Jual</th> -->
                  @if(\Auth::user()->email == 'admin')
                    <!-- <th style="width: 10%; text-align: center;">Harga Beli</th> -->
                  @endif
                  <th style="width: 15%; text-align: center;">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($goods as $good)
                  <tr>
                    <td>{{ $good->category->name }}</td>
                    <td>{{ $good->code }}</td>
                    <td>
                      <h4>{{ $good->name }}</h4>
                      Deskripsi: {{ $good->description }}<br>
                      @if($good->brand != null) <h5>Brand: {{ $good->brand->name }}</h5>@endif
                      @if(\Auth::user()->email == 'admin')
                        <i class="fa fa-truck green" aria-hidden="true"></i> @if($good->getLastBuy() != null) {{ $good->getLastBuy()->good_loading->distributor->name . ' (' . $good->getLastBuy()->good_loading->note . ')' }} @endif
                      @endif
                    </td>
                    <td>{{ $good->weight }} gram</td>
                    <td>{{ $good->percentage->name }}</td>
                    @if($good->stone_weight != '0.00' && $good->stone_weight != null && $good->stone_weight != '' && $good->stone_weight != '0') 
                      <td>{{ $good->stone_weight }} gram</td>
                      <td>{{ showRupiah($good->stone_price) }}</td>
                    @else
                      <td>-</td>
                      <td>-</td>
                    @endif
                    <td @if($good->status != 'Siap dijual') style="background-color: red !important"@endif>
                      {{ $good->status }}<br>
                      @if($good->status != 'Siap dijual')
                        <a href="{{ url($role . '/good/' . $good->id . '/edit') }}" class="btn btn-warning" target="_blank()">Ubah Status Barang</a>
                      @endif
                    </td>
                    <td>
                      <i class="fa fa-cubes brown" aria-hidden="true"></i> {{ $good->getStock() . ' ' . $good->getPcsSellingPrice()->unit->code }}<br>
                      <i class="fa fa-money green" aria-hidden="true"></i> {{ $good->good_transactions()->sum('real_quantity') . ' ' . $good->getPcsSellingPrice()->unit->code }}<br>
                      <i class="fa fa-truck pink" aria-hidden="true"></i> {{ $good->good_loadings()->sum('real_quantity') . ' ' . $good->getPcsSellingPrice()->unit->code }}
                      @if($role == 'admin')<br><a href="{{ url($role . '/good/' . $good->id . '/history/2023-01-01/' . date('Y-m-d') . '/all') }}" class="btn btn-warning" target="_blank()">Riwayat barang</a><br>@endif
                    </td>
                    <td>
                      <a href="{{ url($role . '/good/' . $good->id . '/detail') }}" target="_blank()"><i class="fa fa-hand-o-right tosca" aria-hidden="true"></i> Detail</a><br>
                      @if($role == 'admin')<a href="{{ url($role . '/good/' . $good->id . '/edit') }}" target="_blank()"><i class="fa fa-pencil-square-o orange" aria-hidden="true"></i> Edit</a><br>@endif
                      <a href="{{ url($role . '/good/' . $good->id . '/photo/create') }}" target="_blank()"><i class="fa fa-camera orange" aria-hidden="true"></i> Photo</a><br>
                      @if($good->getStock() == 0)
                        <button type="button" class="no-btn" data-toggle="modal" data-target="#modal-danger-{{$good->id}}"><i class="fa fa-times red" aria-hidden="true"></i></button>

                        @include('layout' . '.delete-modal', ['id' => $good->id, 'data' => $good->name, 'formName' => 'delete-form-' . $good->id])

                        <form id="delete-form-{{$good->id}}" action="{{ url($role . '/good/' . $good->id . '/delete') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                        </form>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
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

    function ajaxFunction()
    {
      console.log("{!! url($role . '/good/searchByKeyword/') !!}/" + $("#search-input").val());
      $.ajax({
        url: "{!! url($role . '/good/searchByKeyword/') !!}/" + $("#search-input").val(),
        success: function(result){
          console.log(result);
          var htmlResult = "<thead><tr><th style=\"width: 10%; text-align: center;\">Kategori</th><th style=\"width: 10%; text-align: center;\">Kode</th><th style=\"width: 15%; text-align: center;\">Nama</th><th style=\"width: 10%; text-align: center;\">Berat Emas</th><th style=\"width: 9%; text-align: center;\">Persentase</th><th style=\"width: 9%; text-align: center;\">Berat Batu</th><th style=\"width: 9%; text-align: center;\">Harga Batu</th><th style=\"width: 9%; text-align: center;\">Status</th><th style=\"width: 12%; text-align: center;\">Stock</th><th style=\"width: 15%; text-align: center;\">Action</th></tr></thead><tbody>";
          if(result != null)
          {
            var r = result.goods;
            for (var i = 0; i < r.length; i++) {
              htmlResult += "<tr><td>" + r[i].category.name + "</td>";
              htmlResult += "<td>" + r[i].code + "</td>";
              htmlResult += "<td><h4>" + r[i].name + "</h4>Deskripsi:" + r[i].description + "<br>";

              var username = "{{ \Auth::user()->email }}";
              if(username == 'admin')
              {
                htmlResult += "<br><i class='fa fa-truck green' aria-hidden='true'></i> " + r[i].last_loading + "</td>";
              }
              else
              {
                htmlResult += "</td>";
              }

              htmlResult += "<td>" + r[i].weight + " gram</td>";
              htmlResult += "<td>" + r[i].percentage.name + "</td>";
              htmlResult += "<td>" + r[i].stone_weight + "</td>";
              htmlResult += "<td>" + r[i].stone_price + "</td>";
              htmlResult += "<td>" + r[i].status + "</td>";
              htmlResult += "<td><i class=\"fa fa-cubes brown\" aria-hidden=\"true\"></i> " + r[i].stock + " " + r[i].unit + "<br><i class=\"fa fa-money green\" aria-hidden=\"true\"></i> " + r[i].transaction + " " + r[i].unit + "<br><i class=\"fa fa-truck pink\" aria-hidden=\"true\"></i> " + r[i].loading + " " + r[i].unit + "<br><br>@if($role == 'admin')<a href=\"" + window.location.origin + "/" + '{{ $role }}' + "/good/" + r[i].id + "/loading/2023-01-01/" + "{{ date('Y-m-d') }}" + "/10\" class=\"btn btn-warning\" target=\"_blank()\">Riwayat loading</a><br><br><a href=\"" + window.location.origin + "/" + '{{ $role }}' + "/good/" + r[i].id + "/transaction/2023-01-01/" + "{{ date('Y-m-d') }}" + "/10\" class=\"btn btn-warning\" target=\"_blank()\">Riwayat penjualan</a>@endif</td>";

              htmlResult += "<td><a href=\"" + window.location.origin + "/" + '{{ $role }}' + "/good/" + r[i].id + "/detail\" target=\"_blank()\"><i class=\"fa fa-hand-o-right tosca\" aria-hidden=\"true\"></i> Detail</a><br>@if($role == 'admin')<a href=\"" + window.location.origin + "/" + '{{ $role }}' + "/good/" + r[i].id + "/edit\" target=\"_blank()\"><i class=\"fa fa-pencil-square-o orange\"></i> Edit</a><br>@endif<a href=\"" + window.location.origin + "/" + '{{ $role }}' + "/good/" + r[i].id + "/photo/create\" target=\"_blank()\"><i class=\"fa fa-camera orange\"></i> Photo</a><br>";


              if(r[i].stock == '0' && username == 'admin')
              {
                htmlResult += "<a href=\"" + window.location.origin + "/" + '{{ $role }}' + "/good/" + r[i].id + "/delete\" onclick=\"event.preventDefault(); document.getElementById('delete-form-" + r[i].id + "').submit();\"><i class=\"fa fa-times red\"></i></a><form id='delete-form-" + r[i].id + "' action=\"" + window.location.origin + "/" + '{{ $role }}' + "/good/" + r[i].id + "/delete\" method=\"POST\" style=\"display: none;\">" + '{{ csrf_field() }}' + '{{ method_field("DELETE") }}' + "</form>";
              }
              
              htmlResult += "</td></tr>";
            }
          }

          htmlResult += "</tbody>";

          $("#example1").html(htmlResult);
        },
        error: function(){
            console.log('error');
        }
      });
    }

    function advanceSearch()
    {
      window.location = window.location.origin + '/{{ $role }}/good/' + $('#category').val() + '/' + $('#distributor').val() + '/' + $('#status').val() + '/' + $('#show').val();
    }
  </script>
@endsection
