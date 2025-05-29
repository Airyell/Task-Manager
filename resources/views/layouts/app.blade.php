<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title') | Task Manager</title>

  <link rel="shortcut icon" href="{{ asset('assets/img/กระดาษโน๊ต-removebg-preview.png') }}" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
    body {
      margin: 0;
      font-family: "Noto Sans", sans-serif !important;
      background: #fdf1e5;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Sidebar styles */
    .sidebar {
      background-color: #0b2c48;
      color: #fff;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      overflow-y: auto;
      padding-top: 1rem;
      z-index: 1045; /* above content */
      transition: transform 0.3s ease-in-out;
    }

    /* Hide sidebar on small screens by default */
    @media (max-width: 991.98px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.show {
        transform: translateX(0);
      }
    }

    .sidebar .nav-link {
      color: #fff;
      display: flex;
      align-items: center;
      padding: 12px 16px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      transition: background 0.2s ease;
      text-decoration: none;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: rgba(255, 255, 255, 0.1);
    }

    .sidebar .nav-link .bi {
      margin-right: 10px;
    }

    /* Content area */
    .content-wrapper {
      margin-left: 250px;
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* On smaller screens, no left margin */
    @media (max-width: 991.98px) {
      .content-wrapper {
        margin-left: 0;
      }
    }

    .topnav {
      background-color: #0b2c48;
      color: white;
      box-shadow: 0 .25rem .5rem rgba(0, 0, 0, .1);
      flex-shrink: 0;
      position: sticky;
      top: 0;
      z-index: 1030;
    }

    .navbar-brand,
    .navbar-nav .nav-link {
      color: white !important;
    }

    .navbar-nav .nav-link:hover {
      color: #ff914d !important;
    }

    .btn {
      padding: 0.4rem 1rem !important;
      font-size: 0.875rem !important;
      border-radius: 999px !important;
    }

    main {
      padding: 1rem 1.5rem;
      flex-grow: 1;
      background-color: transparent;
      overflow-y: auto;
    }

    .card {
      border: none;
      background-color: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(4px);
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
      border-radius: 1.25rem;
    }

    footer {
      background-color: #0b2c48;
      color: white;
      text-align: center;
      font-size: 0.875rem;
      box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.05);
      padding: 0.75rem 1rem;
      flex-shrink: 0;
    }

    a {
      color: #ff914d;
      text-decoration: none;
    }

    a:hover {
      color: #e5742f;
    }
  </style>
</head>

<body>
  @if (!Request::is('register'))
    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar">
      <div class="d-flex justify-content-between align-items-center px-3 mb-4">
        <a href="{{ route('dashboard') }}">
          <img src="{{ asset('assets/img/taskaroo-removebg.png') }}" class="img-fluid" width="100%" alt="task manager" />
        </a>
        <!-- Close button for small screens -->
        <button class="btn btn-sm btn-outline-light d-lg-none" id="sidebarCloseBtn" aria-label="Close sidebar">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
      <ul class="nav flex-column px-2">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-house-door"></i> Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('projects*') ? 'active' : '' }}" href="{{ route('projects.index') }}">
            <i class="bi bi-folder"></i> Projects
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('notes*') ? 'active' : '' }}" href="{{ route('notes.index') }}">
            <i class="bi bi-sticky"></i> Notes
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('history*') ? 'active' : '' }}" href="{{ route('history.index') }}">
            <i class="bi bi-clock-history"></i> History
          </a>
        </li>
      </ul>
    </nav>
  @endif

  <div class="content-wrapper d-flex flex-column">
    @if (!Request::is('register'))
      <header class="topnav mb-3">
        <nav class="navbar navbar-expand-lg navbar-dark container-fluid px-3">
          @if (!Request::is('register'))
            <button class="btn btn-outline-light d-lg-none me-2" id="sidebarToggleBtn" aria-label="Toggle sidebar">
              <i class="bi bi-list"></i>
            </button>
          @endif
          <a class="navbar-brand flex-grow-1" href="{{ route('dashboard') }}">
            <span class="fw-normal" id="currentDateTime"></span>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
              @auth
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name }}
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('history.index') }}">History</a></li>
                    <li>
                      <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                      </form>
                    </li>
                  </ul>
                </li>
              @endauth
            </ul>
          </div>
        </nav>
      </header>
    @endif

    <main>
      @yield('content')
    </main>

    @if (!Request::is('register'))
      <footer>
        <div class="container">
          <span>&copy; 2025 Nikol and Friends. All rights reserved.</span>
        </div>
      </footer>
    @endif
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Sidebar toggle logic for small screens
    const sidebar = document.getElementById('sidebar');
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

    sidebarToggleBtn?.addEventListener('click', () => {
      sidebar.classList.add('show');
    });

    sidebarCloseBtn?.addEventListener('click', () => {
      sidebar.classList.remove('show');
    });

    // Also close sidebar if clicking outside (optional)
    document.addEventListener('click', function (e) {
      if (window.innerWidth <= 991.98) {
        if (!sidebar.contains(e.target) && !sidebarToggleBtn.contains(e.target)) {
          sidebar.classList.remove('show');
        }
      }
    });

    // Date & time update
    function updateDateTime() {
      const now = new Date();
      const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
      const day = dayNames[now.getDay()];
      const date = now.toLocaleDateString(['en-US'], { day: 'numeric', month: 'long', year: 'numeric' });
      const time = now.toLocaleTimeString();
      document.getElementById('currentDateTime').innerText = `${day}, ${date}  ${time}`;
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);
  </script>
</body>

</html>
