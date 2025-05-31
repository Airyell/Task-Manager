import React, { useState, useEffect } from 'react';
import { Home, Folder, FileText, CheckCircle, User, Mail, Key, Eye, EyeOff, Menu, X } from 'lucide-react';

// Dummy user data for demonstration
const dummyUser = {
  name: 'John Doe',
  username: 'johndoe',
  email: 'john.doe@example.com',
};

// Modal Component for notifications
const Modal = ({ message, type, isOpen, onClose }) => {
  if (!isOpen) return null;

  // Determine background and text color based on message type
  const bgColor = type === 'success' ? 'bg-green-100' : 'bg-red-100';
  const borderColor = type === 'success' ? 'border-green-400' : 'border-red-400';
  const textColor = type === 'success' ? 'text-green-700' : 'text-red-700';
  const title = type === 'success' ? 'Success!' : 'Error!';

  return (
    <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div className={`relative ${bgColor} ${borderColor} border p-6 rounded-2xl shadow-xl max-w-sm w-full font-inter`}>
        <h3 className={`text-xl font-bold mb-4 ${textColor}`}>{title}</h3>
        <p className={`${textColor} mb-6`}>{message}</p>
        <div className="flex justify-end">
          <button
            onClick={onClose}
            className="px-5 py-2 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300 transition-colors duration-200"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  );
};

// Sidebar Component
const Sidebar = ({ isOpen, toggleSidebar }) => {
  return (
    <>
      {/* Overlay for mobile when sidebar is open, closes sidebar on click */}
      {isOpen && (
        <div
          className="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"
          onClick={toggleSidebar}
        ></div>
      )}

      {/* Sidebar content container */}
      <div
        className={`fixed top-0 left-0 h-screen w-64 bg-blue-950 shadow-lg rounded-r-2xl p-6 z-40 transition-transform duration-300 ease-in-out
          ${isOpen ? 'translate-x-0' : '-translate-x-full'}
          md:translate-x-0 md:flex md:flex-col`}
      >
        {/* Close button for mobile sidebar */}
        <button
          onClick={toggleSidebar}
          className="absolute top-4 right-4 text-white hover:text-gray-200 md:hidden"
          aria-label="Close sidebar"
        >
          <X className="w-6 h-6" />
        </button>

        {/* Logo Section */}
        <div className="flex items-center justify-center mb-10 mt-4">
          <img src="https://placehold.co/60x60/F0F8FF/000000?text=Logo" alt="Taskaroo Logo" className="h-16 w-16 mr-3 rounded-full" />
          <span className="text-2xl font-bold text-white font-inter">Taskaroo</span>
        </div>

        {/* Navigation Links */}
        <nav className="space-y-4 flex-grow">
          <SidebarLink icon={<Home className="w-5 h-5" />} text="Home" isActive={false} />
          <SidebarLink icon={<Folder className="w-5 h-5" />} text="Projects" isActive={false} />
          <SidebarLink icon={<FileText className="w-5 h-5" />} text="Notes" isActive={false} />
          <SidebarLink icon={<CheckCircle className="w-5 h-5" />} text="History" isActive={false} />
          {/* Highlight Profile as active */}
          <SidebarLink icon={<User className="w-5 h-5" />} text="Profile" isActive={true} />
        </nav>
      </div>
    </>
  );
};

// Sidebar Link Component
const SidebarLink = ({ icon, text, isActive }) => {
  // Apply active classes if the link is currently active
  const activeClasses = isActive ? 'bg-blue-800 text-white font-semibold' : 'text-blue-200 hover:bg-blue-800 hover:text-white';
  return (
    <a href="#" className={`flex items-center p-3 rounded-xl transition-colors duration-200 ${activeClasses}`}>
      {icon}
      <span className="ml-4 text-lg font-inter">{text}</span>
    </a>
  );
};

// Header Component
const Header = ({ userName, toggleSidebar }) => {
  const [currentDateTime, setCurrentDateTime] = useState('');

  // Effect to update date and time every second
  useEffect(() => {
    const updateDateTime = () => {
      const now = new Date();
      setCurrentDateTime(now.toLocaleString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true,
      }));
    };

    updateDateTime(); // Set initial value immediately
    const intervalId = setInterval(updateDateTime, 1000); // Update every second

    // Cleanup function to clear the interval when the component unmounts
    return () => clearInterval(intervalId);
  }, []); // Empty dependency array means this effect runs once on mount and cleans up on unmount

  return (
    <header className="fixed top-0 left-0 right-0 bg-white shadow-md rounded-bl-2xl rounded-br-2xl p-4 flex items-center justify-between z-20 md:left-64">
      {/* Hamburger menu for mobile, toggles sidebar */}
      <button
        onClick={toggleSidebar}
        className="text-gray-700 md:hidden focus:outline-none mr-4"
        aria-label="Open sidebar"
      >
        <Menu className="w-6 h-6" />
      </button>

      {/* Displays current date and time */}
      <div className="text-gray-600 text-sm md:text-base font-inter flex-grow">
        {currentDateTime}
      </div>
      {/* User name and icon */}
      <div className="flex items-center">
        <span className="text-gray-800 font-semibold mr-3 font-inter">{userName}</span>
        <User className="w-6 h-6 text-gray-700" />
      </div>
    </header>
  );
};

