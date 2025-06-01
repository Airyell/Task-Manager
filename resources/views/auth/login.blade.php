<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | Taskaroo</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="shortcut icon" href="{{ asset('assets/img/กระดาษโน๊ต-removebg-preview.png') }}" type="image/x-icon" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      background: url('{{ asset('assets/img/Background.png') }}') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Poppins', sans-serif;
    }

    .glass-card {
      background: rgba(255, 248, 241, 0.85);
      border-radius: 1rem;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(100, 90, 80, 0.2);
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 1; }
      50% { transform: scale(1.05); opacity: 0.9; }
    }

    .animate-pulse-img {
      animation: pulse 2s infinite;
    }
  </style>
</head>
<body class="flex flex-col items-center min-h-screen pt-8">

  <h1 class="text-4xl font-bold text-[#0f2d4e] mb-4 text-center">Taskaroo</h1>

  <div class="glass-card w-full max-w-md overflow-hidden">
    <!-- Card Header -->
    <div class="bg-[#0f2d4e] p-8 text-center">
      <img src="{{ asset('assets/img/logo-horizontal.png') }}" alt="Taskaroo Logo"
           class="w-24 h-24 mx-auto rounded-full object-cover brightness-110 animate-pulse-img border-4 border-white bg-white">
    </div>

    <!-- Card Body -->
    <div class="p-6">
      <form method="POST" action="{{ route('login') }}" aria-label="Login form">
        @csrf

        <!-- Email Field -->
        <div class="mb-4">
          <label for="email" class="block font-semibold text-[#0f2d4e] mb-1">Email Address</label>
          <input type="email" name="email" id="email" autocomplete="email"
                 class="w-full rounded-xl px-4 py-2 border border-gray-300 bg-[#fdf9f3] focus:outline-none focus:ring-2 focus:ring-[#0f2d4e]/30"
                 placeholder="admin@example.com" required autofocus />
          @error('email')
            <span class="text-red-600 text-sm">{{ $message }}</span>
          @enderror
        </div>

        <!-- Password Field -->
        <div class="mb-4">
          <label for="password" class="block font-semibold text-[#0f2d4e] mb-1">Password</label>
          <input type="password" name="password" id="password" autocomplete="current-password"
                 class="w-full rounded-xl px-4 py-2 border border-gray-300 bg-[#fdf9f3] focus:outline-none focus:ring-2 focus:ring-[#0f2d4e]/30"
                 required />
          @error('password')
            <span class="text-red-600 text-sm">{{ $message }}</span>
          @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-4 flex items-center">
          <input type="checkbox" name="remember" id="remember" class="mr-2" />
          <label for="remember" class="text-sm text-gray-700">Remember Me</label>
        </div>

        <!-- Login Button -->
        <div class="mb-4">
          <button type="submit"
                  class="w-full bg-[#0f2d4e] hover:bg-[#0c233c] text-white font-semibold py-2 rounded-xl transition duration-300">
            Login
          </button>
        </div>

        <!-- Register Link -->
        <div class="text-center mt-4">
          <p class="text-sm">Don't have an account?
            <a href="{{ route('register') }}" class="text-[#f28b2c] font-medium hover:underline">
              Register here
            </a>
          </p>
        </div>
      </form>
    </div>

    <!-- Footer -->
    <div class="bg-[#fefaf5] text-sm text-center text-[#7a6e58] py-4">
      &copy; 2025 Nikol and Friends. All rights reserved.
    </div>
  </div>
</body>
</html>
