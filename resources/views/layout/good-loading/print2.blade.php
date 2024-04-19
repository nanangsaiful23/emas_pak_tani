<html>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=AR+One+Sans&family=Glegoo:wght@300;400;500;600">
	<style type="text/css">
		body, table, th, td
		{
			font-family: "Glegoo" !important;
/*			font-weight: bold;*/
		}
		table {
		  border-collapse: collapse;
		  margin-left: auto;
		  margin-right: auto;
		}

		table, th, td {
		  /*border: 0.1px solid black;*/
		}

		hr.new2 {
		  border-top: 1px dashed;
		}
	</style>
	<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
	<body style="font-size: 10px;">
		<div style="text-align: center;">
			{{ config('app.name') }}<br>
			{{ config('app.offline_address') }}<br>
			Menerima pesanan<br>
			wa/telp {{ config('app.phone_number') }}
			<hr class="new2">
			{{ displayDateTime($good_loading->created_at) }}<br>
			Kasir: {{ $good_loading->actor()->name }}<br>
			<hr class="new2">
		</div>
		<div style="text-align: center;">
			<table style="font-size: 10px; text-align: center;">
				<?php $i = 1; ?>
				@foreach($good_loading->details as $detail)
					<tr>
						<td style="text-align: left !important;">
							@if($detail->type == 'retur') Retur: @endif
							<b>{{ showShortName($detail->good_unit->good->name) }}</b>
						</td>
						<td></td>
					</tr>
					<tr>
						<td style="text-align: left !important;">
							{{ $detail->good_unit->good->weight }} gram
						</td>
						<td style="text-align: right !important;">
							{{ showRupiah(checkNull($detail->buy_price)) }}
						</td>
					</tr>
				@endforeach
				<tr style="margin-top: 10px;">
					<td colspan="2"><hr></td>
				</tr>
				<tr style="margin-top: 10px; text-align: right !important">
					<td>Total Harga</td>
					<td>{{ showRupiah(checkNull($good_loading->total_item_price)) }}</td>
				</tr>
			</table>
		</div>
	</body>

	<script type="text/javascript">		
        $(document).ready (function (){
        	window.print();
        }); 

	    window.setTimeout(function(){
      		window.location = window.location.origin + '/{{ $role }}/good-loading/{{ $good_loading->type }}/create';
	    }, 5000);
	</script>
</html>