// Profile Edit Form Component
const ProfileEditForm = ({ user, onSave, onCancel }) => {
  // State to manage form data
  const [formData, setFormData] = useState({
    name: user.name,
    username: user.username,
    email: user.email,
    current_password: '',
    new_password: '',
    new_password_confirmation: '',
  });
  // State to manage validation errors
  const [errors, setErrors] = useState([]);
  // States to toggle password visibility
  const [showCurrentPassword, setShowCurrentPassword] = useState(false);
  const [showNewPassword, setShowNewPassword] = useState(false);
  const [showConfirmPassword, setShowConfirmPassword] = useState(false);

  // Handles input changes and updates form data state
  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevData) => ({ ...prevData, [name]: value }));
  };

  // Handles form submission and performs validation
  const handleSubmit = (e) => {
    e.preventDefault();
    const newErrors = [];

    // Basic validation for name, username, and email
    if (!formData.name.trim()) {
      newErrors.push('Name is required.');
    }
    if (!formData.username.trim()) {
      newErrors.push('Username is required.');
    }
    if (!formData.email.trim()) {
      newErrors.push('Email is required.');
    } else if (!/\S+@\S+\.\S+/.test(formData.email)) {
      newErrors.push('Email is invalid.');
    }

    // Password validation (only if new password fields are touched)
    if (formData.new_password || formData.new_password_confirmation || formData.current_password) {
      if (!formData.current_password) {
        newErrors.push('Current Password is required to change password.');
      }
      if (formData.new_password.length) {
        newErrors.push('New Password must be at least 8 characters long.');
      }
      if (formData.new_password !== formData.new_password_confirmation) {
        newErrors.push('New Password and Confirm Password do not match.');
      }
    }

    setErrors(newErrors); // Update errors state

    // If no errors, call onSave and clear password fields
    if (newErrors.length === 0) {
      onSave(formData);
      setFormData((prevData) => ({
        ...prevData,
        current_password: '',
        new_password: '',
        new_password_confirmation: '',
      }));
    }
  };

  return (
    <div className="bg-white p-8 rounded-2xl shadow-lg w-full max-w-2xl">
      <h2 className="text-3xl font-bold text-gray-800 mb-6 text-center font-inter">Edit Profile</h2>

      {/* Display validation errors if any */}
      {errors.length > 0 && (
        <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6">
          <strong className="font-bold">Whoops!</strong>
          <span className="block sm:inline ml-2">There were some problems with your input.</span>
          <ul className="mt-2 list-disc list-inside">
            {errors.map((error, index) => (
              <li key={index}>{error}</li>
            ))}
          </ul>
        </div>
      )}

      <form onSubmit={handleSubmit}>
        {/* Personal Information Section */}
        <div className="mb-8">
          <h3 className="text-xl font-semibold text-gray-700 mb-4 font-inter">Personal Information</h3>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {/* Name Input */}
            <div className="flex flex-col">
              <label htmlFor="name" className="text-gray-600 font-medium mb-2 font-inter">Name</label>
              <div className="relative">
                <input
                  type="text"
                  id="name"
                  name="name"
                  value={formData.name}
                  onChange={handleChange}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 font-inter"
                />
                <User className="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
              </div>
            </div>
            {/* Username Input */}
            <div className="flex flex-col">
              <label htmlFor="username" className="text-gray-600 font-medium mb-2 font-inter">Username</label>
              <div className="relative">
                <input
                  type="text"
                  id="username"
                  name="username"
                  value={formData.username}
                  onChange={handleChange}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 font-inter"
                />
                <User className="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
              </div>
            </div>
            {/* Email Input */}
            <div className="flex flex-col md:col-span-2">
              <label htmlFor="email" className="text-gray-600 font-medium mb-2 font-inter">Email</label>
              <div className="relative">
                <input
                  type="email"
                  id="email"
                  name="email"
                  value={formData.email}
                  onChange={handleChange}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 font-inter"
                />
                <Mail className="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
              </div>
            </div>
          </div>
        </div>

        {/* Password Section */}
        <div>
          <h3 className="text-xl font-semibold text-gray-700 mb-4 font-inter">Change Password</h3>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {/* Current Password Input */}
            <div className="flex flex-col">
              <label htmlFor="current_password" className="text-gray-600 font-medium mb-2 font-inter">Current Password</label>
              <div className="relative">
                <input
                  type={showCurrentPassword ? 'text' : 'password'}
                  id="current_password"
                  name="current_password"
                  value={formData.current_password}
                  onChange={handleChange}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 font-inter"
                />
                <button
                  type="button"
                  onClick={() => setShowCurrentPassword(!showCurrentPassword)}
                  className="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none"
                  aria-label={showCurrentPassword ? 'Hide current password' : 'Show current password'}
                >
                  {showCurrentPassword ? <EyeOff className="w-5 h-5" /> : <Eye className="w-5 h-5" />}
                </button>
              </div>
            </div>
            {/* New Password Input */}
            <div className="flex flex-col">
              <label htmlFor="new_password" className="text-gray-600 font-medium mb-2 font-inter">New Password</label>
              <div className="relative">
                <input
                  type={showNewPassword ? 'text' : 'password'}
                  id="new_password"
                  name="new_password"
                  value={formData.new_password}
                  onChange={handleChange}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 font-inter"
                />
                <button
                  type="button"
                  onClick={() => setShowNewPassword(!showNewPassword)}
                  className="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none"
                  aria-label={showNewPassword ? 'Hide new password' : 'Show new password'}
                >
                  {showNewPassword ? <EyeOff className="w-5 h-5" /> : <Eye className="w-5 h-5" />}
                </button>
              </div>
            </div>
            {/* Confirm New Password Input */}
            <div className="flex flex-col md:col-span-2">
              <label htmlFor="new_password_confirmation" className="text-gray-600 font-medium mb-2 font-inter">Confirm New Password</label>
              <div className="relative">
                <input
                  type={showConfirmPassword ? 'text' : 'password'}
                  id="new_password_confirmation"
                  name="new_password_confirmation"
                  value={formData.new_password_confirmation}
                  onChange={handleChange}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 font-inter"
                />
                <button
                  type="button"
                  onClick={() => setShowConfirmPassword(!showConfirmPassword)}
                  className="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none"
                  aria-label={showConfirmPassword ? 'Hide confirm password' : 'Show confirm password'}
                >
                  {showConfirmPassword ? <EyeOff className="w-5 h-5" /> : <Eye className="w-5 h-5" />}
                </button>
              </div>
            </div>
          </div>
        </div>

        {/* Action Buttons */}
        <div className="flex justify-end space-x-4 mt-8">
          <button
            type="button"
            onClick={onCancel}
            className="px-6 py-3 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition-colors duration-200 font-inter"
          >
            Cancel
          </button>
          <button
            type="submit"
            className="px-6 py-3 bg-orange-500 text-white font-semibold rounded-xl hover:bg-orange-600 transition-colors duration-200 shadow-md font-inter"
          >
            Save Changes
          </button>
        </div>
      </form>
    </div>
  );
};


