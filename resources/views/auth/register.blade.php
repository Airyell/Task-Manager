<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register | Taskaroo</title>

  <link rel="shortcut icon" href="{{ asset('assets/img/กระดาษโน๊ต-removebg-preview.png') }}" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <style>
    body {
      background: url('{{ asset('assets/img/Background.png') }}') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Poppins', sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      padding-top: 2rem;
    }

    h1.page-title {
      color: #0f2d4e;
      font-weight: 700;
      margin-bottom: 1rem;
      text-align: center;
      font-size: 2.5rem;
    }

    .glass-card {
      background: rgba(255, 248, 241, 0.85);
      border-radius: 1rem;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(100, 90, 80, 0.2);
      width: 100%;
      max-width: 420px;
      overflow: hidden;
    }

    .card-header {
      background-color: #0f2d4e;
      padding: 2rem;
      text-align: center;
    }

    .card-header img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      filter: brightness(110%);
      animation: pulse 2s infinite;
      border: 3px solid #fdf9f3;
      background-color: white;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 1; }
      50% { transform: scale(1.05); opacity: 0.9; }
    }

    .form-label {
      font-weight: 600;
      color: #0f2d4e;
    }

    .form-control {
      border-radius: 0.75rem;
      padding: 0.6rem 1rem;
      border: 1px solid #ccc;
      background-color: #fdf9f3;
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(15, 45, 78, 0.25);
    }

    .btn-primary {
      background-color: #0f2d4e;
      border: none;
      font-weight: 600;
      border-radius: 0.75rem;
      transition: background-color 0.3s ease-in-out;
    }

    .btn-primary:hover {
      background-color: #0c233c;
    }

    .register-link {
      text-align: center;
      margin-top: 1rem;
    }

    .register-link a {
      text-decoration: none;
      font-weight: 500;
      color: #f28b2c;
    }

    .card-footer {
      background-color: #fefaf5;
      font-size: 0.85rem;
      text-align: center;
      padding: 1rem;
      color: #7a6e58;
    }
  </style>
</head>
<body>

  <h1 class="page-title">Taskaroo</h1>

  <div class="glass-card">
    <div class="card-header">
      <img src="{{ asset('assets/img/logo-horizontal.png') }}" alt="Taskaroo Logo" />
    </div>
    <div class="card-body p-4">
      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
          @error('name')
            <span class="text-danger small">{{ $message }}</span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required>
          @error('username')
            <span class="text-danger small">{{ $message }}</span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
          @error('email')
            <span class="text-danger small">{{ $message }}</span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input id="password" type="password" class="form-control" name="password" required>
          @error('password')
            <span class="text-danger small">{{ $message }}</span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirm Password</label>
          <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Register</button>
        </div>

        <div class="register-link">
          <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
        </div>
      </form>
    </div>

    <div class="card-footer">
      &copy; 2025 Nikol and Friends. All rights reserved.
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
