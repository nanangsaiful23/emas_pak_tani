<html>
	<style type="text/css">
		@page {
		  size: A4;
		  margin: 0;
		}
/*		@media print {*/
		 /* html, body {
		    width: 210mm;
		    height: 297mm;
		  }*/
			table {
			  border-collapse: collapse;
			}

			table, th, td {
			  border: 2px solid black;
			  margin: 10px;
			  padding: 20px;
			  height: 40px;
			}

			.none, .none td
			{
				border: none !important;
			}

			.no-pad, .no-pad td
			{
				height: 20px;
			}
/*		}*/
		.container {
		  width: 100%;
		  height: 100%;
		  position: relative;
		}
		.navi,
		.infoi {
		  width: 100%;
		  height: 100%;
		  position: absolute;
		  top: 0;
		  left: 0;
		}
		.infoi {
		  z-index: 10;
		}
	</style>
    <link rel="stylesheet" href="{{asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/print-style.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cookie&family=Cormorant&family=Dosis&family=Noto+Sans+Arabic&family=Crimson+Text&family=Dancing+Script&family=Inter:wght@300;400;500;600">
	<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

	<body style="font-family: 'inter'" class="container">
		<div class="infoi">
			<div class="wrapper" style="margin-top: 20px;">
				<div class="row">
					<div class="col-sm-12">
						<div class="col-sm-2">	
	            			<img src="{{asset('assets/icon/TokoPaktani.png')}}" alt="about" style="display: block;width: 100%;margin-left: auto;margin-right: auto;display: block;">
						</div>
						<div class="col-sm-5" style="text-align: center; font-size: 20px;">	
							<b>Toko Mas Asli<br>
							<span style="font-family: 'Dancing script'; font-size: 30px;">{{ config('app.store_name') }}</span><br></b>
							{{ config('app.address') }}<br>
							{{ config('app.phone_number') }}<br>
						</div>
						<div class="col-sm-5">	
							<table class="none no-pad" style="font-size: 14px">
								<tr>
									<td>Nama</td>
									<td>:</td>
									<td style="border-bottom: 0.5px dotted !important;"></td>
								</tr>
								<tr>
									<td>Alamat</td>
									<td>:</td>
									<td style="border-bottom: 0.5px dotted !important;"></td>
								</tr>
								<tr>
									<td>Telp/HP</td>
									<td>:</td>
									<td style="border-bottom: 0.5px dotted !important;"></td>
								</tr>
								<tr>
									<td>Tanggal</td>
									<td>:</td>
									<td style="border-bottom: 0.5px dotted !important;">{{ displayDate($transaction->created_at) }}</td>
								</tr>
								<tr>
									<td>Sales person</td>
									<td>:</td>
									<td style="border-bottom: 0.5px dotted !important;"></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="col-sm-12" style="text-align:center; margin-top: 10px; font-weight: bold;">
						<div class="col-sm-offset-1 col-sm-7" style="font-size: 18px; border: black solid 3px;">
							TERDEPAN DALAM MODEL DAN PENAMPILAN
						</div>
						<div class="col-sm-4" style="font-size: 18px">
							NPWP: 06 314 032 1 504
						</div>
					</div>
				</div>
			</div>
			<hr>
			<table class="col-sm-11" style="font-size: 16px; text-align: center;">
				<thead style="font-weight: bold;">
					<td>Kode</td>
					<td>Berat</td>
					<td>Kadar</td>
					<td>Harga</td>
					<td>Barang</td>
					<td>Jumlah</td>
				</thead>
				<tbody>	
					@foreach($transaction->details as $detail)
						<tr>
							<td>{{ $detail->good_unit->good->code }}</td>
							<td>{{ $detail->good_unit->good->weight }}</td>
							<td>{{ $detail->good_unit->good->percentage->name }}</td>
							<td style="text-align: right !important;">{{ showRupiah($detail->gold_price) }}</td>
							<td style="text-align: left !important; padding-left: 10px;">
								{{ $detail->good_unit->good->name }}
							</td>
							<td style="text-align: right !important;">{{ showRupiah($detail->sum_price) }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<table class="col-sm-11 none" style="font-size: 20px; text-align: center;">
				<tr>
					<td style="width: 40%">
						{!! DNS1D::getBarcodeSVG(date('Y') . $detail->good_unit->good->getBarcode(), 'UPCE', 2, 50, 'black', false) !!}
					</td>
					<td style="text-align: right !important" width="60%">
						Total akhir
					</td>
					<td style="text-align: right !important; padding-left: 10px;">
						{{ showRupiah(checkNull($transaction->total_sum_price)) }}
					</td>
				</tr>
				<!-- <tr style="margin-top: 10px;">
					<td style="text-align: right !important" width="80%">Bayar</td>
					<td style="text-align: right !important">{{ showRupiah(checkNull($transaction->money_paid)) }}</td>
				</tr> -->
				<!-- <tr style="margin-top: 10px;">
					<td style="text-align: right !important" width="80%">Kembali</td>
					<td style="text-align: right !important">{{ showRupiah(checkNull($transaction->money_returned)) }}</td>
				</tr> -->
			</table>
			<hr>
			<div class="wrapper">
				<div class="row">
					<div class="col-sm-12">
						<div class="col-sm-offset-1 col-sm-6" style="font-size: 14px; border: solid black 3px; text-align: center;">
							BERAT & KARAT telah diperiksa dengan betul<br>
							penjualan kembali menurut harga umum pembelian
						</div>
						<div class="col-sm-offset-1 col-sm-3" style="font-size: 16px; border: solid black 3px; text-align: center; font-weight: bold;">
							MINGGU KE 4 TUTUP
						</div>
					</div>
				</div>
			</div>

			
			<div class="wrapper" style="margin-top: 70px">
				<div class="row">
					<div class="col-sm-12">
						<div class="col-sm-2">	
	            			<img src="{{asset('assets/icon/TokoPaktani.png')}}" alt="about" style="display: block;width: 100%;margin-left: auto;margin-right: auto;display: block;">
						</div>
						<div class="col-sm-5" style="text-align: center; font-size: 20px;">	
							<b>Toko Mas Asli<br>
							<span style="font-family: 'Dancing script'; font-size: 30px;">{{ config('app.store_name') }}</span><br></b>
							{{ config('app.address') }}<br>
							{{ config('app.phone_number') }}<br>
						</div>
						<div class="col-sm-5">	
							<table class="none no-pad" style="font-size: 14px">
								<tr>
									<td>Nama</td>
									<td>:</td>
									<td style="border-bottom: 0.5px dotted !important;"></td>
								</tr>
								<tr>
									<td>Alamat</td>
									<td>:</td>
									<td style="border-bottom: 0.5px dotted !important;"></td>
								</tr>
								<tr>
									<td>Telp/HP</td>
									<td>:</td>
									<td style="border-bottom: 0.5px dotted !important;"></td>
								</tr>
								<tr>
									<td>Tanggal</td>
									<td>:</td>
									<td style="border-bottom: 0.5px dotted !important;">{{ displayDate($transaction->created_at) }}</td>
								</tr>
								<tr>
									<td>Sales person</td>
									<td>:</td>
									<td style="border-bottom: 0.5px dotted !important;"></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="col-sm-12" style="text-align:center; margin-top: 10px; font-weight: bold;">
						<div class="col-sm-offset-1 col-sm-7" style="font-size: 18px; border: black solid 3px;">
							TERDEPAN DALAM MODEL DAN PENAMPILAN
						</div>
						<div class="col-sm-4" style="font-size: 18px">
							NPWP: 06 314 032 1 504
						</div>
					</div>
				</div>
			</div>
			<hr>
			<table class="col-sm-11" style="font-size: 16px; text-align: center;">
				<thead style="font-weight: bold;">
					<td>Kode</td>
					<td>Berat</td>
					<td>Kadar</td>
					<td>Harga</td>
					<td>Barang</td>
					<td>Jumlah</td>
				</thead>
				<tbody>	
					@foreach($transaction->details as $detail)
						<tr>
							<td>{{ $detail->good_unit->good->code }}</td>
							<td>{{ $detail->good_unit->good->weight }}</td>
							<td>{{ $detail->good_unit->good->percentage->name }}</td>
							<td style="text-align: right !important;">{{ showRupiah($detail->gold_price) }}</td>
							<td style="text-align: left !important; padding-left: 10px;">
								{{ $detail->good_unit->good->name }}
							</td>
							<td style="text-align: right !important;">{{ showRupiah($detail->sum_price) }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<table class="col-sm-11 none" style="font-size: 20px; text-align: center;">
				<tr>
					<td style="width: 40%">
						{!! DNS1D::getBarcodeSVG(date('Y') . $detail->good_unit->good->getBarcode(), 'UPCE', 2, 50, 'black', false) !!}
					</td>
					<td style="text-align: right !important" width="60%">
						Total akhir
					</td>
					<td style="text-align: right !important; padding-left: 10px;">
						{{ showRupiah(checkNull($transaction->total_sum_price)) }}
					</td>
				</tr>
				<!-- <tr style="margin-top: 10px;">
					<td style="text-align: right !important" width="80%">Bayar</td>
					<td style="text-align: right !important">{{ showRupiah(checkNull($transaction->money_paid)) }}</td>
				</tr> -->
				<!-- <tr style="margin-top: 10px;">
					<td style="text-align: right !important" width="80%">Kembali</td>
					<td style="text-align: right !important">{{ showRupiah(checkNull($transaction->money_returned)) }}</td>
				</tr> -->
			</table>
			<hr>
			<div class="wrapper">
				<div class="row">
					<div class="col-sm-12">
						<div class="col-sm-offset-1 col-sm-6" style="font-size: 14px; border: solid black 3px; text-align: center;">
							BERAT & KARAT telah diperiksa dengan betul<br>
							penjualan kembali menurut harga umum pembelian
						</div>
						<div class="col-sm-offset-1 col-sm-3" style="font-size: 16px; border: solid black 3px; text-align: center; font-weight: bold;">
							MINGGU KE 4 TUTUP
						</div>
					</div>
				</div>
			</div>
		  	<div class="navi">
		  		@for($i = 0; $i < 36; $i++)
            		<img src="{{asset('assets/icon/watermark.png')}}" alt="about" style="margin-left: 10px; display: relative;width: 30%; opacity: 10%;">
            	@endfor
            </div>
		</div>
	</body>

	<script type="text/javascript">		
        $(document).ready (function (){
        	window.print();
        }); 

	    window.setTimeout(function(){
      		window.location = window.location.origin + '/{{ $role }}/transaction/create';
	    }, 5000);
	</script>
</html>