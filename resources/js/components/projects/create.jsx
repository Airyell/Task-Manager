import React, { useState } from "react";

// Main App component to host the CreateProject component
const App = () => {
  return (
    <div className="min-h-screen bg-gray-100 flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
      <CreateProject />
    </div>
  );
};

// CreateProject component for handling project creation
const CreateProject = () => {
  // State to manage form data for name, description, start_date, end_date, and status
  const [formData, setFormData] = useState({
    name: "",
    description: "",
    start_date: "",
    end_date: "",
    status: "not_started", // Default status
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
    // Validate 'name' field: must not be empty
    if (!formData.name.trim()) {
      newErrors.name = "Name is required";
    }
    // Validate 'status' field: must not be empty
    if (!formData.status) {
      newErrors.status = "Status is required";
    }
    // Optional: Add more complex validation for dates if needed (e.g., end_date after start_date)
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
      setSuccess("Project created successfully!"); // Display success message
      console.log("Submitted project data:", formData); // Log the form data to console

      // Reset the form fields to their initial empty/default state
      setFormData({
        name: "",
        description: "",
        start_date: "",
        end_date: "",
        status: "not_started",
      });
    }
  };

  return (
    <div className="container mx-auto max-w-2xl">
      <h2 className="text-3xl font-bold text-gray-800 text-center mb-6 py-4 px-6 bg-white rounded-lg shadow-md">
        Create Project
      </h2>

      {/* Success message display, conditionally rendered */}
      {success && (
        <div className="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-center mb-6 w-full max-w-md mx-auto shadow-sm">
          {success}
        </div>
      )}

      <div className="bg-white rounded-lg shadow-xl p-6">
        <form onSubmit={handleSubmit} className="space-y-6">
          {/* Name Input Field */}
          <div>
            <label htmlFor="name" className="block text-sm font-semibold text-gray-700 mb-2">
              Name <span className="text-red-500">*</span> {/* Required indicator */}
            </label>
            <input
              type="text"
              name="name"
              id="name"
              value={formData.name}
              onChange={handleChange}
              className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 ease-in-out outline-none"
              required // HTML5 required attribute for basic client-side validation
              placeholder="e.g., New Website Development"
            />
            {/* Display validation error for name if it exists */}
            {errors.name && <p className="text-red-500 text-sm mt-2">{errors.name}</p>}
          </div>

          {/* Description Textarea Field */}
          <div>
            <label htmlFor="description" className="block text-sm font-semibold text-gray-700 mb-2">
              Description
            </label>
            <textarea
              name="description"
              id="description"
              value={formData.description}
              onChange={handleChange}
              rows="4" // Sets the visible height of the textarea
              className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 ease-in-out resize-y outline-none" // 'resize-y' allows vertical resizing
              placeholder="Provide a detailed description of the project..."
            />
            {/* Display validation error for description if it exists */}
            {errors.description && <p className="text-red-500 text-sm mt-2">{errors.description}</p>}
          </div>

          {/* Start Date Input Field */}
          <div>
            <label htmlFor="start_date" className="block text-sm font-semibold text-gray-700 mb-2">
              Start Date
            </label>
            <input
              type="date"
              name="start_date"
              id="start_date"
              value={formData.start_date}
              onChange={handleChange}
              className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 ease-in-out outline-none"
            />
            {/* Display validation error for start_date if it exists */}
            {errors.start_date && <p className="text-red-500 text-sm mt-2">{errors.start_date}</p>}
          </div>

          {/* End Date Input Field */}
          <div>
            <label htmlFor="end_date" className="block text-sm font-semibold text-gray-700 mb-2">
              End Date
            </label>
            <input
              type="date"
              name="end_date"
              id="end_date"
              value={formData.end_date}
              onChange={handleChange}
              className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 ease-in-out outline-none"
            />
            {/* Display validation error for end_date if it exists */}
            {errors.end_date && <p className="text-red-500 text-sm mt-2">{errors.end_date}</p>}
          </div>

          {/* Status Select Field */}
          <div>
            <label htmlFor="status" className="block text-sm font-semibold text-gray-700 mb-2">
              Status <span className="text-red-500">*</span> {/* Required indicator */}
            </label>
            <select
              name="status"
              id="status"
              value={formData.status}
              onChange={handleChange}
              className="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 ease-in-out outline-none bg-white"
              required // HTML5 required attribute
            >
              <option value="not_started">Not Started</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
            </select>
            {/* Display validation error for status if it exists */}
            {errors.status && <p className="text-red-500 text-sm mt-2">{errors.status}</p>}
          </div>

          {/* Submit Button */}
          <button
            type="submit"
            className="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          >
            Create Project
          </button>
        </form>
      </div>
    </div>
  );
};

export default App;