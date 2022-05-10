@extends('layouts.master')

@section('title')
Basket
@endsection

@section('content')
<br><br>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header">
                    <p class="card-description">Opstra Options Analytics</p>
                    <a href="{{route('basket.create')}}" class="btn btn-primary btn-round float-end">Add</i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <span id="result"></span>
                        <table  class=" table table-bordered table-hover "  >
                            <thead>
                                <tr>
                                    <th><b> id</b></th>
                                    <th><b> Basket Name</b></th>
                                    <th><b> Target</b></th>
                                    <th><b>Init Target</b></th>
									<th><b>Target Strike</b></th>
									<th><b>Stop Loss</b></th>
                                    <th><b> Scheduled Exc</b></th>
                                    <th><b> Scheduled_sq Off</b></th>
                                    <th><b> Recorring</b></th>
                                    {{-- <th><b> WeekDays</b></th> --}}
                                    <th><b> Strategy</b></th>
                                    <th><b> qty</b></th>
                                    <th><b> Action</b> </th>
                                </tr>
                            </thead>    
                            <tbody>
                                @foreach ($basketcat as  $result)
                                <tr>
                                    <td id="id_product">{{$result ->id}}</td>
                                    <td>{{$result ->basket_name}}</td>
                                    {{-- <td>{{$result ->sq_target}}</td> --}}
                                    <td>{{$result ->init_target}}</td>
                                    <td>{{$result ->target_strike}}</td>
                                    <td>{{$result ->stop_loss}}</td>
                                    <td>{{$result ->scheduled_exec}}</td>
                                    <td>{{$result ->scheduled_sqoff}}</td>
                                    <td>{{$result ->recorring}}</td>
                                    <td>{{$result ->weekDays}}</td>
                                    <td>{{$result ->strategy}}</td>
                                    <td>{{$result ->qty}}</td>
                                    <td>
                                        {{-- <a href="{{ route('baskets.edit', [$result->id]) }}"  class="btn btn-sm btn-info">Add</a> --}}
                                    <div class="form-button-action">
							<form action="{{ route('basket.destroy', [$result->id]) }}" method="post"enctype="multipart/form-data" >
									 @csrf
							     <input name="_method" type="hidden" value="DELETE">
 								<button class="btn btn-danger btn-sm " data-name="{{ $result->basket_name }}" type="submit"  >Delete</i></button>
                            </form>
                            </div>
                                </tr>
                                @endforeach
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

{{-- <script>
    $(document).ready(function(){
        $('table tbody tr').click(function (){
            let id = $(this).data('id')
            var id = $('#id_product').val();
            console.log(id);
        })
    });
</script> --}}

@endsection

