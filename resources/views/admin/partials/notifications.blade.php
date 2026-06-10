<button
  type="button"
  class="notif {{ $adminNotificationCount > 0 ? 'has-notifications' : '' }}"
  data-menu-toggle="notifMenu"
  aria-label="Notifikasi">
  <i class="bi bi-bell"></i>
</button>

<div class="dropdown-panel notif-panel" id="notifMenu">
  <div class="dropdown-title">
    Notifikasi
    @if($adminNotificationCount > 0)
      <span class="notif-count">{{ $adminNotificationCount }}</span>
    @endif
  </div>

  @if($adminNotificationCount > 0)
    <form method="POST" action="{{ route('admin.notifications.read-all') }}" class="notif-read-all-form">
      @csrf
      @foreach($adminNotifications as $notification)
        <input type="hidden" name="notifications[]" value="{{ $notification['key'] }}">
      @endforeach
      <button type="submit" class="notif-read-all">
        <i class="bi bi-check2-all"></i>
        Mark all as read
      </button>
    </form>

    @foreach($adminNotifications as $notification)
      <a href="{{ $notification['url'] }}" class="notif-item">
        <div class="notif-item-icon"><i class="bi {{ $notification['icon'] }}"></i></div>
        <div>
          <div class="notif-item-title">{{ $notification['title'] }}</div>
          <div class="notif-item-body">{{ $notification['body'] }}</div>
        </div>
      </a>
    @endforeach
  @else
    <div class="dropdown-empty">Belum ada notifikasi baru.</div>
  @endif
</div>
