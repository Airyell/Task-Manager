import React from 'react';

const Projects = () => {
  // Dummy data for demonstration
  const projects = [
    {
      id: 1,
      name: 'Project Alpha',
      description: 'A sample project.',
      status: 'pending',
      end_date: new Date(Date.now() + 86400000), // 1 day from now
    },
    {
      id: 2,
      name: 'Project Beta',
      description: 'Another example project.',
      status: 'on_going',
      end_date: new Date(Date.now() - 86400000), // 1 day ago
    },
  ];

  const getStatusText = (status) => {
    if (status === 'pending') return 'Pending';
    if (status === 'on_going') return 'In Progress';
    return 'Completed';
  };

  const isFuture = (date) => new Date(date) > new Date();

  return (
    <div className="container mx-auto px-4 py-6">
      <div className="flex justify-between items-center bg-white mb-6 shadow p-4 rounded">
        <h2 className="text-xl font-semibold">Projects</h2>
        <a href="/projects/create" className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Add Project
        </a>
      </div>

      {/* Replace with success state logic as needed */}
      {/* <div className="bg-green-100 text-green-800 p-3 rounded mb-4">Project created successfully!</div> */}

      <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
        {projects.map((project) => (
          <div key={project.id} className="bg-white shadow rounded p-4">
            <h5 className="text-lg font-bold mb-2">{project.name}</h5>
            <p className="mb-2">{project.description}</p>
            <p className="mb-4">
              <strong>Status:</strong> {getStatusText(project.status)} <br />
              <strong>Deadline:</strong>{' '}
              {isFuture(project.end_date) ? (
                <span>{new Date(project.end_date).toDateString()}</span>
              ) : (
                <span className="text-red-500">Deadline Passed</span>
              )}
            </p>
            <div className="flex space-x-2">
              <a
                href={`/projects/${project.id}/tasks`}
                className="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700"
              >
                <i className="bi bi-list"></i>
              </a>
              <a
                href={`/projects/${project.id}`}
                className="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700"
              >
                <i className="bi bi-eye"></i>
              </a>
              <a
                href={`/projects/${project.id}/edit`}
                className="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
              >
                <i className="bi bi-pencil-square"></i>
              </a>
              <form
                action={`/projects/${project.id}`}
                method="POST"
                className="inline"
                onSubmit={(e) => {
                  if (!window.confirm('Are you sure you want to delete this project?')) {
                    e.preventDefault();
                  }
                }}
              >
                {/* Simulate DELETE */}
                <input type="hidden" name="_method" value="DELETE" />
                <button type="submit" className="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                  <i className="bi bi-trash"></i>
                </button>
              </form>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Projects;
