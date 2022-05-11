@extends('layouts.master')

@section('title')
Basket
@endsection

@section('content')
<br><br>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-header">
                    <p class="card-description">Opstra Options Analytics</p>
                    <a href="{{route('basket.create')}}" class="btn btn-primary btn-round float-end">Add</i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <span id="result"></span>
                        <table  class=" table table-bordered "  >
                            <thead>
                                <tr>
                                    <th><b> Basket Name</b></th>
                                    <!--<th><b> Target</b></th>-->
                                    <th><b>Init Target</b></th>
									<th><b>Target Strike</b></th>
									<th><b>Stop Loss</b></th>
									<th><b>Current Target</b></th>
									<th><b>Status</b></th>
									<th><b>Total PNL</b></th>
                                    <!--<th><b> Scheduled Exc</b></th>-->
                                    <!--<th><b> Scheduled_sq Off</b></th>-->
                                    <!--<th><b> Recorring</b></th>-->
                                    <!--<th><b> WeekDays</b></th>-->
                                    <!--<th><b> Strategy</b></th>-->
                                    <th><b> qty</b></th>
                                    <th><b>Action</b></th>
                                </tr>
                            </thead>    
                            <tbody id="basketList">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>&nbsp;
        </div>
    </div>
</div>

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
	},1000);
	function realTime() {
		$.ajax({
			type:'get',
			url:'{{ route( 'basket.data' ) }}',
			data:{
				'_token':"{{ csrf_token() }}",
			},
			success: function (result) {
			    $('#basketList').html('');
				$.each(result.data, function (key, value){
				        console.log(value.target_strike);
				    $("#basketList").append('<tr><td>'+value.basket_name+'</td><td>'+value.init_target+'</td><td>'+value.target_strike+'</td><td>'+value.stop_loss+'</td><td>'+value.prev_current_target+'</td><td></td><td>'+value.Pnl+'</td><td>'+value.qty+'</td><td><button class= "btn btn-warning edit_data" id="show" data-id='+value.id+'> View </button></td></tr>');	    
				})
			},
			error: function () {
				console.log('Error');
			}
		});
	}
});
</script>
<script>
    $(document).ready(function(){
        $('body').on("click", ".edit_data", function(){
            var id = $(this).attr("data-id");
            var base_url = window.location.origin;
            window.location.href = base_url + "/holdings?basket_id=" + id + "";                      
        })
    });
</script>



@endsection