// Main App Component
export default function ShowProfile() {
  const [isSidebarOpen, setIsSidebarOpen] = useState(false);
  // State for modal visibility and content
  const [modal, setModal] = useState({
    isOpen: false,
    message: '',
    type: '', // 'success' or 'error'
  });

  // Function to toggle sidebar visibility
  const toggleSidebar = () => {
    setIsSidebarOpen(!isSidebarOpen);
  };

  // Function to close the modal
  const closeModal = () => {
    setModal({ isOpen: false, message: '', type: '' });
  };

  // Handles saving profile data, displays success modal
  const handleSave = (data) => {
    console.log('Profile saved:', data);
    // In a real application, you would send this data to your backend.
    setModal({
      isOpen: true,
      message: 'Profile updated successfully!',
      type: 'success',
    });
  };

  // Handles cancelling profile edit, displays cancel modal
  const handleCancel = () => {
    console.log('Edit cancelled.');
    setModal({
      isOpen: true,
      message: 'Profile edit cancelled.',
      type: 'error', // Using 'error' type for cancel as it's not a 'success'
    });
  };

  return (
    <div className="flex min-h-screen bg-orange-50 font-inter"> {/* Changed main background to light orange */}
      {/* Sidebar Component */}
      <Sidebar isOpen={isSidebarOpen} toggleSidebar={toggleSidebar} />

      {/* Main Content Area */}
      <div className="flex-1 flex flex-col md:ml-64">
        {/* Header Component */}
        <Header userName={dummyUser.name} toggleSidebar={toggleSidebar} />

        {/* Page Content */}
        <main className="flex-1 p-8 md:p-10 lg:p-12 mt-20 flex justify-center items-start">
          <ProfileEditForm user={dummyUser} onSave={handleSave} onCancel={handleCancel} />
        </main>

        {/* Footer */}
        <footer className="w-full bg-white text-gray-600 text-center py-4 text-sm shadow-inner rounded-t-2xl mt-auto font-inter">
          © 2025 Nikol and Friends. All rights reserved.
        </footer>
      </div>

      {/* Modal Component */}
      <Modal
        isOpen={modal.isOpen}
        message={modal.message}
        type={modal.type}
        onClose={closeModal}
      />
    </div>
  );
}