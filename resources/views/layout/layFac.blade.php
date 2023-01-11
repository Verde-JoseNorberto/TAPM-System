<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TAPM-Faculty') }}</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id='app'>    
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #FFD700;">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/home') }}">
                    {{ config('app.name', 'TAPM') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <ul class="navbar-nav ms-auto">

                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Project
                    </button>

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
              <form method="POST" action="{{ route('home') }}">
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Project Title') }}</label>
                      <input type="text" class="form-control" />
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Project Category') }}</label>
                      <input type="text" class="form-control" />
                    </div>
                  </div>
                </div>
                
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Progress Phase') }}</label>
                      <input type="text" class="form-control" />
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Term & Year') }}</label>
                      <input type="text" class="form-control" />
                    </div>
                  </div>
                </div>
                          <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Section') }}</label>
                      <input type="text" class="form-control" />
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Due Date') }}</label>
                      <input type="date" class="form-control" />
                    </div>
                  </div>
                </div>
                
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Team') }}</label>
                      <input type="text" class="form-control" />
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Advisor') }}</label>
                      <input type="text" class="form-control" />
                    </div>
                  </div>
                </div>
      
                <div class="form-outline mb-4">
                  <label class="form-label">{{ __('Additional information') }}</label>
                  <textarea class="form-control" rows="4"></textarea>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">{{ __('Add Project') }}</button>
            </div>
          </div>
        </div>
    </div>
    <main class="py-20">
        @yield('page-content')
    </main>
</body>
</html>