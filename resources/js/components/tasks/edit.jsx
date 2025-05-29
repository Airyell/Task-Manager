import React, { useState, useEffect } from "react";

// Main App component to host the EditTask component
const App = () => {
  // State to simulate fetching an existing task for editing.
  // In a real application, this data would typically come from an API call.
  const [taskToEdit, setTaskToEdit] = useState(null);

  // useEffect hook to simulate an asynchronous data fetch.
  // This runs once when the component mounts.
  useEffect(() => {
    // Simulate an API call delay using setTimeout.
    setTimeout(() => {
      setTaskToEdit({
        id: 'task-123',
        title: "Review Q2 Financials",
        description: "Go through the quarterly financial reports and prepare a summary for the board meeting.",
        due_date: "2025-06-30",
        priority: "high",
      });
    }, 500); // 500ms delay to simulate network latency
  }, []); // Empty dependency array ensures this effect runs only once on mount

  return (
    // Main container for the application, ensuring it takes full screen height,
    // centers content, and applies a light gray background with Inter font.
    <div className="min-h-screen bg-gray-100 flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8 font-inter">
      {taskToEdit ? (
        // If taskToEdit data is available, render the EditTask component.
        <EditTask task={taskToEdit} />
      ) : (
        // Otherwise, display a loading message.
        <div className="text-gray-600 text-lg">Loading task details...</div>
      )}
    </div>
  );
};

// EditTask component for handling task editing functionality.
// It receives the 'task' object as a prop, which contains the initial data for the form.
const EditTask = ({ task }) => {
  // State to manage form data, initialized with the provided task prop.
  // This allows the form fields to be pre-filled with existing task details.
  const [formData, setFormData] = useState({
    title: task.title || "", // Use existing title or empty string
    description: task.description || "", // Use existing description or empty string
    due_date: task.due_date || "", // Use existing due_date or empty string
    priority: task.priority || "low", // Use existing priority or default to 'low'
  });

  // State to manage form validation errors. Errors are stored as an object
  // where keys are field names and values are error messages.
  const [errors, setErrors] = useState({});
  // State to manage the success message displayed after a successful form submission.
  const [success, setSuccess] = useState("");

  // useEffect hook to update formData if the 'task' prop changes.
  // This is crucial if the component might be reused to edit different tasks
  // without being unmounted and remounted.
  useEffect(() => {
    setFormData({
      title: task.title || "",
      description: task.description || "",
      due_date: task.due_date || "",
      priority: task.priority || "low",
    });
    setErrors({}); // Clear any previous validation errors when a new task is loaded
    setSuccess(""); // Clear any previous success messages
  }, [task]); // Dependency array includes 'task', so this effect runs whenever 'task' prop changes

  /**
   * Validates the current form data before submission.
   * Checks for required fields and constructs an object of error messages.
   * @returns {object} An object where keys are field names and values are corresponding error messages.
   */
  const validate = () => {
    const newErrors = {};
    // Validate 'title' field: it must not be empty after trimming whitespace.
    if (!formData.title.trim()) {
      newErrors.title = "Title is required";
    }
    // Validate 'priority' field: it must have a selected value.
    if (!formData.priority) {
      newErrors.priority = "Priority is required";
    }
    return newErrors;
  };

  /**
   * Handles changes to any form input or select element.
   * Updates the corresponding field in the formData state.
   * @param {Object} e - The event object from the input or select change.
   */
  const handleChange = (e) => {
    const { name, value } = e.target; // Destructure 'name' and 'value' from the event target
    setFormData((prev) => ({ ...prev, [name]: value })); // Update the specific field in formData
    // If there was an error for the field being changed, clear it immediately.
    if (errors[name]) {
      setErrors((prev) => ({ ...prev, [name]: undefined }));
    }
  };

  /**
   * Handles the form submission event.
   * Prevents default form submission, validates the data, and if valid,
   * simulates a successful update operation.
   * @param {Object} e - The event object from the form submission.
   */
  const handleSubmit = (e) => {
    e.preventDefault(); // Prevent the browser's default form submission behavior (page reload)
    setSuccess(""); // Clear any previous success messages before a new submission attempt

    const validationErrors = validate(); // Run validation on the current form data

    if (Object.keys(validationErrors).length > 0) {
      // If validation errors exist, update the errors state to display them.
      setErrors(validationErrors);
    } else {
      // If no validation errors, proceed with the simulated update.
      setErrors({}); // Clear all errors from previous attempts
      // In a real application, you would send this data to your backend API.
      // Example: fetch(`/api/tasks/${task.id}`, { method: 'PUT', body: JSON.stringify(formData) })
      console.log(`Updating task ${task.id} with data:`, formData); // Corrected string interpolation
      setSuccess("Task updated successfully!"); // Display a success message to the user
    }
  };

  return (
    // Main container for the edit task form, styled with Tailwind CSS for responsiveness and appearance.
    <div className="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow-lg border border-gray-200 w-full">
      <h2 className="text-3xl font-bold text-gray-800 mb-8 text-center">Edit Task</h2>

      {/* Success message display, conditionally rendered based on the 'success' state. */}
      {success && (
        <div className="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center font-medium border border-green-200">
          {success}
        </div>
      )}

      {/* The form element itself, with an onSubmit handler. */}
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
            className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out
                       placeholder-gray-400"
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
            className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out
                       resize-y placeholder-gray-400" // 'resize-y' allows vertical resizing
            placeholder="Provide a detailed description of the task..."
          />
          {/* Validation for description is not currently implemented in 'validate' function,
              but the error display is ready if it were to be added. */}
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
            className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
          />
          {/* Validation for due_date is not currently implemented in 'validate' function,
              but the error display is ready if it were to be added. */}
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
            className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
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
          className="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-md
                     transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2
                     focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-100"
        >
          Update Task
        </button>
      </form>
    </div>
  );
};

export default App;
