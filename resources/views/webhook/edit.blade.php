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
                    <form action="{{ route('webhook.store') }}" method="post" enctype="multipart/form-data" id="needs-validation" novalidate>
                        {{ csrf_field() }}
                        <div class="card-body">
                            <h3 class="card-description p-1"><b style="color:black">Create New Basket</b></h3>
                            <hr>
                            <div class="row">
                                    <div class="col-sm-4 col-md-4 col-xs-12 mb-3"> 
                                    <label class="mt-3 mb-3"><b>Basket Name</b></label>
                                    <input id="inputFloatingLabel" name="basket_name" type="text"
                                        class="form-control input-border-bottom" placeholder="Basket Name" required>
                                        <div class="invalid-feedback">  
                                            Please enter Basket Name.  
                                        </div> 
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-xs-12 mb-3"> 
                                    <label class="mt-3 mb-3"><b>Initial Target </b></label>
                                    <input id="inputFloatingLabel" name="init_target" type="number"
                                        class="form-control input-border-bottom" placeholder="Init Target" required>
                                        <div class="invalid-feedback">  
                                            Please enter Initial Target.  
                                        </div> 
                                    </div>

                                    <div class="col-sm-4 col-md-4 col-xs-12 mb-3"> 
                                    <label class="mt-3 mb-3"><b>Target Strike </b></label>
                                    <input id="inputFloatingLabel" name="target_strike" type="number"
                                        class="form-control input-border-bottom" placeholder="Target Strike" required>
                                        <div class="invalid-feedback">  
                                            Please enter Target Strike.  
                                        </div>
                                    </div>

                                <div class="col-md-4 mb-3">
                                    <label class="mt-3 mb-3"><b>Stop Loss </b></label>
                                    <input id="inputFloatingLabel" name="stop_loss" type="number"
                                        class="form-control input-border-bottom" placeholder="Stop Loss" required>
                                        <div class="invalid-feedback">  
                                            Please enter Stop Loss.  
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-md-4 col-xs-12 mb-3"> 
                                    <label class="mt-3 mb-3"><b>Scheduled Start</b></label>
                                    <input id="inputFloatingLabel" name="scheduled_exec" type="date"
                                        class="form-control input-border-bottom" placeholder="Scheduled Exc" required>
                                        <div class="invalid-feedback">  
                                            Please enter Scheduled Start.  
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-md-4 col-xs-12 mb-3"> 
                                    <label class="mt-3 mb-3"><b>Scheduled Sq-off</b></label>
                                    <input id="inputFloatingLabel" name="scheduled_sqoff" type="date"
                                        class="form-control input-border-bottom" placeholder="Scheduled_sq Off" required>
                                        <div class="invalid-feedback">  
                                            Please enter Scheduled Sq-off.  
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-md-4 col-xs-12 mb-3"> 
                                    <label class="mt-3 mb-3"><b>Quantity</b></label>
                                    <input id="inputFloatingLabel" name="qty" type="number"
                                        class="form-control input-border-bottom" placeholder="qty" required>
                                        <div class="invalid-feedback">  
                                            Please enter Quantity.  
                                        </div>
                                    </div>    
                                    {{-- <div class="col-sm-4 col-md-4 col-xs-12 mb-3"> 
                                        <label class="mt-3 mb-3"><b> Select Segment </b></label>
                                        <select  class="form-control has-error" name="segment" id="selectFloatingLabel2" required>
                                            <option value="">Select Segment</option>
                                            <option value="1">EQUITY </option>
                                            <option id="fno" value="2">F&O</option>
                                        </select>
                                    </div>     --}}
                                    <div class="row">  
                                        <div class="col-sm-12 col-md-12 col-xs-12">  
                                            <div class="form-group">  
                                                <label>&nbsp;&nbsp;&nbsp;<b>Recorring:</b></label>
                                            </div>  
                                            
                                            <div class="form-check-inline">  
                                                <div class="custom-control custom-radio ">  
                                                    <input type="radio" class="custom-control-input" id="yes" aria-describedby="inputGroupPrepend" name="recorring" value="Yes"  required/>
                                                    &nbsp; <label class="custom-control-label" for="yes">Yes</label>  
                                                    <div class="invalid-feedback">Choose Yes/No</div>  
                                                </div>  
                                            </div>  
                                            <div class="form-check-inline">  
                                                <div class="custom-control custom-radio ">  
                                                    <input type="radio" class="custom-control-input" id="no" aria-describedby="inputGroupPrepend" name="recorring" value="No"  required/>
                                                    <label class="custom-control-label" for="no">No</label>  
                                                    <div class="invalid-feedback">Choose Yes/No</div>  
                                                </div>  
                                            </div>                     
                                        </div>  
                                    </div>                                        
                            </div>

                            <div class=" mb-3">
                                <label style="font-size:15px; color:black; font-weight:800">SELECT THE OPTIONS STRATEGY OR
                                    EQUITY</label>
                                &nbsp;&nbsp;
                                <!-- Button trigger modal -->
                                <a class="btn btn-success" href="javascript:void(0)" id="createNewCustomer"> Create New
                                    STRATEGY</a>
                            </div>
                            <div class="modal fade" data-keyboard="false" data-backdrop="static" id="ajaxModel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div style="width:550px; background-color:white" class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="modelHeading">SELECT THE STRIKE TO EXECUTE</h4>

                                        </div>
                                        <div class="modal-body">
                                            <!--<input id="search" style="height:30px; width:150px" type="text" placeholder="INDICES" name="indices" value="BANKNIFTY"/>-->
                                            <!--<ul id="searchResult"></ul>-->
                                            <!--<input style="height:30px; width:150px" type="text" placeholder="Expiry Ex. DDMMMYYYY" name="expiry" value="12MAY2022"/>-->
                                            <!--<button type="button" name="add" id="add" class="btn-sm btn-success float-right">Add</button>-->
                                            <div class="autocomplete" style="width:300px;">
                                                <input id="myInput" type="text" placeholder="Search Instrument.Ex.Reliance..">
                                                <div class="autocomplete-items" id="results"></div>
                                            </div>
                                        </div>
                                        <br>
                                        <table class="table  table-condensed" id="user_table">
                                            <thead>
                                                <tr>
                                                </tr>
                                            </thead>
                                            <tbody id="s_body">
                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="col-sm float-sm-right">
                                            <button id="cancel" type="button" class="btn btn-warning">Cancel</button>
                                            <button id="clear" type="button" class="btn btn-primary">Clear</button>
                                            <button id="save" type="button" class="btn btn-success">Save</button>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-3 mb-3 ">
                            <button class="btn btn-secondary" onclick="submitteForm()" id ="savebasket" type="submit">Submit</button>
                            <a href="{{ route('webhook.index') }}" type="submit"   class="btn btn-primary me-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#myInput').keyup(function() {
                var query = $(this).val();
                if ((query != '') && (query.length > 4)) {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('autocomplete') }}",
                        method: "POST",
                        data: {
                            query: query,
                            _token: _token
                        },
                        dataType: 'json',
                        success: function(response) {
                            // console.log(response);
                            var len = response.length;
                            $('#results').html('');
                            for (var i = 0; i < len; i++) {
                                var id = response[i]['instrument_token'];
                                var names = response[i]['tradingsymbol'];
                                $('#results').append('<div onClick="on_click(\'' + id +
                                    '\',\'' + names + '\')">' + names + '</div>');
                            }

                        }
                    });
                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#createNewCustomer').click(function() {
                $('#ajaxModel').modal('show');
            });
            var disableButton = false;
            document.getElementById("savebasket").disabled = true;
        });

        function on_click(click_id, token_name) {
            var strike_type = token_name.slice(-2);
            count++;
            dynamic_field(count, click_id, token_name, strike_type);
            $('#results').html('');
        }

        var count = 1;
        // dynamic_field(count, click_id);
        function dynamic_field(number, click_id, token_name, strike_type) {
            html = '<tr>';
            html += '<td><div class="mt-1"><input type="hidden" style="height:30px; width:100px" name="data['+number+'][token_id]"  class="form-control " value="' +click_id+'" required /></div></td>';
            html +='<td><label class="mt-1"><b>Token Strike</b></label><div class="mt-1"> <input type="text" style="height:30px; width:180px" name="data['+number+'][token_strike]"  class="form-control input-border-bottom "  value="'+token_name+'" required readonly/></div></td>';
            html +='<td><label class="mt-1"><b>Token Strike</b></label><div class="mt-1"> <input type="text" style="height:30px; width:80px" name="data['+number+'][strick_type]"  class="form-control input-border-bottom"  value="'+strike_type+'" required readonly/></div></td>';

            // html +='<td><label class="mt-1"><b>Strike Type</b></label><div class="mt-1"><select  style="height:30px; width:80px" class="selectpicker" disabled name="data['+number+'][strick_type]"><option>'+strike_type+'</option ><option value="CE">CE</option><option value="PE">PE</option></select></div></td>';
            html +='<td><label class="mt-1 "><b>Order Type</b></label><div class="mt-1"><select style="height:30px; width:80px" class="selectpicker" id="test"  name="data['+number+'][order_type]" ><option value="empty">-Select-</option><option value="Buy">Buy</option><option  value="Sell">Sell</option></select></div></td>';
            if (number > 1) {
                html +=
                    '<td><button type="button" name="remove" id="" class="btn btn-danger btn-sm remove">X</button></td></tr>';
                $('#s_body').append(html);
            } else {
                html += '<td></td></tr>';
                $('#s_body').html(html);
            }
        }

        $(document).on('click', '.remove', function() {
            count--;
            $(this).closest("tr").remove();
        });


        $('#cancel').click(function() {
            // $('tbody').html('');
            var token_items = decodeURIComponent($('form').serialize());      
            $('#ajaxModel').modal('hide');
            console.log($('tbody tr'));
        });

        $('#clear').click(function() {
            $('#s_body').html('');
            document.getElementById("savebasket").disabled = true;
        });

        $('#save').click(function() {
           var token_items = decodeURIComponent($('form').serialize());     
           if(token_items.search("empty") > 0){
            alert("Please select the Order Type..!!");
           }else if(token_items.search("token_id") < 0){
               alert("Stock Instrument Cannot be empty..!!");
           }else{
            $('#ajaxModel').modal('hide');
            document.getElementById("savebasket").disabled = false;
           }
        });

        // $('#fno').click(function() {
        //     alert("in");
        //     $('#createNewCustomer').hide();
        // });

       

    </script>
     <script type="text/javascript">  
        (function () {  
            'use strict';  
            window.addEventListener('load', function () {  
                var form = document.getElementById('needs-validation');  
                form.addEventListener('submit', function (event) {  
                    if (form.checkValidity() === false) {  
                        event.preventDefault();  
                        event.stopPropagation();  
                    }  
                    form.classList.add('was-validated');  
                }, false);  
            }, false);  
        })();
    </script> 

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font: 16px Arial;
        }

        .autocomplete {
            position: relative;
            display: inline-block;
        }

        input {
            border: 1px solid transparent;
            background-color: #f1f1f1;
            padding: 10px;
            font-size: 16px;
        }

        input[type=text] {
            background-color: #f1f1f1;
            width: 100%;
        }

        input[type=submit] {
            background-color: DodgerBlue;
            color: #fff;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /position the autocomplete items to be the same width as the container:/
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        .autocomplete-items div:hover {
            /when hovering an item:/
            background-color: #e9e9e9;
        }

        .autocomplete-active {
            /when navigating through the items using the arrow keys:/
            background-color: DodgerBlue !important;
            color: #ffffff;
        }

    </style>
@endsection