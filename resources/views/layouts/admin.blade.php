<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title') | Admin Panel</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="shortcut icon" href="{{ asset('assets/img/กระดาษโน๊ต-removebg-preview.png') }}" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
    body {
      font-family: 'Noto Sans', sans-serif;
    }

    .circular-chart {
      display: block;
      margin: auto;
      max-width: 60px;
      max-height: 60px;
    }

    .circle-bg {
      fill: none;
      stroke: #eee;
      stroke-width: 3.8;
    }

    .circle {
      fill: none;
      stroke-width: 2.8;
      stroke-linecap: round;
      animation: progress 1s ease-out forwards;
    }

    @keyframes progress {
      0% {
        stroke-dasharray: 0 100;
      }
    }
  </style>
</head>

<body class="bg-[#fdf1e5] min-h-screen flex flex-col">

  <!-- Sidebar -->
  <nav id="sidebar" class="fixed top-0 left-0 h-screen w-[250px] bg-[#0b2c48] text-white overflow-y-auto p-4 z-[1045] transition-transform transform lg:translate-x-0 -translate-x-full lg:block">
    <div class="flex justify-between items-center mb-6 px-2">
      <a href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('assets/img/taskaroo-removebg.png') }}" class="w-full" alt="Admin Panel" />
      </a>
      <button id="sidebarCloseBtn" class="text-white text-xl lg:hidden">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>
    <ul class="space-y-2 px-2">
      <li>
        <a class="flex items-center px-4 py-2 rounded hover:bg-white/10 transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/10' : '' }}" href="{{ route('admin.dashboard') }}">
          <i class="bi bi-speedometer2 mr-2"></i> Dashboard
        </a>
      </li>
      <li>
        <a class="flex items-center px-4 py-2 rounded hover:bg-white/10 transition {{ request()->routeIs('admin.users*') ? 'bg-white/10' : '' }}" href="{{ route('admin.users.index') }}">
          <i class="bi bi-people-fill mr-2"></i> Manage Users
        </a>
      </li>
      <li>
        <a class="flex items-center px-4 py-2 rounded hover:bg-white/10 transition {{ request()->routeIs('admin.settings*') ? 'bg-white/10' : '' }}" href="{{ route('admin.settings') }}">
          <i class="bi bi-gear-fill mr-2"></i> Settings
        </a>
      </li>
    </ul>
  </nav>

  <div class="flex flex-col flex-1 lg:ml-[250px] min-h-screen">

    <!-- Header -->
    <header class="bg-[#0b2c48] text-white shadow sticky top-0 z-[1030]">
      <nav class="flex items-center justify-between px-4 py-3">
        <div class="flex items-center space-x-2">
          <button id="sidebarToggleBtn" class="text-white text-xl lg:hidden">
            <i class="bi bi-list"></i>
          </button>
          <a href="{{ route('admin.dashboard') }}" class="text-white text-sm font-light" id="currentDateTime"></a>
        </div>
        @auth
        <div class="relative">
          <button class="flex items-center gap-2 text-white text-sm focus:outline-none" id="userDropdownBtn">
            {{ Auth::user()->name }}
            <i class="bi bi-caret-down-fill"></i>
          </button>
          <div id="dropdownMenu" class="absolute right-0 mt-2 w-40 bg-white text-black rounded shadow-lg hidden z-50">
            <a href="{{ route('profile.index') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
            <a href="{{ route('history.index') }}" class="block px-4 py-2 hover:bg-gray-100">History</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
            </form>
          </div>
        </div>
        @endauth
      </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow px-4 py-6 overflow-y-auto">
      @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#0b2c48] text-white text-center text-sm shadow-md py-3">
      &copy; {{ date('Y') }} Nikol and Friends. All rights reserved.
    </footer>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
    const userDropdownBtn = document.getElementById('userDropdownBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');

    sidebarToggleBtn?.addEventListener('click', () => sidebar.classList.remove('-translate-x-full'));
    sidebarCloseBtn?.addEventListener('click', () => sidebar.classList.add('-translate-x-full'));

    document.addEventListener('click', (e) => {
      if (window.innerWidth <= 991.98) {
        if (!sidebar.contains(e.target) && !sidebarToggleBtn.contains(e.target)) {
          sidebar.classList.add('-translate-x-full');
        }
      }

      if (!userDropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
        dropdownMenu.classList.add('hidden');
      }
    });

    userDropdownBtn?.addEventListener('click', () => {
      dropdownMenu.classList.toggle('hidden');
    });

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
