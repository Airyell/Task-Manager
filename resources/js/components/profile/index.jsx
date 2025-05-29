import React from 'react';

const UserProfile = () => {
  // Dummy data placeholders; replace with actual user data as needed
  const user = {
    name: 'John Doe',
    username: 'johndoe',
    email: 'john@example.com',
    profile: {
      bio: 'Lorem ipsum dolor sit amet.',
    },
  };

  return (
    <div className="max-w-xl mx-auto pt-8">
      <h1 className="text-2xl font-bold mb-5">User Profile</h1>

      <div className="border border-gray-300 p-6 rounded-lg">
        <p className="mb-2">
          <strong>Name:</strong> {user.name}
        </p>
        <p className="mb-2">
          <strong>Username:</strong> {user.username}
        </p>
        <p className="mb-2">
          <strong>Email:</strong> {user.email}
        </p>

        {user.profile && user.profile.bio && (
          <p className="mb-2">
            <strong>Bio:</strong> {user.profile.bio}
          </p>
        )}

        <div className="mt-5">
          <a
            href="/profile/edit"
            className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
          >
            Edit Profile
          </a>
        </div>
      </div>
    </div>
  );
};

export default UserProfile;
