import React, { useEffect, useState } from 'react';

const Dashboard = () => {
  const [tasksCount, setTasksCount] = useState(0);
  const [notesCount, setNotesCount] = useState(0);
  const [completedTasksCount, setCompletedTasksCount] = useState(0);
  const [recentTasks, setRecentTasks] = useState([]);
  const [recentNotes, setRecentNotes] = useState([]);

  useEffect(() => {
    // Replace with your actual API endpoints
    fetch('http://localhost:8080/api/dashboard')
      .then(res => res.json())
      .then(data => {
        setTasksCount(data.tasksCount);
        setNotesCount(data.notesCount);
        setCompletedTasksCount(data.completedTasksCount);
        setRecentTasks(data.recentTasks);
        setRecentNotes(data.recentNotes);
      })
      .catch(console.error);
  }, []);

  return (
    <div className="min-h-screen flex items-center justify-center bg-cover bg-center font-poppins" style={{ backgroundImage: "url('/assets/img/Background.png')" }}>
      <div className="bg-[#fff8f1]/95 max-w-5xl w-full p-8 rounded-2xl shadow-2xl border border-[rgba(100,90,80,0.2)] backdrop-blur">
        <div className="text-center mb-8">
          <img src="/assets/img/kangaroo-fixed-logo.png" alt="Taskaroo Logo" className="h-24 mb-4 animate-pulse" />
          <h2 className="text-3xl font-bold text-[#0f2d4e]">Taskaroo</h2>
          <p>Welcome to your dashboard where you can manage your tasks and notes.</p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
          <Card title="Tasks" count={tasksCount} link="/projects" />
          <Card title="Notes" count={notesCount} link="/notes" />
          <Card title="Completed Tasks" count={completedTasksCount} link="/projects" />
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <RecentList title="Recent Tasks" items={recentTasks} isTask />
          <RecentList title="Recent Notes" items={recentNotes} />
        </div>
      </div>
    </div>
  );
};

const Card = ({ title, count, link }) => (
  <div className="bg-[#fffdfb] shadow p-4 rounded-lg flex flex-col justify-between h-full">
    <h5 className="text-xl font-semibold text-[#0f2d4e]">{title}</h5>
    <p className="text-gray-700 flex-grow">You have <strong>{count}</strong> {title.toLowerCase()}.</p>
    <a href={link} className="btn btn-primary mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded text-center">View {title}</a>
  </div>
);

const RecentList = ({ title, items, isTask = false }) => (
  <div className="bg-[#fffdfb] shadow p-4 rounded-lg">
    <h5 className="text-xl font-semibold text-[#0f2d4e] mb-4">{title}</h5>
    <ul className="space-y-2">
      {items.map(item => (
        <li key={item.id} className="flex justify-between items-center bg-white p-3 rounded border text-sm">
          {item.title}
          {isTask && (
            <span className={`px-2 py-1 rounded-full text-xs font-semibold ${
              item.status === 'to_do'
                ? 'bg-blue-500 text-white'
                : item.status === 'in_progress'
                ? 'bg-yellow-400 text-black'
                : 'bg-green-500 text-white'
            }`}>
              {item.status === 'to_do'
                ? 'To Do'
                : item.status === 'in_progress'
                ? 'In Progress'
                : 'Completed'}
            </span>
          )}
        </li>
      ))}
    </ul>
  </div>
);

export default Dashboard;
