import React, { useState } from 'react';

const EditNote = ({ note, onUpdate }) => {
  const [title, setTitle] = useState(note.title || '');
  const [content, setContent] = useState(note.content || '');
  const [date, setDate] = useState(note.date || '');
  const [errors, setErrors] = useState({});

  const handleSubmit = (e) => {
    e.preventDefault();

    // Example validation
    const newErrors = {};
    if (!title.trim()) newErrors.title = 'Title is required';
    if (!content.trim()) newErrors.content = 'Content is required';

    if (Object.keys(newErrors).length > 0) {
      setErrors(newErrors);
      return;
    }

    // Trigger the update callback
    onUpdate({ id: note.id, title, content, date });
  };

  return (
    <div className="container mx-auto px-4">
      <h2 className="mb-4 shadow-sm p-3 rounded bg-white text-xl font-semibold">Edit Note</h2>

      <form onSubmit={handleSubmit} className="bg-white p-6 rounded shadow">
        <div className="mb-4">
          <label htmlFor="title" className="block text-sm font-medium text-gray-700">Title</label>
          <input
            type="text"
            id="title"
            className="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
            value={title}
            onChange={(e) => setTitle(e.target.value)}
            required
          />
          {errors.title && <span className="text-red-500 text-sm">{errors.title}</span>}
        </div>

        <div className="mb-4">
          <label htmlFor="content" className="block text-sm font-medium text-gray-700">Content</label>
          <textarea
            id="content"
            rows="5"
            className="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
            value={content}
            onChange={(e) => setContent(e.target.value)}
            required
          />
          {errors.content && <span className="text-red-500 text-sm">{errors.content}</span>}
        </div>

        <div className="mb-4">
          <label htmlFor="date" className="block text-sm font-medium text-gray-700">Date</label>
          <input
            type="date"
            id="date"
            className="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
            value={date}
            onChange={(e) => setDate(e.target.value)}
          />
          {errors.date && <span className="text-red-500 text-sm">{errors.date}</span>}
        </div>

        <button type="submit" className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Update Note
        </button>
      </form>
    </div>
  );
};

export default EditNote;
