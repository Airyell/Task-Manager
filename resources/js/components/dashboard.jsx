import React from 'react';

/**
 * Custom CSS for the logo pulse animation.
 * This is embedded directly in the component for demonstration.
 * In a larger project, this might be in a separate CSS file.
 */
const customStyles = `
  @keyframes pulse-custom {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.05); opacity: 0.95; }
  }
  .animate-pulse-custom {
    animation: pulse-custom 2s infinite;
  }
`;

/**
 * The Dashboard component.
 * This component displays user dashboard information, including task and note counts,
 * and recent tasks/notes, styled entirely with Tailwind CSS.
 *
 * @param {object} props - The component props.
 * @param {number} [props.tasksCount=3] - The number of pending tasks. Defaults to 3 for demonstration.
 * @param {number} [props.notesCount=5] - The number of saved notes. Defaults to 5 for demonstration.
 * @param {number} [props.completedTasksCount=10] - The number of completed tasks. Defaults to 10 for demonstration.
 * @param {Array<object>} [props.recentTasks=[]] - An array of recent task objects. Defaults to dummy data.
 * @param {Array<object>} [props.recentNotes=[]] - An array of recent note objects. Defaults to dummy data.
 */
function App({
  tasksCount = 3, // Dummy data for demonstration
  notesCount = 5, // Dummy data
  completedTasksCount = 10, // Dummy data
  recentTasks = [ // Dummy data
    { title: 'Fix login bug', status: 'in_progress' },
    { title: 'Update database schema', status: 'to_do' },
    { title: 'Implement search feature', status: 'completed' },
  ],
  recentNotes = [ // Dummy data
    { title: 'Meeting notes 2025-05-28' },
    { title: 'Project ideas for Q3' },
  ]
}) {
  // Placeholder for logo image URL.
  const logoImage = 'https://placehold.co/100x100/FFF8F1/0F2D4E?text=Logo';

  return (
    // Inject custom styles for the pulse animation
    <>
      <style>{customStyles}</style>
      <div className="min-h-screen flex font-inter bg-slate-900"> {/* Main container for sidebar and content */}
        {/* Sidebar */}
        <div className="w-64 bg-[#0f2d4e] text-white flex flex-col p-6 rounded-r-xl shadow-lg">
          <div className="text-center mb-8">
            <img
              src={logoImage}
              alt="Taskaroo Logo"
              className="max-h-24 mb-4 mx-auto animate-pulse-custom"
            />
            <h2 className="text-3xl font-bold">Taskaroo</h2>
          </div>
          <nav className="flex-grow">
            <ul className="space-y-4">
              <li>
                <a href="#" className="flex items-center p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                  <span className="mr-3">🏠</span> Home
                </a>
              </li>
              <li>
                <a href="#" className="flex items-center p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                  <span className="mr-3">📂</span> Projects
                </a>
              </li>
              <li>
                <a href="#" className="flex items-center p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                  <span className="mr-3">📝</span> Notes
                </a>
              </li>
              <li>
                <a href="#" className="flex items-center p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                  <span className="mr-3">✅</span> Completed Tasks
                </a>
              </li>
              <li>
                <a href="#" className="flex items-center p-3 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                  <span className="mr-3">📜</span> History
                </a>
              </li>
            </ul>
          </nav>
        </div>

        {/* Main Content Area */}
        <div className="flex-1 p-8 flex items-center justify-center">
          <div className="bg-white bg-opacity-95 rounded-xl shadow-xl backdrop-blur-md border border-gray-300/20 max-w-5xl w-full p-8">
            {/* Dashboard Header */}
            <div className="text-center mb-8">
              <h2 className="text-3xl font-bold text-[#0f2d4e]">Welcome to Taskaroo</h2>
              <p className="text-gray-700">
                Manage your tasks and notes in one organized place.
              </p>
            </div>

            {/* Counts Section */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
              <div className="bg-[#fffdfb] rounded-lg shadow-sm h-full flex flex-col">
                <div className="p-6 flex flex-col flex-grow">
                  <h5 className="text-xl font-semibold text-[#0f2d4e] mb-2">Tasks</h5>
                  <p className="text-gray-700 flex-grow">
                    You have <strong className="font-bold">{tasksCount}</strong> tasks pending.
                  </p>
                  <a href="#" className="mt-auto px-4 py-2 bg-orange-500 text-white font-semibold rounded-md shadow-sm hover:bg-orange-600 transition duration-300 text-center">
                    View Tasks
                  </a>
                </div>
              </div>

              <div className="bg-[#fffdfb] rounded-lg shadow-sm h-full flex flex-col">
                <div className="p-6 flex flex-col flex-grow">
                  <h5 className="text-xl font-semibold text-[#0f2d4e] mb-2">Notes</h5>
                  <p className="text-gray-700 flex-grow">
                    You have <strong className="font-bold">{notesCount}</strong> notes saved.
                  </p>
                  <a href="#" className="mt-auto px-4 py-2 bg-orange-500 text-white font-semibold rounded-md shadow-sm hover:bg-orange-600 transition duration-300 text-center">
                    View Notes
                  </a>
                </div>
              </div>

              <div className="bg-[#fffdfb] rounded-lg shadow-sm h-full flex flex-col">
                <div className="p-6 flex flex-col flex-grow">
                  <h5 className="text-xl font-semibold text-[#0f2d4e] mb-2">Completed Tasks</h5>
                  <p className="text-gray-700 flex-grow">
                    You have <strong className="font-bold">{completedTasksCount}</strong> Completed Tasks Saved.
                  </p>
                  <a href="#" className="mt-auto px-4 py-2 bg-orange-500 text-white font-semibold rounded-md shadow-sm hover:bg-orange-600 transition duration-300 text-center">
                    View Tasks
                  </a>
                </div>
              </div>
            </div>

            {/* Recent Lists Section */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div className="bg-[#fffdfb] rounded-lg shadow-sm h-full">
                <div className="p-6">
                  <h5 className="text-xl font-semibold text-[#0f2d4e] mb-4">Recent Tasks</h5>
                  <ul className="divide-y divide-gray-200">
                    {recentTasks.length > 0 ? (
                      recentTasks.map((task, index) => (
                        <li key={index} className="py-3 flex justify-between items-center text-gray-700 text-base">
                          {task.title}
                          <span
                            className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                              task.status === 'to_do'
                                ? 'bg-blue-500 text-white'
                                : task.status === 'in_progress'
                                ? 'bg-yellow-400 text-gray-800'
                                : 'bg-green-500 text-white'
                            }`}
                          >
                            {task.status === 'to_do'
                              ? 'To Do'
                              : task.status === 'in_progress'
                              ? 'In Progress'
                              : 'Completed'}
                          </span>
                        </li>
                      ))
                    ) : (
                      <li className="py-3 text-gray-500">No recent tasks.</li>
                    )}
                  </ul>
                </div>
              </div>

              <div className="bg-[#fffdfb] rounded-lg shadow-sm h-full">
                <div className="p-6">
                  <h5 className="text-xl font-semibold text-[#0f2d4e] mb-4">Recent Notes</h5>
                  <ul className="divide-y divide-gray-200">
                    {recentNotes.length > 0 ? (
                      recentNotes.map((note, index) => (
                        <li key={index} className="py-3 text-gray-700 text-base">
                          {note.title}
                        </li>
                      ))
                    ) : (
                      <li className="py-3 text-gray-500">No recent notes.</li>
                    )}
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}

export default App;
