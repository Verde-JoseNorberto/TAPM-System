<div class="dropdown">
    <button class="btn" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fa-regular fa-bell" style="color: #ffffff;"></i>
    </button>
    <div class="dropdown-menu" aria-labelledby="notificationDropdown">
      @forelse ($notifications as $key => $notification)
          <a class="dropdown-item" href="{{ $notification->link }}">
              {{ $notification->data['message'] }}
          </a>
      @empty
          <a class="dropdown-item" href="#">
              No new notifications
          </a>
      @endforelse
    </div>
</div>