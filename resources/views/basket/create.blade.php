@extends('layouts.master')

@section('title')
	Basket
@endsection
@section('content')
<br><br>
<div class="container-fluid"> 
<div class="row">
	<div class="col-md-12 ">  
		<div class="card">
		<form action="{{ route('basket.store') }}" method = "post"  enctype="multipart/form-data" >
            {{csrf_field()}}
				<div class="card-body">
					<h3 class="card-description p-1"><b style="color:black">Create New Basket</b></h3>
					<hr>
					<div class="row">
						<div class="col-md-4 mb-3">
							<label class="mt-3 mb-3"><b>Basket Name</b></label>
								<input id="inputFloatingLabel"  name ="basket_name" type="text" class="form-control input-border-bottom"  placeholder = "Basket Name" >
						</div>
						<div class="col-md-4 mb-3">
								<label class="mt-3 mb-3"><b>Initial Target </b></label>
									<input id="inputFloatingLabel"  name ="init_target" type="number" class="form-control input-border-bottom"  placeholder = "Init Target" >
							</div>
							
							<div class="col-md-4 mb-3">
								<label class="mt-3 mb-3"><b>Target Strike </b></label>
									<input id="inputFloatingLabel"  name ="target_strike" type="number" class="form-control input-border-bottom"  placeholder = "Target Strike" >
							</div>

							<div class="col-md-4 mb-3">
								<label class="mt-3 mb-3"><b>Stop Loss </b></label>
									<input id="inputFloatingLabel"  name ="stop_loss" type="number" class="form-control input-border-bottom"  placeholder = "Stop Loss" >
							</div>						
						<div class="col-md-4 mb-3">
							<label class="mt-3 mb-3"><b>Scheduled Start</b></label>
								<input id="inputFloatingLabel"  name ="scheduled_exec" type="date" class="form-control input-border-bottom"  placeholder = "Scheduled Exc" >
						</div>
						<div class="col-md-4 mb-3">
							<label class="mt-3 mb-3"><b>Scheduled Sq-off</b></label>
								<input id="inputFloatingLabel"  name ="scheduled_sqoff" type="date" class="form-control input-border-bottom"  placeholder = "Scheduled_sq Off" >
						</div>
				
						<div class="col-md-4 mb-3">
							<label class="mt-3 mb-3"><b>Quantity</b></label>
								<input id="inputFloatingLabel"  name ="qty" type="number" class="form-control input-border-bottom"  placeholder = "qty" >
						</div>
                       
					</div>
					
					<div class"col-md-3 mb-3">
					    <label style="font-size:15px; color:black; font-weight:800">SELECT THE OPTIONS STRATEGY OR EQUITY</label>
					    &nbsp;&nbsp;
					    <!-- Button trigger modal -->
              <a class="btn btn-success" href="javascript:void(0)" id="createNewCustomer"> Create New STRATEGY</a>
            </div>
            <div class="modal fade" id="ajaxModel" aria-hidden="true">
              <div  class="modal-dialog">
                  <div style="width:550px" class="modal-content">
                      <div class="modal-header">
                          <h4 class="modal-title" id="modelHeading">SELECT THE STRIKE TO EXECUTE</h4>
            
                      </div>
                      <div class="modal-body">
                          <input style="height:30px; width:150px" type="text" placeholder="INDICES" name="indices" value="BANKNIFTY"/>
                          <input style="height:30px; width:150px" type="text" placeholder="Expiry Ex. DDMMMYYYY" name="expiry" value="12MAY2022"/>
                          <button type="button" name="add" id="add" class="btn-sm btn-success float-right">Add</button>
                      <hr>
                      <br>
                          <table class="table  table-condensed"  id="user_table">
                            <thead >
                                <tr>
                                  {{-- <div class"col-md-3 mb-3">
                                    <input style="height:30px; width:150px" type="text" placeholder="TOKEN ID"/>
                                    <input style="height:30px; width:150px" type="text" placeholder="STRIKE PRICE"/>
                                    &nbsp;
                                    <lable style="font-size:18px;font-weight:700">CE</lable>
                                    &nbsp;
                                    <lable style="font-size:18px;font-weight:700">Buy</lable>
                                </div> --}}
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>
                  </div>
              </div>
            </div>
    					<hr>			
					<div class="col-md-3 mb-3 ">
						<button class="btn btn-secondary" type="submit">Submit</button>
            <a href ="{{route('basket.index') }}" type="submit" class="btn btn-primary me-2">Cancel</a>
					</div>
			</form>
		</div>
	</div>  
</div>
</div>




@endsection

@section('scripts')
<script>
  $(document).ready(function(){
    $('#createNewCustomer').click(function () {
          $('#ajaxModel').modal('show');
      });

    $(document).on('click', '#add', function(){
            count++;
            dynamic_field(count);
    });

    var count = 1;
    dynamic_field(count);
      function dynamic_field(number){
        html = '<tr>';
                html += '<td> <label class="mt-1"><b>Token ID</b></label><div class="mt-1"> <input type="text"  style="height:30px; width:100px" name="data['+number+'][token_id]"  class="form-control " placeholder="Token ID" required /></div></td>';
                html += '<td> <label class="mt-1 "><b>Token Strike</b></label><div class="mt-1"> <input type="text"  style="height:30px; width:100px" name="data['+number+'][token_strike]"  class="form-control input-border-bottom" placeholder="Token Strike" required /></div></td>';
                html += '<td> <label class="mt-1 "><b>Strike Type</b></label><div class="mt-1"><select style="height:30px; width:80px" class="selectpicker" name="data['+number+'][strick_type]"><option>-Select-</option value="CE"><option>CE</option><option value="PE">PE</option></select></div></td>';
                html += '<td> <label class="mt-1 "><b>Order Type</b></label><div class="mt-1"><select style="height:30px; width:80px" class="selectpicker" name="data['+number+'][order_type]"><option>-Select-</option><option value="Buy">Buy</option><option  value="Sell">Sell</option></select></div></td>';
            if(number > 1)
            {
                html += '<td><button type="button" name="remove" id="" class="btn btn-danger btn-sm remove">X</button></td></tr>';
                $('tbody').append(html);
            }
            else
            {
                html += '<td></td></tr>';
                $('tbody').html(html);
            }
      }

      $(document).on('click', '.remove', function(){
        count--;
        $(this).closest("tr").remove();
     });
  });

</script>

@endsection