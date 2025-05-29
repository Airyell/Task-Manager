import React from 'react';

const EditProfile = () => {
  return (
    <div className="min-h-screen flex justify-center items-start pt-20">
      <div className="w-full max-w-2xl">
        <form className="bg-white shadow-md rounded-lg w-full">
          <div className="border-b px-6 py-4 text-center">
            <h4 className="text-xl font-semibold">Edit Profile</h4>
          </div>

          <div className="px-6 py-4">
            {/* Error messages */}
            {/* Example: 
            <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
              <ul className="list-disc pl-5">
                <li>Error message here</li>
              </ul>
            </div> 
            */}

            <div className="mb-4 flex flex-col md:flex-row md:items-center">
              <label htmlFor="name" className="md:w-1/3 mb-1 md:mb-0 text-sm font-medium">
                Name
              </label>
              <div className="md:w-2/3">
                <input
                  type="text"
                  id="name"
                  name="name"
                  className="w-full border rounded px-3 py-2"
                />
              </div>
            </div>

            <div className="mb-4 flex flex-col md:flex-row md:items-center">
              <label htmlFor="username" className="md:w-1/3 mb-1 md:mb-0 text-sm font-medium">
                Username
              </label>
              <div className="md:w-2/3">
                <input
                  type="text"
                  id="username"
                  name="username"
                  className="w-full border rounded px-3 py-2"
                />
              </div>
            </div>

            <div className="mb-4 flex flex-col md:flex-row md:items-center">
              <label htmlFor="email" className="md:w-1/3 mb-1 md:mb-0 text-sm font-medium">
                Email
              </label>
              <div className="md:w-2/3">
                <input
                  type="email"
                  id="email"
                  name="email"
                  className="w-full border rounded px-3 py-2"
                />
              </div>
            </div>

            <hr className="my-6" />

            <div className="mb-4 flex flex-col md:flex-row md:items-center">
              <label htmlFor="current_password" className="md:w-1/3 mb-1 md:mb-0 text-sm font-medium">
                Current Password
              </label>
              <div className="md:w-2/3">
                <input
                  type="password"
                  id="current_password"
                  name="current_password"
                  className="w-full border rounded px-3 py-2"
                />
              </div>
            </div>

            <div className="mb-4 flex flex-col md:flex-row md:items-center">
              <label htmlFor="new_password" className="md:w-1/3 mb-1 md:mb-0 text-sm font-medium">
                New Password
              </label>
              <div className="md:w-2/3">
                <input
                  type="password"
                  id="new_password"
                  name="new_password"
                  className="w-full border rounded px-3 py-2"
                />
              </div>
            </div>

            <div className="mb-4 flex flex-col md:flex-row md:items-center">
              <label htmlFor="new_password_confirmation" className="md:w-1/3 mb-1 md:mb-0 text-sm font-medium">
                Confirm Password
              </label>
              <div className="md:w-2/3">
                <input
                  type="password"
                  id="new_password_confirmation"
                  name="new_password_confirmation"
                  className="w-full border rounded px-3 py-2"
                />
              </div>
            </div>
          </div>

          <div className="bg-gray-100 px-6 py-4 text-right rounded-b-lg">
            <button
              type="button"
              className="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded mr-2"
            >
              Cancel
            </button>
            <button
              type="submit"
              className="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded"
            >
              Save
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default EditProfile;
