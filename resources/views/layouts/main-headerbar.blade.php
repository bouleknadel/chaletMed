<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Logout-->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
       document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>

        @php
            use App\Models\NotificationMsj;
            $unreadNotifications = NotificationMsj::where('read', false)->get();
        @endphp

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                @if (count($unreadNotifications) > 0)
                    <span class="badge badge-warning navbar-badge">{{ count($unreadNotifications) }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{ count($unreadNotifications) }} Notifications</span>
                <div class="dropdown-divider"></div>
                @foreach ($unreadNotifications as $notification)
                    <a href="#" class="dropdown-item"
                        style="display: flex;
          align-items: flex-start;
          justify-content: space-between;">
                        <div class="notification-content">
                            <span class="notification-text"
                                style=" font-size: 12px;
                  white-space: normal;">{{ $notification->content }}</span>
                        </div>
                        <div class="notification-meta" style="width: 30%; font-size: 12px;">
                            <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                            <br>
                            <form action="{{ route('mark-as-read', $notification->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                <button class="btn btn-sm btn-primary mark-as-read" style="font-size: 10px;"
                                    data-notification-id="{{ $notification->id }}">
                                    <i class="fas fa-check"></i> <!-- Icône FontAwesome -->
                                </button>
                            </form>

                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                @endforeach
            </div>
        </li>


        <!-- Messages Dropdown Menu -->


        <!-- Notifications Dropdown Menu -->

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

    </ul>
</nav>
<!-- /.navbar -->
