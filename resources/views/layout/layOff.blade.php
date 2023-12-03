<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('TAPM-Office') }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

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
                <a class="navbar-brand fw-bold text-white" href="{{ url('office/home') }}">
                    {{ config('app.name', 'TAPM') }}
                </a>

                <div class="dropdown">
                  <button class="btn" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa-regular fa-bell" style="color: #ffffff;"></i>
                      <span class="badge badge-light">{{ auth()->user()->notifications->count() }}</span>
                  </button>
                  <div class="dropdown-menu notification-dropdown" aria-labelledby="notificationDropdown" style="max-height: 300px; overflow-y: auto;">
                      <h5 class="dropdown-header">{{ __('Notifications' )}}</h5>
                      @forelse (auth()->user()->notifications->take(10) as $notification)
                          <a class="dropdown-item" href="{{ $notification->data['link'] }}" style="width: 500px;">
                              <div class="d-flex justify-content-between align-items-center">
                                  <div style="max-width: 70%;">
                                      <h6 class="mb-1 text-truncate">{{ $notification->data['name'] }}</h6>
                                      <p class="mb-1 text-truncate">{{ $notification->data['data'] }}</p>
                                  </div>
                                  <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                              </div>
                          </a>
                      @empty
                          <a class="dropdown-item">
                              {{ __('No new notifications') }}
                          </a>
                      @endforelse
                      @if(auth()->user()->notifications->count() > 10)
                          <a class="dropdown-item text-center" href="#">{{ __('See All Notifications') }}</a>
                      @endif
                  </div>
              </div>
              
                <ul class="navbar-nav ms-auto">
                  <div>
                    <button type="button" class="btn btn-outline-dark text-white" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      {{__('Add Group')}}
                    </button>
                  </div>
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
                            {{ __('Web Administer') }}
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
                              <h4>{{ __('Continue to Administration View?')}}</h4>
                            </div>
                            <div class="modal-footer">
                              <a href="{{ URL::to('admin/user')}}" type="button" class="btn btn-warning">{{ __('Proceed') }}</a>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{__('Add Group')}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('office/home') }}">
                @csrf 
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Group Name') }}</label>
                      <input id="team" type="text" class="form-control" name="team">
                    </div>
                  </div>
                </div>
                
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Section') }}</label>
                      <input id="section" type="text" class="form-control" name="section">
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Advisor') }}</label>
                      <input id="advisor" type="text" class="form-control" name="advisor">
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <label class="form-label">{{ __('Project Title') }}</label>
                      <input id="title" type="text" class="form-control" name="title">
                    </div>
                  </div>
                </div>
              
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">{{ __('Create Group') }}</button>
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