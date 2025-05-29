import React, { useState } from 'react';

const EditProject = ({ project }) => {
  const [formData, setFormData] = useState({
    name: project.name || '',
    description: project.description || '',
    start_date: project.start_date || '',
    end_date: project.end_date || '',
    status: project.status || 'not_started',
  });

  const handleChange = (e) => {
    setFormData((prev) => ({
      ...prev,
      [e.target.name]: e.target.value,
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    // handle submit logic here
  };

  return (
    <div className="container mx-auto px-4 py-6">
      <h2 className="text-2xl font-semibold mb-4 shadow p-3 rounded bg-white">Edit Project</h2>
      <div className="bg-white shadow-md rounded p-6 mx-auto" style={{ maxWidth: '600px' }}>
        <form onSubmit={handleSubmit}>
          <div className="mb-4">
            <label htmlFor="name" className="block text-sm font-medium text-gray-700">Name</label>
            <input
              type="text"
              name="name"
              id="name"
              value={formData.name}
              onChange={handleChange}
              required
              className="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
            />
          </div>

          <div className="mb-4">
            <label htmlFor="description" className="block text-sm font-medium text-gray-700">Description</label>
            <textarea
              name="description"
              id="description"
              value={formData.description}
              onChange={handleChange}
              className="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
            ></textarea>
          </div>

          <div className="mb-4">
            <label htmlFor="start_date" className="block text-sm font-medium text-gray-700">Start Date</label>
            <input
              type="date"
              name="start_date"
              id="start_date"
              value={formData.start_date}
              onChange={handleChange}
              className="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
            />
          </div>

          <div className="mb-4">
            <label htmlFor="end_date" className="block text-sm font-medium text-gray-700">End Date</label>
            <input
              type="date"
              name="end_date"
              id="end_date"
              value={formData.end_date}
              onChange={handleChange}
              className="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
            />
          </div>

          <div className="mb-6">
            <label htmlFor="status" className="block text-sm font-medium text-gray-700">Status</label>
            <select
              name="status"
              id="status"
              value={formData.status}
              onChange={handleChange}
              required
              className="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
            >
              <option value="not_started">Not Started</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
            </select>
          </div>

          <button
            type="submit"
            className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
          >
            Update Project
          </button>
        </form>
      </div>
    </div>
  );
};

export default EditProject;
