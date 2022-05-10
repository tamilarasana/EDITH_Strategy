@extends('layouts.master')
@section('title')
strategy
@endsection

@section('content')     
<br><br>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 "> 
			<div class="card"> 
				<div class="card-body">
					<div class="d-flex justify-content-between">
						<div class="col-xs-6 col-sm-4 col-md-4">
							<label  ><b style="color: rgb(155, 155, 155)">Investment</b></label>
							<div class="mt-2" style="color: rgb(0, 0, 0)" ><b>Rs. &nbsp;</b><span style="color: rgb(0, 0, 0); font-weight:700" id="total"></span></div>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-4">
							<label ><b style="color: rgb(155, 155, 155)">Current</b></label>
							<div class="mt-2" style="color: rgb(0, 0, 0)" ><b>Rs. &nbsp;</b><span style="color: rgb(0, 0, 0); font-weight:700" id="current"></span></div>
						</div>
					</div>
					<hr>
						<div class="d-flex justify-content-between">
							<div class="col-md-6  ">
								<label ><b style="font-size: 15px"> TOTAL P&L</b></label>
							</div>
							<div class="col-md-6  ">
								<h5><span id="totalPnl" style="font-size: 18px; color:rgb(72, 189, 18); font-weight:700"></span>&nbsp<span id="pnlPers" style="font-size: 15px; color:rgb(72, 189, 18)"></span></h5>
							</div>
					
					  </div>
					  <div>
						<hr>
						 <div id="qty"><div>
						
					  					 
				</div>
					
				</div>	
					
			</div>
		</div>

	</div>
		{{-- <div class="col-md-12 ">  
			<div class="card"> 
				<div class="card-body"> --}}
</div>
{{-- <div class="container-fluid"> 
	<div class="row">
		<div class="col-md-12 grid-margin">
			<div class="card"> 
				<div class="card-body">
					<div class=" float-right">
						<label><b>Total P&L : </b></label>
						<input  type="text" class=""  id="totalpl" disabled>
					</div>
					<div class=" float-right">
						<label><b>Total Invesment : </b></label>
						<input  type="text" class=""  id="total" disabled>
					</div>
						<p class="card-description"></p>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table  table-condensed">
								<thead>
									<tr>
										<th>Basket Name</th>
										<th>Token Name</th>
										<th>Token Id</th>
										<th>Leg Type</th>
										<th>Quantity</th>
										<th>Order</th>
										<th>OAP</th>
										<th>LTP</th>
										<th>P&L</th>
										<th>P&L %</th>
										<th>Total Inv </th>
									</tr>
								</thead>
								<tbody id="payment" >
								</tbody>							
							</table>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
</div> --}}

@endsection
@section('scripts')
<script>
	$(document).ready(function(){
		$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	setInterval(function(){
		realTime();	
		// changeColor();
	},1000);
	function realTime() {
		$.ajax({
			type:'get',
			url:'{{ route( 'holdings.data' ) }}',
			data:{
				'_token':"{{ csrf_token() }}",
			},
			success: function (result) {
				$('#qty').html('');
				$('#total').html('');
				var totalinv = 0;
				var current = 0;
				var totalPnl = 0;
				var pnlPers = 0;
				var orderPnlPers = 0;
				// Create our number formatter.
				var formatter = new Intl.NumberFormat('en-US', {
				style: 'currency',
				currency: 'INR',

				// These options are needed to round to whole numbers if that's what you want.
				minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
				//maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
				});
				$.each(result.order, function (key, value){
				console.log(value);
				totalinv += value.total_inv
				totalPnl += value.pnl
				pnlPers = totalPnl / totalinv 
				orderPnlPers = value.pnl / value.total_inv
				var pnl = formatter.format(value.pnl);
				$('#qty').append('<div class="d-flex justify-content-between" ><div class="col-md-4 col-xl-12"><span >'+value.qty+' Qty</span><label>.</label><label>&nbsp; Avg Price '+value.order_avg_price.toFixed(2)+'</label><label class="float-right"><b style="font-size: 13px; color:rgb(105, 105, 105)">'+orderPnlPers.toFixed(2)+'%</b></label></div></div><br><div class="d-flex justify-content-between"><div class="col-md-4 col-xl-12"><label><b style="color: black; font-size:13px">'+value.basket_name+'</b></label><label class="float-right"><b style="font-size: 13px; color:rgb(72, 189, 18)">'+pnl+'</b></label></div></div><br><div class="d-flex justify-content-between"><div class="col-md-4 col-xl-12"><label>Invested : <span style="color: rgb(0, 0, 0)"><b>'+value.total_inv+'</b></span></label><label class="float-right">LTP : <span style="color: rgb(0, 0, 0)"><b>'+value.ltp.toFixed(2)+'</b></span></label></div></div></div><hr>')
				})
				$('#total').html(formatter.format(totalinv));	
				$('#current').html(formatter.format(totalPnl + totalinv));
				// $('#totalPnl').html(formatter.format(totalPnl));
			 	// $('#pnlPers').html(pnlPers.toFixed(3)+'%');

				if( totalPnl < 0) {
					$('#totalPnl').html(formatter.format(totalPnl)).css({"color":"#E60000"});
				}
				else if(totalPnl > 0) {
					$('#totalPnl').html(formatter.format(totalPnl)).css({"color":"#32cd32"});
				}

				if(pnlPers < 0 ){
					$('#pnlPers').html(pnlPers.toFixed(3)+'%').css({"color":"#E60000"});
				}else if(pnlPers > 0) {
					$('#pnlPers').html(pnlPers.toFixed(3)+'%').css({"color":"#32cd32"});
				}

				// if(orderPnlPers < 0 ){
				// 	$('#pnlPers').html(pnlPers.toFixed(3)+'%').css({"color":"#E60000"});
				// }else if(orderPnlPers > 0) {
				// 	$('#pnlPers').html(pnlPers.toFixed(3)+'%').css({"color":"#32cd32"});
				// }


			},
			error: function () {
				console.log('Error');
			}
		});
	}

	// function changeColor() {
		
	// } 



});
</script>
<script>
	$(document).on("click", "#deleteRecord", function(){
		var id = $(this).attr("data-id");
		let url = '{{route('oreder.exitprice')}}'
		console.log(url);
		$.ajax({
			url: url + '/' + id,
			type: 'Post',
			dataType: "JSON",
			data:{
				"id":id,
				"_token": "{{ csrf_token() }}"},
			success: function (data)
			{
				alert(data);
				// location.reload();
				// $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
			}
        });           
	});
</script>
@endsection