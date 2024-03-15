<html>
	<style type="text/css">
		@page 
		{ 
			size: 80mm 24mm;  
			size: landscape;
/*			margin: -0.1in; */
		}

		@media print
		{
			@page 
			{ 
				size: 80mm 24mm;  
				size: landscape;
/*				margin: ; */
			}

			.space
			{
				width: 48mm;
				height: 10mm;
			}
		}

		table {
		  border-collapse: collapse;
		}

		table, th, td {
/*		  border: 0.1px solid black;*/
			color: darkblue;
		}
	</style>
	<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
	<body style="margin-left: 10mm; margin-right: 12mm;">
	<!-- <body> -->
		<table class="space-top-2">
			<tbody>	
				<?php $i = 0; ?>
				@while(isset($goods[$i]))
					<tr>
						@if(isset($goods[$i * 2 + 1]))
			            	<td style="width: 20mm; height: 10mm;">
				            	<div style="text-align: center;">
					            	<div style="font-size: 5px;">{!! DNS1D::getBarcodeSVG(date('Y') . $goods[$i * 2]['barcode'], 'UPCE', 1.3, 20, 'black', false) !!}</div>
					            	<div style="font-size: 7px; margin-top: 0.4mm; text-align: center; width: 20mm; text-transform: uppercase;">
					            		<b>{{ $goods[$i * 2]['code'] }}</b>
					            	</div>
					            	<div style="font-size: 10px; text-align: center; margin-top: 2mm;">
					            		<b>{{ $goods[$i * 2]['old_gold'] . ' ' . $goods[$i * 2]['weight'] }}GR</b>
					            	</div>
					            	@if($goods[$i * 2]['stone_weight'] != '0.00')
						            	<div style="font-size: 7px; text-align: center;">
						            		<b>{{ 'BATU ' . $goods[$i * 2]['stone_weight'] }}GR</b>
						            	</div>
						            	<div style="font-size: 7px; text-align: center;">
						            		<b>{{ 'ONGKOS ' . $goods[$i * 2]['stone_price'] }}</b>
						            	</div>
						            @endif
				            	</div>
				            </td>
			            	<td class="space">
				            	<div style="text-align: center;">
				            	</div>
				            </td>
			            	<td style="width: 20mm; height: 10mm;">
				            	<div style="text-align: center;">
					            	<div style="font-size: 5px;">{!! DNS1D::getBarcodeSVG(date('Y') . $goods[$i * 2 + 1]['barcode'], 'UPCE', 1.3, 20, 'black', false) !!}</div>
					            	<div style="font-size: 7px; margin-top: 0.4mm; text-align: center; width: 20mm; text-transform: uppercase;">
					            		<b>{{ $goods[$i * 2 + 1]['code'] }}</b>
					            	</div>
					            	<div style="font-size: 10px; text-align: center; margin-top: 2mm;">
					            		<b>{{ $goods[$i * 2 + 1]['old_gold'] . ' ' . $goods[$i * 2 + 1]['weight'] }}GR</b>
					            	</div>
					            	@if($goods[$i * 2 + 1]['stone_weight'] != '0.00')
						            	<div style="font-size: 7px; text-align: center;">
						            		<b>{{ 'BATU ' . $goods[$i * 2 + 1]['stone_weight'] }}GR</b>
						            	</div>
						            	<div style="font-size: 7px; text-align: center;">
						            		<b>{{ 'ONGKOS ' . $goods[$i * 2]['stone_price'] }}</b>
						            	</div>
						            @endif
				            	</div>
				            </td>
			            @endif
					</tr>
					<?php $i++; ?>
				@endwhile 
			</tbody>
		</table>
	</body>

	<script type="text/javascript">		
        $(document).ready (function (){
        	window.print();
        }); 

	    window.setTimeout(function(){
      		window.location = window.location.origin + '/{{ $role }}/good/printBarcode';
	    }, 5000);
	</script>
</html>