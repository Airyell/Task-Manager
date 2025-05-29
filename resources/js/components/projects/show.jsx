import React, { useState } from 'react';

const ProjectDetails = ({ project, teamMembers, users }) => {
  const [showModal, setShowModal] = useState(false);
  const [selectedUserId, setSelectedUserId] = useState('');

  const totalTasks = project.tasks.length;
  const completedTasks = project.tasks.filter(task => task.status === 'completed').length;
  const progress = totalTasks > 0 ? (completedTasks / totalTasks) * 100 : 0;

  const handleAddMember = (e) => {
    e.preventDefault();
    // handle adding member
  };

  return (
    <div className="container mx-auto px-4 py-6">
      <h2 className="text-2xl font-bold mb-4 text-center bg-white shadow p-4 rounded">
        {project.name}
      </h2>

      {/* Success message */}
      {/* Add conditional render if needed */}

      <div className="flex flex-col lg:flex-row gap-6">
        {/* Project Details */}
        <div className="w-full lg:w-2/3">
          <div className="bg-white p-6 rounded shadow">
            <h3 className="text-xl font-semibold mb-2">{project.name}</h3>
            <p className="mb-2">{project.description}</p>
            <p><strong>Start Date:</strong> {project.start_date}</p>
            <p><strong>End Date:</strong> {project.end_date}</p>
            <p><strong>Status:</strong> {
              project.status === 'pending' ? 'Pending' :
              project.status === 'on_going' ? 'In Progress' : 'Completed'
            }</p>

            <h4 className="text-lg font-semibold mt-4">Project Progress</h4>
            <div className="w-full bg-gray-200 rounded-full h-4 mb-4">
              <div
                className="bg-blue-600 h-4 rounded-full text-white text-xs text-center"
                style={{ width: `${progress}%` }}
              >
                {Math.round(progress)}%
              </div>
            </div>

            <a
              href="/projects"
              className="mt-4 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
            >
              Back to Projects
            </a>
          </div>
        </div>

        {/* Team Members */}
        <div className="w-full lg:w-1/3">
          <div className="bg-white p-6 rounded shadow">
            <div className="flex justify-between items-center mb-4">
              <h3 className="text-xl font-semibold">Team Members</h3>
              <button
                className="bg-blue-600 text-white p-2 rounded hover:bg-blue-700"
                onClick={() => setShowModal(true)}
              >
                +
              </button>
            </div>

            <div className="space-y-3">
              {teamMembers.map(user => (
                <div key={user.id} className="bg-gray-100 p-3 rounded">
                  <p className="font-bold">{user.name}</p>
                  <p>{user.email}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>

      {/* Modal */}
      {showModal && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
          <div className="bg-white rounded shadow-lg w-full max-w-md p-6">
            <div className="flex justify-between items-center mb-4">
              <h4 className="text-lg font-semibold">Add Team Member</h4>
              <button onClick={() => setShowModal(false)} className="text-gray-600 text-2xl">&times;</button>
            </div>
            <form onSubmit={handleAddMember}>
              <input type="hidden" name="project_id" value={project.id} />
              <div className="mb-4">
                <label className="block mb-1 font-medium" htmlFor="user_id">Select User</label>
                <select
                  name="user_id"
                  value={selectedUserId}
                  onChange={e => setSelectedUserId(e.target.value)}
                  className="w-full border border-gray-300 rounded px-3 py-2"
                  required
                >
                  <option value="">Select</option>
                  {users.map(user => (
                    <option key={user.id} value={user.id}>{user.name}</option>
                  ))}
                </select>
              </div>
              <div className="flex justify-end space-x-2">
                <button
                  type="button"
                  onClick={() => setShowModal(false)}
                  className="bg-gray-500 text-white px-4 py-2 rounded"
                >
                  Close
                </button>
                <button
                  type="submit"
                  className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                  Add Member
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};

export default ProjectDetails;
