import React from 'react';

const Notes = ({ notes, onEdit, onDelete, onAdd, successMessage }) => {
  return (
    <div className="container mx-auto px-4">
      <div className="flex justify-between items-center bg-white shadow-sm p-4 rounded mb-6">
        <h2 className="text-xl font-semibold">Notes</h2>
        <button
          onClick={onAdd}
          className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          Add Note
        </button>
      </div>

      {successMessage && (
        <div className="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
          {successMessage}
        </div>
      )}

      {notes.length > 0 ? (
        <div className="grid md:grid-cols-3 gap-4">
          {notes.map((note) => (
            <div key={note.id} className="bg-white shadow-md rounded p-4">
              <h5 className="text-lg font-semibold mb-2">{note.title}</h5>
              <p className="text-gray-700 mb-2">
                {note.content.length > 150
                  ? `${note.content.slice(0, 150)}...`
                  : note.content}
              </p>
              <p className="text-sm text-gray-500 mb-4">
                <strong>Date:</strong> {note.date}
              </p>
              <div className="flex justify-between">
                <button
                  onClick={() => onEdit(note.id)}
                  className="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                >
                  Edit
                </button>
                <button
                  onClick={() =>
                    window.confirm('Are you sure you want to delete this note?') &&
                    onDelete(note.id)
                  }
                  className="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
                >
                  Delete
                </button>
              </div>
            </div>
          ))}
        </div>
      ) : (
        <p className="text-gray-500">No notes found.</p>
      )}
    </div>
  );
};

export default Notes;
