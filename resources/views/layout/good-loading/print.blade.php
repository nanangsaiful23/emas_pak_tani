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
			<div class="wrapper">
				<div class="row">
					<div class="col-sm-12">
						<div class="col-sm-5" style="text-align: center; font-size: 20px;">	
							<b>Toko Mas Asli<br>
							<span style="font-family: 'Dancing script'; font-size: 30px;">Pak Tani</span><br></b>
							Jalan Sultan Fatah no 38A<br>
							Telp (0291)685156 Demak<br>
						</div>
						<div class="col-sm-2">	
	            			<img src="{{asset('assets/icon/TokoPaktani.png')}}" alt="about" style="display: block;width: 100%;margin-left: auto;margin-right: auto;display: block;">
						</div>
						<div class="col-sm-offset-1 col-sm-4" style="font-size: 18px">	
							<b>{{ displayDate($good_loading->created_at) }}<br></b>
							Persentase<br>
							TUA 75% 80% 83% 85%<br>
							STW 33% 37%<br>
							MUDA 28% 30%
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
			<table class="col-sm-11" style="font-size: 20px; text-align: center;">
				<thead style="font-weight: bold;">
					<td>Nama</td>
					<td>Persentase</td>
					<td>Code</td>
					<td>Berat</td>
					<td>Harga</td>
				</thead>
				<tbody>	
					@foreach($good_loading->details as $detail)
						<tr>
							<td style="text-align: left !important; padding-left: 10px;">
								{{ $detail->good_unit->good->name }}
							</td>
							<td>{{ $detail->good_unit->good->percentage->name }}</td>
							<td>{{ $detail->good_unit->good->code }}</td>
							<td>{{ $detail->good_unit->good->weight }} gram</td>
							<td style="text-align: right !important;">{{ showRupiah($detail->price) }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<table class="col-sm-11 none" style="font-size: 20px; text-align: center;">
				<tr>
					<td style="text-align: right !important" width="80%">
						Total akhir
					</td>
					<td style="text-align: right !important">
						{{ showRupiah(checkNull($good_loading->total_item_price)) }}
					</td>
				</tr>
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
		  		@for($i = 0; $i < 12; $i++)
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
      		window.location = window.location.origin + '/{{ $role }}/good-loading/loading/create';
	    }, 5000);
	</script>
</html>