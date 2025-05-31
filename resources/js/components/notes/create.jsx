import React, { useState } from "react";

// Main App component to host the AddNote component
const CreateNote = () => {
  return (
    <div className="min-h-screen bg-gray-100 flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
      <AddNote />
    </div>
  );
};

// AddNote component for handling note creation
const AddNote = () => {
  // State to manage form data for title, content, and date
  const [formData, setFormData] = useState({
    title: "",
    content: "",
    date: "", // Date field
  });

  // State to manage form validation errors
  const [errors, setErrors] = useState({});
  // State to manage success message after a successful form submission
  const [success, setSuccess] = useState("");

  /**
   * Validates the form data before submission.
   * Checks for required fields and sets appropriate error messages.
   * @returns {object} An object where keys are field names and values are error messages.
   */
  const validate = () => {
    const newErrors = {};
    // Validate 'title' field: must not be empty
    if (!formData.title.trim()) {
      newErrors.title = "Title is required";
    }
    // Validate 'content' field: must not be empty
    if (!formData.content.trim()) {
      newErrors.content = "Content is required";
    }
    return newErrors;
  };

  /**
   * Handles changes to any form input element.
   * Updates the corresponding field in the formData state.
   * @param {Object} e - The event object from the input or textarea change.
   */
  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
    // Clear the specific error for the field being changed
    if (errors[name]) {
      setErrors((prev) => ({ ...prev, [name]: undefined }));
    }
  };

  /**
   * Handles the form submission event.
   * Prevents default form submission, validates the data, and if valid,
   * simulates a successful submission and resets the form.
   * @param {Object} e - The event object from the form submission.
   */
  const handleSubmit = (e) => {
    e.preventDefault(); // Prevent the browser's default form submission behavior
    setSuccess(""); // Clear any previous success messages
    const validationErrors = validate(); // Run validation on current form data

    if (Object.keys(validationErrors).length > 0) {
      // If validation errors exist, update the errors state
      setErrors(validationErrors);
    } else {
      // If no validation errors, proceed with simulated submission
      setErrors({}); // Clear all errors
      setSuccess("Note added successfully!"); // Display success message
      console.log("Submitted note data:", formData); // Log the form data to console

      // Reset the form fields to their initial empty state
      setFormData({
        title: "",
        content: "",
        date: "",
      });
    }
  };

  return (
    <div className="container mx-auto max-w-2xl">
      <h2 className="text-3xl font-bold text-gray-800 text-center mb-6 py-4 px-6 bg-white rounded-lg shadow-md">
        Add Note
      </h2>

      {/* Success message display, conditionally rendered */}
      {success && (
        <div className="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-center mb-6 w-full max-w-md mx-auto shadow-sm">
          {success}
        </div>
      )}

      <div className="bg-white rounded-lg shadow-xl p-6">
        <form onSubmit={handleSubmit} className="space-y-6">
          {/* Title Input Field */}
          <div>
            <label htmlFor="title" className="block text-sm font-semibold text-gray-700 mb-2">
              Title <span className="text-red-500">*</span> {/* Required indicator */}
            </label>
            <input
              type="text"
              name="title"
              id="title"
              value={formData.title}
              onChange={handleChange}
              className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 ease-in-out outline-none"
              required // HTML5 required attribute for basic client-side validation
              placeholder="e.g., Meeting notes"
            />
            {/* Display validation error for title if it exists */}
            {errors.title && <p className="text-red-500 text-sm mt-2">{errors.title}</p>}
          </div>

          {/* Content Textarea Field */}
          <div>
            <label htmlFor="content" className="block text-sm font-semibold text-gray-700 mb-2">
              Content <span className="text-red-500">*</span> {/* Required indicator */}
            </label>
            <textarea
              name="content"
              id="content"
              value={formData.content}
              onChange={handleChange}
              rows="5" // Sets the visible height of the textarea
              className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 ease-in-out resize-y outline-none" // 'resize-y' allows vertical resizing
              required // HTML5 required attribute
              placeholder="Write your note content here..."
            />
            {/* Display validation error for content if it exists */}
            {errors.content && <p className="text-red-500 text-sm mt-2">{errors.content}</p>}
          </div>

          {/* Date Input Field */}
          <div>
            <label htmlFor="date" className="block text-sm font-semibold text-gray-700 mb-2">
              Date
            </label>
            <input
              type="date"
              name="date"
              id="date"
              value={formData.date}
              onChange={handleChange}
              className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 ease-in-out outline-none"
            />
            {/* Display validation error for date if it exists */}
            {errors.date && <p className="text-red-500 text-sm mt-2">{errors.date}</p>}
          </div>

          {/* Submit Button */}
          <button
            type="submit"
            className="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          >
            Add Note
          </button>
        </form>
      </div>
    </div>
  );
};

export default CreateNote;