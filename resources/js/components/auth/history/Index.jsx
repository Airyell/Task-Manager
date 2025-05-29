import React from "react";

const ActivityHistory = ({ activities, onDelete }) => {
  return (
    <div>
      {/* Header outside container */}
      <h2 className="text-2xl font-extrabold mb-4 text-gray-800 text-center">
        Activity History
      </h2>

      <div className="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md">
        {activities.length === 0 ? (
          <div className="text-center text-gray-500">No activities found.</div>
        ) : (
          <ul className="space-y-4">
            {activities.map((activity) => (
              <li
                key={activity.id}
                className="p-4 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition flex justify-between items-start"
              >
                {/* Left: Text content */}
                <div className="flex-1">
                  {/* Action on top, extra bold, bigger */}
                  <p className="font-extrabold text-black mb-2 text-2xl">
                    {activity.action}
                  </p>
                  {/* Description */}
                  <p className="text-gray-700 mb-1">{activity.description}</p>
                  {/* Timestamp smaller */}
                  <p className="text-xs text-gray-500">
                    {new Date(activity.created_at).toLocaleString("en-US", {
                      timeZone: "Asia/Manila",
                      month: "short",
                      day: "2-digit",
                      year: "numeric",
                      hour: "2-digit",
                      minute: "2-digit",
                      hour12: true,
                    })}
                  </p>
                </div>

                {/* Right: Delete Button aligned top-right */}
                <div className="ml-4">
                  <button
                    onClick={() => {
                      if (
                        window.confirm(
                          "Are you sure you want to delete this activity?"
                        )
                      ) {
                        onDelete(activity.id);
                      }
                    }}
                    className="text-red-600 hover:text-red-800"
                    title="Delete Activity"
                  >
                    {/* Trash icon from Heroicons (you can replace or import any icon) */}
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      className="h-6 w-6"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      strokeWidth={2}
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 7V4a1 1 0 011-1h2a1 1 0 011 1v3"
                      />
                    </svg>
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
