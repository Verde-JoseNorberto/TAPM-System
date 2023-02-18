<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TAPM-Faculty') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div class="bg-image" style="background-image: url('/storage/test-bg.png'); height: 100vh">
    <div id='app'>    
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #FFD700;">
            <div class="container-fluid">
              {{-- <div>
              <button class="fa fa-bell">

              </button>
              </div> --}}
                <a class="navbar-brand fw-bold" href="{{ url('faculty/home') }}">
                    {{ config('app.name', 'TAPM') }}
                </a>

                <ul class="navbar-nav ms-auto">
                  <div>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      {{__('Add Project')}}
                    </button>
                  </div>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{__('Add Project')}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('faculty/home') }}">
                @csrf 
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Project Title') }}</label>
                      <input id="title" type="text" class="form-control" name="title">
                    </div>
                  </div>
                </div>
                
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Subject') }}</label>
                      <input id="subject" type="text" class="form-control" name="subject">
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Section') }}</label>
                      <input id="section" type="text" class="form-control" name="section">
                    </div>
                  </div>
                </div>
                
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Team') }}</label>
                      <input id="team" type="text" class="form-control" name="team">
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Advisor') }}</label>
                      <input id="advisor" type="text" class="form-control" name="advisor">
                    </div>
                  </div>
                </div>
                
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">{{ __('Create Project') }}</button>
                </div>
              </form>
          </div>
        </div>
    </div>
    <main class="py-20">
        @yield('page-content')
    </main>
  </div>
</body>
</html>