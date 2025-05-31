// resources/js/components/auth/history/Index.jsx
import React, { useEffect, useState } from 'react';

const ActivityHistory = () => {
  const [activities, setActivities] = useState([]);

  useEffect(() => {
    fetch('/api/history') // Adjust this endpoint as needed
      .then((res) => res.json())
      .then((data) => setActivities(data))
      .catch((err) => console.error('Error fetching activity history:', err));
  }, []);

  const handleDelete = async (id) => {
    if (window.confirm("Are you sure you want to delete this activity?")) {
      try {
        const res = await fetch(`/api/history/${id}`, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
          },
        });

        if (res.ok) {
          setActivities((prev) => prev.filter((activity) => activity.id !== id));
        } else {
          console.error('Failed to delete activity');
        }
      } catch (err) {
        console.error('Error deleting activity:', err);
      }
    }
  };

  return (
    <div>
      <h2 className="text-3xl font-bold mb-6 text-center text-gray-800">
        Activity History
      </h2>

      <div className="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md">
        {activities.length === 0 ? (
          <p className="text-gray-500 text-center">No activities found.</p>
        ) : (
          <ul className="space-y-4">
            {activities.map((activity) => (
              <li
                key={activity.id}
                className="p-4 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition"
              >
                <div className="flex justify-between items-start">
                  <div className="flex-1">
                    <h3 className="font-semibold text-lg text-gray-800 mb-1">
                      {activity.action}
                    </h3>
                    <p className="text-gray-700 mb-2">{activity.description}</p>
                    <p className="text-sm text-gray-500">
                      {new Date(activity.created_at).toLocaleString('en-US', {
                        timeZone: 'Asia/Manila',
                        month: 'short',
                        day: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true,
                      })}
                    </p>
                  </div>
                  <button
                    onClick={() => handleDelete(activity.id)}
                    className="ml-4 text-red-600 hover:text-red-800 font-semibold"
                    title="Delete activity"
                  >
                    Delete
                  </button>
                </div>
              </li>
            ))}
          </ul>
        )}
      </div>
    </div>
  );
};

export default ActivityHistory;
