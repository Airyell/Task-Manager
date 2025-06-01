<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') | Admin Panel</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="shortcut icon" href="{{ asset('assets/img/กระดาษโน๊ต-removebg-preview.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
            /* The overall background color */
            background-color: #fdf1e5; /* Matches the light background in the image */
        }

        /* Styles for the circular progress charts (if you're using them) */
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

        /* Custom styles for admin layout components */
        .admin-sidebar {
            min-width: 250px; /* Fixed width for the sidebar */
            max-width: 250px;
            height: 100vh; /* Full viewport height */
            position: fixed; /* Fixed position for the sidebar */
            top: 0;
            left: 0;
            overflow-y: auto; /* Allows scrolling if sidebar content is long */
            background-color: #0b2c48; /* Dark blue background */
            color: white;
            transition: transform 0.3s ease-in-out; /* For toggle animation */
            z-index: 1045;
        }
        @media (min-width: 1024px) { /* lg breakpoint for Tailwind */
            .admin-sidebar {
                transform: translateX(0); /* Always visible on large screens */
            }
        }
        .admin-main-wrapper {
            margin-left: 0; /* Default no margin for small screens */
            transition: margin-left 0.3s ease-in-out; /* For toggle animation */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        @media (min-width: 1024px) {
            .admin-main-wrapper {
                margin-left: 250px; /* Margin to make space for fixed sidebar */
            }
        }
        .admin-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8); /* Slightly less bright for non-active */
        }
        .admin-sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1); /* Light background for active */
            color: white;
        }
        .admin-sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.05); /* Subtle hover */
            color: white;
        }
        /* Custom padding for content in the main wrapper */
        .content-padding {
            padding: 1.5rem; /* Equivalent to px-6 py-6, but consistent */
        }
    </style>
</head>

<body class="bg-[#fdf1e5] min-h-screen flex"> {{-- Changed to flex to enable sidebar/content layout --}}

    <nav id="sidebar" class="admin-sidebar">
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
                <a class="flex items-center px-4 py-2 rounded hover:bg-white/10 transition {{ request()->routeIs('admin.tasks.index*') ? 'bg-white/10' : '' }}" href="{{ route('admin.tasks.index') }}">
                    <i class="bi bi-list-task mr-2"></i> Manage Tasks {{-- Changed icon to list-task --}}
                </a>
            </li>
            <li>
                <a class="flex items-center px-4 py-2 rounded hover:bg-white/10 transition {{ request()->routeIs('admin.projects*') ? 'bg-white/10' : '' }}" href="{{ route('admin.projects.index') }}">
                    <i class="bi bi-folder-fill mr-2"></i> Manage Projects {{-- Changed icon to folder-fill --}}
                </a>
            </li>
        </ul>
    </nav>

    {{-- Main content wrapper, adjusting for sidebar --}}
    <div class="admin-main-wrapper">

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
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
                @endauth
            </nav>
        </header>

        <main class="flex-grow content-padding overflow-y-auto">
            {{-- This div is the white container seen in the image --}}
            <div class="bg-white p-6 rounded-lg shadow-md min-h-[calc(100vh-160px)]"> {{-- Adjusted min-h for header/footer --}}
                @yield('content')
            </div>
        </main>

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

        // Sidebar toggle for small screens
        sidebarToggleBtn?.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
        });
        sidebarCloseBtn?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });

        // Close sidebar when clicking outside on small screens
        document.addEventListener('click', (e) => {
            // Check if window is below lg breakpoint (Tailwind's 1024px)
            if (window.innerWidth < 1024) {
                // Check if click is outside sidebar and outside toggle button
                if (!sidebar.contains(e.target) && !sidebarToggleBtn.contains(e.target)) {
                    sidebar.classList.add('-translate-x-full');
                }
            }
        });

        // User dropdown toggle
        userDropdownBtn?.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent click from bubbling to document and closing dropdown
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!userDropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

        // Function to update date and time in the header
        function updateDateTime() {
            const now = new Date();
            const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            const day = dayNames[now.getDay()];
            const date = now.toLocaleDateString(['en-US'], { day: 'numeric', month: 'long', year: 'numeric' });
            const time = now.toLocaleTimeString();
            document.getElementById('currentDateTime').innerText = `${day}, ${date}  ${time}`;
        }
        updateDateTime(); // Call initially
        setInterval(updateDateTime, 1000); // Update every second
    </script>

    @stack('scripts') {{-- Allows child views to push their own scripts --}}
</body>

</html>