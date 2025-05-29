import React, { useState } from "react";

// Main App component
const App = () => {
  return (
    <div className="min-h-screen bg-gray-100 flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
      <CreateTask />
    </div>
  );
};

// CreateTask component for handling task creation
const CreateTask = () => {
  // State to manage form data for title, description, due_date, and priority
  const [formData, setFormData] = useState({
    title: "",
    description: "",
    due_date: "",
    priority: "low", // Default priority
  });

  // State to manage form validation errors for each field
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
    // Validate 'priority' field: must not be empty (though select has a default)
    if (!formData.priority) {
      newErrors.priority = "Priority is required";
    }
    // Add more validation rules here if needed for description or due_date
    return newErrors;
  };

  /**
   * Handles changes to any form input element.
   * Updates the corresponding field in the formData state.
   * @param {Object} e - The event object from the input or select change.
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
      setSuccess("Task created successfully!"); // Display success message
      console.log("Submitted task data:", formData); // Log the form data to console

      // Reset the form fields to their initial empty/default state
      setFormData({
        title: "",
        description: "",
        due_date: "",
        priority: "low",
      });
    }
  };

  return (
    <div className="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow-lg border border-gray-200 w-full">
      <h2 className="text-3xl font-bold text-gray-800 mb-8 text-center">Create Task</h2>

      {/* Success message display, conditionally rendered */}
      {success && (
        <div className="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center font-medium">
          {success}
        </div>
      )}

      <form onSubmit={handleSubmit} className="space-y-6">
        {/* Title Input Field */}
        <div>
          <label htmlFor="title" className="block text-sm font-semibold text-gray-700 mb-2">
            Title <span className="text-red-500">*</span> {/* Required indicator */}
          </label>
          <input
            type="text"
            id="title"
            name="title"
            value={formData.title}
            onChange={handleChange}
            required // HTML5 required attribute for basic client-side validation
            className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 ease-in-out"
            placeholder="e.g., Complete project proposal"
          />
          {/* Display validation error for title if it exists */}
          {errors.title && <p className="text-red-500 text-sm mt-2">{errors.title}</p>}
        </div>

        {/* Description Textarea Field */}
        <div>
          <label htmlFor="description" className="block text-sm font-semibold text-gray-700 mb-2">
            Description
          </label>
          <textarea
            id="description"
            name="description"
            value={formData.description}
            onChange={handleChange}
            rows="4" // Sets the visible height of the textarea
            className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 ease-in-out resize-y" // 'resize-y' allows vertical resizing
            placeholder="Provide a detailed description of the task..."
          />
          {/* Display validation error for description if it exists */}
          {errors.description && <p className="text-red-500 text-sm mt-2">{errors.description}</p>}
        </div>

        {/* Due Date Input Field */}
        <div>
          <label htmlFor="due_date" className="block text-sm font-semibold text-gray-700 mb-2">
            Due Date
          </label>
          <input
            type="date"
            id="due_date"
            name="due_date"
            value={formData.due_date}
            onChange={handleChange}
            className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 ease-in-out"
          />
          {/* Display validation error for due_date if it exists */}
          {errors.due_date && <p className="text-red-500 text-sm mt-2">{errors.due_date}</p>}
        </div>

        {/* Priority Select Field */}
        <div>
          <label htmlFor="priority" className="block text-sm font-semibold text-gray-700 mb-2">
            Priority <span className="text-red-500">*</span> {/* Required indicator */}
          </label>
          <select
            id="priority"
            name="priority"
            value={formData.priority}
            onChange={handleChange}
            required // HTML5 required attribute
            className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 ease-in-out"
          >
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
          {/* Display validation error for priority if it exists */}
          {errors.priority && <p className="text-red-500 text-sm mt-2">{errors.priority}</p>}
        </div>

        {/* Submit Button */}
        <button
          type="submit"
          className="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
          Create Task
        </button>
      </form>
    </div>
  );
};

export default App;