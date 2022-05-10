@extends('layouts.master')
@section('title')
strategy
@endsection
@section('content')
<br><br>
<div class="container"> 
	<div class="row">
		<div class="col-md-12">
			<div class="view" style="background-image: url({{asset('assets/img/banner.jpg')}}); background-repeat: no-repeat; background-size: cover; background-position: center center;padding: 64px 0px 0px; height:450px">
				<h1 class="p-4 display-2 text-xs-center text-center">Kalyani The Strategist</h1>
				<h3 class="p-1 text-xs-center text-center">Custom build and analyze your options strategies</h3>
				<br><br>
				<div class="col-md-12 text-center">
					<a href="{{ route('holdings.index') }}"  class="btn btn-sm btn-info btn-center">GET STARTED</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
@endsection
