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
                <select class="form-control" style="width: 100%;" id="good-list"></select>
              </div>
              <table class="table table-bordered table-condensed" id="selected-table" style="display: none;">
                <thead>
                  <tr>
                    <th>Barang</th>
                    <th style="width: 100px;">Berat</th>
                    <th style="width: 110px;">Jumlah</th>
                    <th style="width: 60px;"></th>
                  </tr>
                </thead>
                <tbody id="selected-body"></tbody>
              </table>
            {!! Form::close() !!}
          </div>
          <div onclick="event.preventDefault(); submitForm(this);" class= 'btn btn-success btn-flat btn-block form-control' style="height: 80px; font-size: 40px;">Print</div>
        </div>
      </div>
    </div>
  </section>
</div>

@section('js-addon')
  <script type="text/javascript">
    var searchUrl = "{{ route($role . '.print-barcode.search') }}";

    function escapeHtml(text)
    {
      return $('<div>').text(text == null ? '' : text).html();
    }

    function updateTotal()
    {
      var rows = $('#selected-body tr').length;
      var total = 0;
      $('#selected-body input.qty').each(function(){ total += parseInt($(this).val()) || 0; });
      $('#selected-table').toggle(rows > 0);
      $('#total').text(rows > 0 ? rows + ' barang, ' + total + ' label' : '');
    }

    $(document).ready(function(){
      $('#good-list').select2({
        placeholder: 'Ketik nama / kode barang',
        minimumInputLength: 2,
        ajax: {
          url: searchUrl,
          dataType: 'json',
          delay: 300,
          data: function(params){ return { q: params.term }; },
          processResults: function(data){ return data; }
        }
      }).on('select2:select', function(e){
        addItem(e.params.data);
        $(this).val(null).trigger('change');
      });

      $('#selected-body').on('input change', 'input.qty', updateTotal);
      $('#selected-body').on('click', '.btn-remove', function(){
        $(this).closest('tr').remove();
        updateTotal();
      });
    });

    function addItem(item)
    {
      var existing = $('#selected-body tr[data-id="' + item.id + '"] input.qty');
      if(existing.length)
      {
        existing.val((parseInt(existing.val()) || 0) + 1);
      }
      else
      {
        var weight = (item.old_gold ? 'MT ' : '') + escapeHtml(item.weight) + ' GR';
        $('#selected-body').append(
          '<tr data-id="' + item.id + '">' +
            '<td>' + escapeHtml(item.name) + ' <small class="text-muted">(' + escapeHtml(item.code) + ')</small>' +
              '<input type="hidden" name="ids[]" value="' + item.id + '"></td>' +
            '<td>' + weight + '</td>' +
            '<td><input type="number" min="1" name="quantities[]" class="form-control input-sm qty" value="1"></td>' +
            '<td class="text-center"><a class="btn btn-xs btn-danger btn-remove"><i class="fa fa-times"></i></a></td>' +
          '</tr>'
        );
      }
      updateTotal();
    }

    function submitForm(btn)
    {
      var total = 0;
      $('#selected-body input.qty').each(function(){ total += parseInt($(this).val()) || 0; });

      if(total < 1)
      {
        alert('Silahkan pilih barang terlebih dahulu');
        return;
      }

      if(total % 2 == 1 && !confirm('Jumlah label ganjil (' + total + '), baris terakhir akan kosong sebelah. Lanjut print?'))
        return;

      btn.disabled = true;
      document.getElementById('print-form').submit();
    }
  </script>
@endsection