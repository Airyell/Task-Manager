import React, { useState } from 'react';

export default function Login() {
  // For form state and error simulation (you'll connect to backend for real)
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [remember, setRemember] = useState(false);
  const [errors, setErrors] = useState({}); // example errors

  const handleSubmit = (e) => {
    e.preventDefault();
    // TODO: Connect this with your backend login API
    console.log({ email, password, remember });
  };

  return (
    <div
      className="min-h-screen flex flex-col items-center pt-8"
      style={{
        backgroundImage: "url('/assets/img/Background.png')",
        backgroundRepeat: "no-repeat",
        backgroundPosition: "center",
        backgroundAttachment: "fixed",
        backgroundSize: "cover",
        fontFamily: "'Poppins', sans-serif",
      }}
    >
      <h1 className="text-[#0f2d4e] font-extrabold text-4xl mb-4 text-center">Taskaroo</h1>

      <div className="bg-[rgba(255,248,241,0.85)] rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.25)] backdrop-blur-[10px] border border-[rgba(100,90,80,0.2)] w-full max-w-md overflow-hidden">
        {/* Card Header */}
        <div className="bg-[#0f2d4e] p-8 text-center">
          <img
            src="/assets/img/logo-horizontal.png"
            alt="Taskaroo Logo"
            className="w-24 h-24 rounded-full object-cover filter brightness-[110%] animate-pulse border-4 border-[#fdf9f3] bg-white mx-auto"
          />
        </div>

        {/* Form Body */}
        <div className="p-6">
          <form onSubmit={handleSubmit} noValidate>
            <div className="mb-5">
              <label htmlFor="email" className="block mb-1 font-semibold text-[#0f2d4e]">
                Email Address
              </label>
              <input
                type="email"
                name="email"
                id="email"
                placeholder="admin@example.com"
                required
                autoFocus
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                className="w-full rounded-xl border border-gray-300 bg-[#fdf9f3] px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#0f2d4e]"
              />
              {errors.email && <p className="text-red-600 text-sm mt-1">{errors.email}</p>}
            </div>

            <div className="mb-5">
              <label htmlFor="password" className="block mb-1 font-semibold text-[#0f2d4e]">
                Password
              </label>
              <input
                type="password"
                name="password"
                id="password"
                required
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                className="w-full rounded-xl border border-gray-300 bg-[#fdf9f3] px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#0f2d4e]"
              />
              {errors.password && <p className="text-red-600 text-sm mt-1">{errors.password}</p>}
            </div>

            <div className="mb-5 flex items-center">
              <input
                type="checkbox"
                id="remember"
                name="remember"
                checked={remember}
                onChange={(e) => setRemember(e.target.checked)}
                className="mr-2 w-4 h-4 text-[#0f2d4e] border-gray-300 rounded focus:ring-[#0f2d4e]"
              />
              <label htmlFor="remember" className="text-[#0f2d4e] font-medium select-none">
                Remember Me
              </label>
            </div>

            <button
              type="submit"
              className="w-full bg-[#0f2d4e] hover:bg-[#0c233c] text-white font-semibold rounded-xl py-2 transition-colors duration-300"
            >
              Login
            </button>
          </form>

          <div className="mt-4 text-center text-[#f28b2c] font-medium">
            <p>
              Don't have an account?{' '}
              <a href="/register" className="underline hover:text-[#0f2d4e]">
                Register here
              </a>
            </p>
          </div>
        </div>

        {/* Card Footer */}
        <div className="bg-[#fefaf5] text-[#7a6e58] text-sm text-center py-4">
          &copy; 2025 Nikol and Friends. All rights reserved.
        </div>
      </div>
    </div>
  );
}
