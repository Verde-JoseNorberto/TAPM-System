<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TAPM-Admin') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div class="fixed-alert-container">
    @if ($message = Session::get('success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show position-fixed" role="alert">
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if($errors->any())
    <div id="error-alert" class="alert alert-danger alert-dismissible fade show position-fixed" role="alert">
        @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>
<div class="bg-image" style="background-image: url('/storage/test.png'); height: 100vh">
    <div id='app'>    
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #043877;">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold text-white" href="{{ url('admin') }}">
                    {{ config('app.name', 'TAPM') }}
                </a>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          {{ Auth::user()->name }}
                      </a>

                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                          </a>
                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                              @csrf
                          </form>
                          <a class="dropdown-item" data-bs-toggle="modal" href="#admin">
                            {{ __('Go Back') }}
                          </a>
                      </div>
                      <div class="modal fade" id="admin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">{{__('Switch View')}}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <h4>{{ __('Go Back to Tracking View?')}}</h4>
                            </div>
                            <div class="modal-footer">
                              <a href="{{ URL::to('office/home')}}" type="button" class="btn btn-warning">{{ __('Proceed') }}</a>
                            </div>
                              </form>
                          </div>
                        </div>
                      </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <main class="py-20">
        @yield('page-content')
    </main>
</div>
</body>
</html>

<script>
  // Automatically close success alert after 5 seconds (5000 milliseconds)
  const successAlert = document.getElementById('success-alert');
  if (successAlert) {
      setTimeout(function() {
          successAlert.style.display = 'none';
      }, 5000); // Adjust the duration as needed
  }

  // Automatically close error alert after 5 seconds (5000 milliseconds)
  const errorAlert = document.getElementById('error-alert');
  if (errorAlert) {
      setTimeout(function() {
          errorAlert.style.display = 'none';
      }, 5000); // Adjust the duration as needed
  }
</script>