<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>
	@yield('title')
	</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<!-- <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}"> -->  
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}" />  --}}
	<link rel="stylesheet" href="../assets1/css/new.css">
	<link rel="stylesheet" href="../assets1/css/style.css">
	<link rel="stylesheet" href="{{asset('assets/css/azzara.min.css')}}">    

</head>
<body>
    <div class="container-fluid"> 
    <nav class="navbar navbar-expand-sm navbar-light ">
        <a class="navbar-brand" style="cursor: pointer; font-size:25px" href="#"><b>E.D.I.T.H</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav navbar-nav-right ml-auto">
                <li class="nav-item ">
                    <a class="font-weight-medium btn-sm" href="{{route('basket.index')}}" >
                        Positions
                    </a>            
                </li>
                {{-- <li class="nav-item active">
                    <a class=" font-weight-medium btn-sm" href="{{route('orders.index')}}" >
                    orders
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="  font-weight-medium btn-sm" href="{{ route('holdings.index') }}" >
                    Holdings
                    </a>
                </li>    --}}
                <li class="nav-item dropdown hidden-caret">
                    <a id="navbarDropdown" class="font-weight-medium btn-sm" href="#" role="button" data-toggle="dropdown" 			aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item " href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <p class="text-danger text-center"><b> {{ __('Logout') }} </b></p>
                            
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>     
          </ul>          
        </div>
      </nav>
    </div>
        <div class="content">
            @yield('content')
        </div>
    <script src="{{asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>

<!-- jQuery UI -->
<script src="{{asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>

<!-- jQuery Scrollbar -->
<script src="{{asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

<!-- Sweet Alert -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- Azzara JS -->
<script src="{{asset('assets/js/ready.min.js')}}"></script>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  {{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}

    @yield('scripts')

    <!-- End custom js for this page -->
  </body>
</html>