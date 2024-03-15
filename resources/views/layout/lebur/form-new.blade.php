<div class="panel-body" style="color: black !important;">
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                {!! Form::label('category_id', 'Kategori', array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::select('category_id', getCategories(), null, ['class' => 'form-control select2',
                    'style'=>'width: 100%', 'id' => 'category_id']) !!}
                </div>
            </div>
            <!-- <div class="form-group">
                {!! Form::label('code', 'Barcode Barang', array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::text('code', null, array('class' => 'form-control', 'id' => 'code')) !!}
                    {{-- <input name="generate" type="checkbox" checked="checked" id="generate"> Generate code --}}
                </div>
            </div> -->

            <div class="form-group">
                {!! Form::label('name', 'Nama Barang', array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::text('name', null, array('class' => 'form-control','required'=>'required', 'id' => 'name')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('description', 'Deskripsi Barang', array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::textarea('description', null, array('class' => 'form-control', 'id' => 'description')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('price', 'Biaya Pembuatan', array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::text('price', null, array('class' => 'form-control', 'required'=>'required', 'id' => 'price', 'onkeyup' => 'formatNumber("price")')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('selling_price', 'Harga Jual', array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::text('selling_price', null, array('class' => 'form-control', 'id' => 'selling_price', 'placeholder' => 'Boleh Kosong', 'onkeyup' => 'formatNumber("selling_price")')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('percentage', 'Persentase', array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::select('percentage', getPercentages(), null, ['class' => 'form-control select2',
                    'style'=>'width: 100%', 'id' => 'percentage']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('weight', 'Berat', array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::text('weight', null, array('class' => 'form-control', 'required'=>'required', 'id' => 'weight')) !!}
                </div>
            </div>

            <div class="form-group">
                {{ csrf_field() }}

                <div class="col-sm-12">
                    <hr>
                    @if($SubmitButtonText == 'Edit')
                        {!! Form::submit($SubmitButtonText, ['class' => 'btn form-control'])  !!}
                    @elseif($SubmitButtonText == 'Tambah')
                        {!! Form::submit($SubmitButtonText, ['class' => 'btn form-control'])  !!}
                    @elseif($SubmitButtonText == 'View')
                        <a href="{{ url($role . '/category/' . $category->id . '/edit') }}" class="btn form-control">Ubah Data Kategori</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@section('js-addon')
  <script type="text/javascript">
    $(document).ready(function(){
        $('.select2').select2();
    });

    function formatNumber(name)
    {
        num = document.getElementById(name).value;
        num = num.toString().replace(/,/g,'');
        document.getElementById(name).value = num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    }
</script>
@endsection