import React, { useEffect, useState } from 'react';
import { NavLink, Outlet } from 'react-router-dom';
import Dashboard from '../dashboard';

const Layout = ({ user }) => {
  const [currentDateTime, setCurrentDateTime] = useState('');

  useEffect(() => {
    const updateDateTime = () => {
      const now = new Date();
      const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
      const day = dayNames[now.getDay()];
      const date = now.toLocaleDateString(['en-US'], { day: 'numeric', month: 'long', year: 'numeric' });
      const time = now.toLocaleTimeString();
      setCurrentDateTime(`${day}, ${date} ${time}`);
    };

    updateDateTime();
    const interval = setInterval(updateDateTime, 1000);
    return () => clearInterval(interval);
  }, []);

  return (
    <div className="flex h-screen overflow-hidden bg-slate-100 font-sans">
      {/* Sidebar */}
      <aside className="w-64 bg-gray-800 text-white flex flex-col">
        <div className="text-center p-4">
          <NavLink to="/dashboard">
            <img src="/assets/img/taskaroo-removebg.png" alt="task manager" className="w-full" />
          </NavLink>
        </div>
        <nav className="flex-grow px-2 space-y-1">
          <NavLink to="/dashboard" className={({ isActive }) => `flex items-center px-3 py-2 rounded ${isActive ? 'bg-gray-700' : ''}`}>
            <i className="bi bi-house-door mr-2"></i> Home
          </NavLink>
          <NavLink to="/projects" className={({ isActive }) => `flex items-center px-3 py-2 rounded ${isActive ? 'bg-gray-700' : ''}`}>
            <i className="bi bi-folder mr-2"></i> Projects
          </NavLink>
          <NavLink to="/notes" className={({ isActive }) => `flex items-center px-3 py-2 rounded ${isActive ? 'bg-gray-700' : ''}`}>
            <i className="bi bi-sticky mr-2"></i> Notes
          </NavLink>
          <NavLink to="/history" className={({ isActive }) => `flex items-center px-3 py-2 rounded ${isActive ? 'bg-gray-700' : ''}`}>
            <i className="bi bi-clock-history mr-2"></i> History
          </NavLink>
        </nav>
      </aside>

      {/* Main Content */}
      <div className="flex flex-col flex-grow overflow-y-auto">
        {/* Top Navbar */}
        <header className="bg-white shadow p-4">
          <div className="flex justify-between items-center">
            <div className="font-bold text-gray-800">{currentDateTime}</div>
            <div>
              {user && (
                <div className="relative group inline-block">
                  <button className="text-gray-800 font-medium">{user.name}</button>
                  <div className="absolute hidden group-hover:block right-0 bg-white shadow rounded mt-2">
                    <NavLink to="/profile" className="block px-4 py-2 hover:bg-gray-100">Profile</NavLink>
                    <NavLink to="/history" className="block px-4 py-2 hover:bg-gray-100">History</NavLink>
                    <form method="POST" action="/logout">
                      <button type="submit" className="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                    </form>
                  </div>
                </div>
              )}
            </div>
          </div>
        </header>

        <section>
          <div>
            <Dashboard />
          </div>
        </section>

        {/* Page Content */}
        <main className="flex-grow p-6">
          <Outlet />
        </main>

        {/* Footer */}
        <footer className="bg-white shadow py-3 text-center text-sm text-gray-500">
          &copy; Copyright All Rights Reserved 2025 by: Nikol and friends
        </footer>
      </div>
    </div>
  );
};

export default Layout;
