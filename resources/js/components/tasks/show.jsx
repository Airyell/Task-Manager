import React, { useState, useEffect } from 'react';
import { Modal, Button } from '@/components/ui';

const TaskDetails = ({ task }) => {
  const [seconds, setSeconds] = useState(0);
  const [isRunning, setIsRunning] = useState(false);

  useEffect(() => {
    let timer;
    if (isRunning) {
      timer = setInterval(() => setSeconds(prev => prev + 1), 1000);
    }
    return () => clearInterval(timer);
  }, [isRunning]);

  const formatTime = sec => {
    const hours = String(Math.floor(sec / 3600)).padStart(2, '0');
    const minutes = String(Math.floor((sec % 3600) / 60)).padStart(2, '0');
    const seconds = String(sec % 60).padStart(2, '0');
    return `${hours}:${minutes}:${seconds}`;
  };

  const toggleChecklistItem = async (itemId) => {
    const response = await fetch(`/checklist-items/update-status/${itemId}`, {
      method: 'GET',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
    });
    const data = await response.json();
    // handle response update
  };

  return (
    <div className="container mx-auto px-4 py-6">
      <h2 className="text-2xl font-bold mb-6 text-center bg-white shadow-sm p-4 rounded">
        {task.title} - Task Details
      </h2>

      <div className="max-w-4xl mx-auto bg-white shadow-md rounded p-6">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <h3 className="text-xl font-semibold">{task.title}</h3>
            <p className="mt-2">{task.description}</p>
            <p className="mt-2 font-medium">Due Date: <span className="font-normal">{task.due_date}</span></p>
            <p className="mt-2 font-medium">Priority: <span className={`px-2 py-1 rounded text-white ${task.priority === 'low' ? 'bg-green-500' : task.priority === 'medium' ? 'bg-yellow-500' : 'bg-red-500'}`}>{task.priority}</span></p>
            <p className="mt-2 font-medium">Status: <span className={`px-2 py-1 rounded text-white ${task.status === 'completed' ? 'bg-green-500' : task.status === 'to_do' ? 'bg-blue-500' : 'bg-yellow-500'}`}>{task.status.replace('_', ' ')}</span></p>
            <p className="mt-2 font-medium">Assign To: <span className="font-normal">{task.user.name}</span></p>

            <div className="mt-4 space-x-2">
              <Button variant="primary" onClick={() => {/* open edit modal */}}>Edit</Button>
              <Button variant="secondary" onClick={() => window.history.back()}>Back</Button>
            </div>
          </div>

          <div className="border-l pl-4">
            <h4 className="text-lg font-semibold mb-2">Time Tracker</h4>
            <div className="mb-2 text-2xl font-mono">{formatTime(seconds)}</div>
            <div className="space-x-2">
              <Button variant="success" onClick={() => setIsRunning(true)}>Start</Button>
              <Button variant="warning" onClick={() => setIsRunning(false)}>Pause</Button>
              <Button variant="danger" onClick={() => { setIsRunning(false); setSeconds(0); }}>Reset</Button>
            </div>
          </div>
        </div>

        <div className="mt-6 border-t pt-4">
          <div className="flex justify-between items-center mb-2">
            <h4 className="text-lg font-semibold">Checklist</h4>
            <Button variant="primary" onClick={() => {/* open add modal */}}>Add Item</Button>
          </div>
          <ul className="space-y-2">
            {task.checklistItems.map(item => (
              <li key={item.id} className="flex justify-between items-center bg-gray-50 p-2 rounded shadow-sm">
                <div className="flex items-center">
                  <input
                    type="checkbox"
                    checked={item.completed}
                    onChange={() => toggleChecklistItem(item.id)}
                    className="mr-2"
                  />
                  <span className={item.completed ? 'line-through' : ''}>{item.name}</span>
                </div>
                <div className="space-x-2">
                  <Button size="sm" variant="primary" onClick={() => {/* open edit modal */}}>Edit</Button>
                  <Button size="sm" variant="danger" onClick={() => {/* delete checklist item */}}>Delete</Button>
                </div>
              </li>
            ))}
          </ul>
        </div>
      </div>
    </div>
  );
};

export default TaskDetails;