import React, { useState, useEffect } from "react";
import { Plus, Trash2, X, Edit } from 'lucide-react'; // Using Lucide React for icons

// Main App component to host the KanbanBoard
const App = () => {
  // Simulate project data and initial tasks across different statuses.
  const [project, setProject] = useState({ id: 'proj-1', name: "Website Redesign" });
  const [tasks, setTasks] = useState({
    to_do: [
      { id: 'task-1', title: "Design homepage mockups", description: "Create initial wireframes and high-fidelity designs.", due_date: "2025-06-15", priority: "high", user_id: 'user-1' },
      { id: 'task-2', title: "Set up development environment", description: "Install necessary tools and dependencies.", due_date: "2025-06-10", priority: "medium", user_id: 'user-2' },
    ],
    in_progress: [
      { id: 'task-3', title: "Develop navigation bar", description: "Implement responsive navigation with dropdowns.", due_date: "2025-06-20", priority: "high", user_id: 'user-1' },
    ],
    completed: [
      { id: 'task-4', title: "Initial project planning", description: "Defined scope and requirements.", due_date: "2025-05-30", priority: "low", user_id: 'user-2' },
    ],
  });
  // Simulate users for task assignment.
  const [users, setUsers] = useState([
    { id: 'user-1', name: 'Alice Smith' },
    { id: 'user-2', name: 'Bob Johnson' },
    { id: 'user-3', name: 'Charlie Brown' },
  ]);

  // State for success messages displayed to the user.
  const [successMessage, setSuccessMessage] = useState("");
  // State to control the visibility of the "Create Task" modal.
  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
  // State to hold the task currently being edited, and control the "Edit Task" modal.
  const [editingTask, setEditingTask] = useState(null);
  const [isEditModalOpen, setIsEditModalOpen] = useState(false);

  /**
   * Adds a new task to the specified status column.
   * @param {object} newTask - The new task object to add.
   */
  const addTask = (newTask) => {
    setTasks(prevTasks => ({
      ...prevTasks,
      // Add the new task with a unique ID to the correct status array.
      [newTask.status]: [...(prevTasks[newTask.status] || []), { ...newTask, id: `task-${Date.now()}` }]
    }));
    setSuccessMessage("Task created successfully!");
    setTimeout(() => setSuccessMessage(""), 3000); // Clear message after 3 seconds
  };

  /**
   * Updates the status of a task, moving it between columns (e.g., via drag and drop).
   * @param {string} taskId - The ID of the task to move.
   * @param {string} newStatus - The target status (column) for the task.
   */
  const updateTaskStatus = (taskId, newStatus) => {
    let taskToMove = null;
    let oldStatus = null;

    const updatedTasks = { ...tasks }; // Create a mutable copy of the tasks state

    // Iterate through existing statuses to find the task and its current column.
    for (const status in updatedTasks) {
      const index = updatedTasks[status].findIndex(task => task.id === taskId);
      if (index !== -1) {
        taskToMove = updatedTasks[status][index];
        oldStatus = status;
        updatedTasks[status].splice(index, 1); // Remove the task from its old column
        break;
      }
    }

    if (taskToMove) {
      // Add the task to its new column and update its status property.
      updatedTasks[newStatus] = [...(updatedTasks[newStatus] || []), { ...taskToMove, status: newStatus }];
      setTasks(updatedTasks); // Update the main tasks state
      console.log(`Simulating API call: Updating task ${taskId} to status ${newStatus}`);
    }
  };

  /**
   * Deletes a task from the specified column.
   * @param {string} taskId - The ID of the task to delete.
   * @param {string} status - The status (column) from which to delete the task.
   */
  const deleteTask = (taskId, status) => {
    setTasks(prevTasks => ({
      ...prevTasks,
      [status]: prevTasks[status].filter(task => task.id !== taskId) // Filter out the deleted task
    }));
    setSuccessMessage("Task deleted successfully!");
    setTimeout(() => setSuccessMessage(""), 3000); // Clear message after 3 seconds
    console.log(`Simulating API call: Deleting task ${taskId}`);
  };

  /**
   * Initiates the editing process for a specific task.
   * Opens the Edit Task modal and populates it with the task's current data.
   * @param {object} task - The task object to be edited.
   */
  const handleEditTask = (task) => {
    setEditingTask(task);
    setIsEditModalOpen(true);
  };

  /**
   * Saves the changes made to an edited task.
   * Finds the task in the state and updates its properties.
   * @param {object} updatedTaskData - The task object with updated data.
   */
  const saveEditedTask = (updatedTaskData) => {
    setTasks(prevTasks => {
      const newTasks = { ...prevTasks };
      // Find the task in its current column and update it.
      // Assuming task ID is unique across all columns for simplicity in this example.
      // In a real app, you might also need its original status to find it.
      for (const statusKey in newTasks) {
        const taskIndex = newTasks[statusKey].findIndex(t => t.id === updatedTaskData.id);
        if (taskIndex !== -1) {
          newTasks[statusKey][taskIndex] = { ...updatedTaskData, status: statusKey }; // Ensure status is correct
          break;
        }
      }
      return newTasks;
    });
    setSuccessMessage("Task updated successfully!");
    setTimeout(() => setSuccessMessage(""), 3000);
    setIsEditModalOpen(false); // Close the modal after saving
    setEditingTask(null); // Clear the editing task
    console.log(`Simulating API call: Saving task ${updatedTaskData.id}`, updatedTaskData);
  };

  return (
    // Main application container with Inter font applied.
    <div className="min-h-screen bg-gray-100 font-inter py-8">
      <div className="container mx-auto px-4">
        {/* Project Header and Success Message */}
        <div className="bg-white flex flex-col items-center mb-6 shadow-md p-4 rounded-lg">
          <h2 className="text-3xl font-bold text-gray-800 text-center mb-2">{project.name} - Tasks</h2>
          {successMessage && (
            <div className="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-center w-full max-w-md border border-green-200">
              {successMessage}
            </div>
          )}
        </div>

        {/* Kanban Columns Grid */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {/* To Do Column */}
          <KanbanColumn
            title="To Do"
            status="to_do"
            tasks={tasks.to_do || []}
            onDropTask={updateTaskStatus}
            onDeleteTask={deleteTask}
            onAddTask={addTask}
            onEditTask={handleEditTask} // Pass the edit handler
            users={users}
            accentColor="bg-blue-600"
            openCreateTaskModal={() => setIsCreateModalOpen(true)} // Pass handler for create modal
          />

          {/* In Progress Column */}
          <KanbanColumn
            title="In Progress"
            status="in_progress"
            tasks={tasks.in_progress || []}
            onDropTask={updateTaskStatus}
            onDeleteTask={deleteTask}
            onAddTask={addTask}
            onEditTask={handleEditTask} // Pass the edit handler
            users={users}
            accentColor="bg-yellow-600"
          />

          {/* Completed Column */}
          <KanbanColumn
            title="Completed"
            status="completed"
            tasks={tasks.completed || []}
            onDropTask={updateTaskStatus}
            onDeleteTask={deleteTask}
            onAddTask={addTask}
            onEditTask={handleEditTask} // Pass the edit handler
            users={users}
            accentColor="bg-green-600"
          />
        </div>

        {/* Create Task Modal (conditionally rendered) */}
        {isCreateModalOpen && (
          <CreateTaskModal
            onClose={() => setIsCreateModalOpen(false)}
            onAddTask={addTask}
            initialStatus="to_do" // New tasks are typically added to 'to_do'
            users={users}
          />
        )}

        {/* Edit Task Modal (conditionally rendered) */}
        {isEditModalOpen && editingTask && (
          <EditTaskModal
            task={editingTask}
            onSave={saveEditedTask}
            onClose={() => {
              setIsEditModalOpen(false);
              setEditingTask(null); // Clear editing task when modal closes
            }}
            users={users}
          />
        )}
      </div>
    </div>
  );
};

// KanbanColumn component displays a single column of tasks.
const KanbanColumn = ({ title, status, tasks, onDropTask, onDeleteTask, onAddTask, onEditTask, users, accentColor, openCreateTaskModal }) => {
  const [showDeleteConfirm, setShowDeleteConfirm] = useState(null); // Stores task ID for deletion confirmation

  /**
   * Prevents default behavior to allow dropping elements.
   * @param {Object} e - The drag event.
   */
  const handleDragOver = (e) => {
    e.preventDefault();
  };

  /**
   * Handles dropping a draggable task item into this column.
   * Retrieves the task ID from the dataTransfer object and updates its status.
   * @param {Object} e - The drop event.
   */
  const handleDrop = (e) => {
    e.preventDefault();
    const taskId = e.dataTransfer.getData('text/plain');
    onDropTask(taskId, status); // Call parent function to update task status
  };

  /**
   * Sets the task ID for which a delete confirmation is needed.
   * @param {string} taskId - The ID of the task to confirm deletion for.
   */
  const handleDeleteClick = (taskId) => {
    setShowDeleteConfirm(taskId);
  };

  /**
   * Confirms and proceeds with deleting the task.
   * @param {string} taskIdToDelete - The ID of the task to delete.
   */
  const confirmDelete = (taskIdToDelete) => {
    onDeleteTask(taskIdToDelete, status);
    setShowDeleteConfirm(null); // Close confirmation modal
  };

  /**
   * Cancels the delete operation and closes the confirmation modal.
   */
  const cancelDelete = () => {
    setShowDeleteConfirm(null);
  };

  return (
    <div className="kanban-column bg-gray-50 p-4 rounded-lg shadow-md h-full flex flex-col">
      {/* Column Header */}
      <div className={`flex justify-between items-center ${accentColor} text-white shadow-sm px-4 py-3 rounded-t-lg mb-3`}>
        <h4 className="text-xl font-extrabold m-0">{title}</h4>
        {status === 'to_do' && ( // Only show add button for 'To Do' column
          <button
            type="button"
            className="p-2 bg-white text-gray-800 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-white transition-colors duration-200"
            onClick={openCreateTaskModal} // Use the passed handler
            aria-label={`Add new task to ${title}`}
          >
            <Plus size={20} />
          </button>
        )}
      </div>
      {/* Task List Area */}
      <div
        className="kanban-list flex-grow min-h-[500px] bg-gray-200 rounded-b-lg p-3 space-y-3 overflow-y-auto"
        onDragOver={handleDragOver}
        onDrop={handleDrop}
      >
        {tasks.length === 0 && (
          <p className="text-gray-500 text-center py-4">No tasks in this column.</p>
        )}
        {tasks.map((task) => (
          <KanbanItem
            key={task.id}
            task={task}
            onDeleteClick={handleDeleteClick}
            onEditClick={onEditTask} // Pass the edit handler to KanbanItem
            users={users} // Pass users to KanbanItem to display assignee name
          />
        ))}
      </div>

      {/* Delete Confirmation Modal (conditionally rendered) */}
      {showDeleteConfirm && (
        <ConfirmationModal
          message={`Are you sure you want to delete "${tasks.find(t => t.id === showDeleteConfirm)?.title}"?`}
          onConfirm={() => confirmDelete(showDeleteConfirm)}
          onCancel={cancelDelete}
        />
      )}
    </div>
  );
};

// KanbanItem component represents a single task card.
const KanbanItem = ({ task, onDeleteClick, onEditClick, users }) => {
  /**
   * Sets the data to be transferred during a drag operation and adds a visual cue.
   * @param {Object} e - The drag event.
   */
  const handleDragStart = (e) => {
    e.dataTransfer.setData('text/plain', task.id);
    e.currentTarget.classList.add('opacity-40'); // Make dragged item semi-transparent
  };

  /**
   * Removes the visual cue when the drag operation ends.
   * @param {Object} e - The drag event.
   */
  const handleDragEnd = (e) => {
    e.currentTarget.classList.remove('opacity-40');
  };

  /**
   * Returns Tailwind CSS classes for priority badges based on priority level.
   * @param {string} priority - The priority level ('low', 'medium', 'high').
   * @returns {string} Tailwind CSS classes.
   */
  const getPriorityBadgeClass = (priority) => {
    switch (priority) {
      case 'low': return 'bg-green-500';
      case 'medium': return 'bg-yellow-500';
      case 'high': return 'bg-red-500';
      default: return 'bg-gray-500';
    }
  };

  // Find the assigned user's name
  const assignedUser = users.find(user => user.id === task.user_id);

  return (
    <div
      className="bg-white p-4 rounded-lg shadow-sm cursor-grab active:cursor-grabbing border border-gray-200 hover:shadow-md transition-shadow duration-200"
      draggable="true"
      onDragStart={handleDragStart}
      onDragEnd={handleDragEnd}
    >
      <h5 className="flex justify-between items-start text-lg font-semibold text-gray-800 mb-2">
        <span>{task.title}</span>
        <span className={`px-2 py-1 text-xs font-bold text-white rounded-full ${getPriorityBadgeClass(task.priority)}`}>
          {task.priority.charAt(0).toUpperCase() + task.priority.slice(1)}
        </span>
      </h5>
      <p className="text-gray-600 text-sm mb-3">{task.description}</p>
      {task.due_date && (
        <p className="text-gray-500 text-xs mb-1">Due: {task.due_date}</p>
      )}
      {assignedUser && (
        <p className="text-gray-500 text-xs mb-3">Assigned: {assignedUser.name}</p>
      )}
      <div className="flex justify-end gap-2">
        {/* Edit Button */}
        <button
          type="button"
          className="p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          onClick={() => onEditClick(task)} // Call edit handler with the task object
          aria-label={`Edit task ${task.title}`}
        >
          <Edit size={16} />
        </button>
        {/* Delete Button */}
        <button
          type="button"
          className="p-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
          onClick={() => onDeleteClick(task.id)}
          aria-label={`Delete task ${task.title}`}
        >
          <Trash2 size={16} />
        </button>
      </div>
    </div>
  );
};

// Create Task Modal Component for adding new tasks.
const CreateTaskModal = ({ onClose, onAddTask, initialStatus, users }) => {
  const [formData, setFormData] = useState({
    title: "",
    description: "",
    due_date: "",
    priority: "low",
    status: initialStatus, // Pre-fill status based on the column from which the modal was opened
    user_id: '', // For assignment
  });
  const [errors, setErrors] = useState({});

  /**
   * Handles changes to form input fields and updates the formData state.
   * Clears associated validation errors when a field is changed.
   * @param {Object} e - The event object from the input change.
   */
  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
    if (errors[name]) {
      setErrors((prev) => ({ ...prev, [name]: undefined }));
    }
  };

  /**
   * Validates the form data before submission.
   * @returns {object} An object containing validation error messages.
   */
  const validate = () => {
    const newErrors = {};
    if (!formData.title.trim()) newErrors.title = "Title is required";
    if (!formData.priority) newErrors.priority = "Priority is required";
    return newErrors;
  };

  /**
   * Handles the form submission for creating a new task.
   * Validates data and calls the onAddTask callback if valid.
   * @param {Object} e - The form submission event.
   */
  const handleSubmit = (e) => {
    e.preventDefault();
    const validationErrors = validate();
    if (Object.keys(validationErrors).length > 0) {
      setErrors(validationErrors);
    } else {
      onAddTask(formData);
      onClose(); // Close modal on successful addition
    }
  };

  return (
    // Modal overlay and container
    <div className="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4 font-inter">
      <div className="bg-white rounded-lg shadow-xl w-full max-w-md mx-auto transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <form onSubmit={handleSubmit}>
          {/* Modal Header */}
          <div className="flex justify-between items-center px-6 py-4 border-b border-gray-200">
            <h5 className="text-xl font-semibold text-gray-900">Create Task</h5>
            <button
              type="button"
              className="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100 transition-colors"
              onClick={onClose}
              aria-label="Close modal"
            >
              <X size={24} />
            </button>
          </div>
          {/* Modal Body - Form Fields */}
          <div className="p-6 space-y-4">
            <div>
              <label htmlFor="modal-create-title" className="block text-sm font-medium text-gray-700 mb-1">
                Title <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                name="title"
                id="modal-create-title"
                value={formData.title}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                required
              />
              {errors.title && <p className="text-red-500 text-sm mt-1">{errors.title}</p>}
            </div>
            <div>
              <label htmlFor="modal-create-description" className="block text-sm font-medium text-gray-700 mb-1">
                Description
              </label>
              <textarea
                name="description"
                id="modal-create-description"
                value={formData.description}
                onChange={handleChange}
                rows="3"
                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 resize-y"
              />
              {errors.description && <p className="text-red-500 text-sm mt-1">{errors.description}</p>}
            </div>
            <div>
              <label htmlFor="modal-create-due_date" className="block text-sm font-medium text-gray-700 mb-1">
                Due Date
              </label>
              <input
                type="date"
                name="due_date"
                id="modal-create-due_date"
                value={formData.due_date}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              />
              {errors.due_date && <p className="text-red-500 text-sm mt-1">{errors.due_date}</p>}
            </div>
            <div>
              <label htmlFor="modal-create-priority" className="block text-sm font-medium text-gray-700 mb-1">
                Priority <span className="text-red-500">*</span>
              </label>
              <select
                name="priority"
                id="modal-create-priority"
                value={formData.priority}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                required
              >
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
              </select>
              {errors.priority && <p className="text-red-500 text-sm mt-1">{errors.priority}</p>}
            </div>
            <div>
              <label htmlFor="modal-create-user_id" className="block text-sm font-medium text-gray-700 mb-1">
                Assign To
              </label>
              <select
                name="user_id"
                id="modal-create-user_id"
                value={formData.user_id}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              >
                <option value="">Select User</option> {/* Added a default empty option */}
                {users.map(user => (
                  <option key={user.id} value={user.id}>{user.name}</option>
                ))}
              </select>
              {errors.user_id && <p className="text-red-500 text-sm mt-1">{errors.user_id}</p>}
            </div>
            {/* Hidden input to retain initial status if needed, though it's set in formData */}
            <input type="hidden" name="status" value={formData.status} />
          </div>
          {/* Modal Footer - Buttons */}
          <div className="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-lg">
            <button
              type="button"
              className="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors duration-200"
              onClick={onClose}
            >
              Cancel
            </button>
            <button
              type="submit"
              className="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200"
            >
              Create Task
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};


// Edit Task Modal Component for editing existing tasks.
// This component wraps the core EditTaskForm.
const EditTaskModal = ({ task, onSave, onClose, users }) => {
  return (
    // Modal overlay and container
    <div className="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4 font-inter">
      <div className="bg-white rounded-lg shadow-xl w-full max-w-md mx-auto transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div className="flex justify-between items-center px-6 py-4 border-b border-gray-200">
          <h5 className="text-xl font-semibold text-gray-900">Edit Task</h5>
          <button
            type="button"
            className="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100 transition-colors"
            onClick={onClose}
            aria-label="Close modal"
          >
            <X size={24} />
          </button>
        </div>
        {/* Render the core EditTaskForm component inside the modal */}
        <EditTaskForm
          task={task}
          onSave={onSave}
          onClose={onClose}
          users={users}
        />
      </div>
    </div>
  );
};

// EditTaskForm component contains the actual form for editing a task.
const EditTaskForm = ({ task, onSave, onClose, users }) => {
  // State to manage form data, initialized with the provided task prop.
  const [formData, setFormData] = useState({
    id: task.id, // Keep the task ID for identification during save
    title: task.title || "",
    description: task.description || "",
    due_date: task.due_date || "",
    priority: task.priority || "low",
    status: task.status, // Keep the original status
    user_id: task.user_id || '', // Initialize with existing user_id
  });

  // State to manage form validation errors
  const [errors, setErrors] = useState({});

  // Effect to update formData if the 'task' prop changes
  useEffect(() => {
    setFormData({
      id: task.id,
      title: task.title || "",
      description: task.description || "",
      due_date: task.due_date || "",
      priority: task.priority || "low",
      status: task.status,
      user_id: task.user_id || '',
    });
    setErrors({}); // Clear errors when task changes
  }, [task]);

  /**
   * Validates the form data before submission.
   * Checks for required fields and sets appropriate error messages.
   * @returns {object} An object where keys are field names and values are error messages.
   */
  const validate = () => {
    const newErrors = {};
    if (!formData.title.trim()) {
      newErrors.title = "Title is required";
    }
    if (!formData.priority) {
      newErrors.priority = "Priority is required";
    }
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
    if (errors[name]) {
      setErrors((prev) => ({ ...prev, [name]: undefined }));
    }
  };

  /**
   * Handles the form submission event.
   * Prevents default form submission, validates the data, and if valid,
   * calls the onSave callback.
   * @param {Object} e - The event object from the form submission.
   */
  const handleSubmit = (e) => {
    e.preventDefault();
    const validationErrors = validate();

    if (Object.keys(validationErrors).length > 0) {
      setErrors(validationErrors);
    } else {
      setErrors({}); // Clear all errors
      onSave(formData); // Call the parent's save function
    }
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4 p-6">
      {/* Title Input Field */}
      <div>
        <label htmlFor="edit-title" className="block text-sm font-medium text-gray-700 mb-1">
          Title <span className="text-red-500">*</span>
        </label>
        <input
          type="text"
          id="edit-title"
          name="title"
          value={formData.title}
          onChange={handleChange}
          required
          className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="e.g., Complete project proposal"
        />
        {errors.title && <p className="text-red-500 text-sm mt-1">{errors.title}</p>}
      </div>

      {/* Description Textarea Field */}
      <div>
        <label htmlFor="edit-description" className="block text-sm font-medium text-gray-700 mb-1">
          Description
        </label>
        <textarea
          id="edit-description"
          name="description"
          value={formData.description}
          onChange={handleChange}
          rows="3"
          className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 resize-y"
          placeholder="Provide a detailed description of the task..."
        />
        {errors.description && <p className="text-red-500 text-sm mt-1">{errors.description}</p>}
      </div>

      {/* Due Date Input Field */}
      <div>
        <label htmlFor="edit-due_date" className="block text-sm font-medium text-gray-700 mb-1">
          Due Date
        </label>
        <input
          type="date"
          id="edit-due_date"
          name="due_date"
          value={formData.due_date}
          onChange={handleChange}
          className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        />
        {errors.due_date && <p className="text-red-500 text-sm mt-1">{errors.due_date}</p>}
      </div>

      {/* Priority Select Field */}
      <div>
        <label htmlFor="edit-priority" className="block text-sm font-medium text-gray-700 mb-1">
          Priority <span className="text-red-500">*</span>
        </label>
        <select
          id="edit-priority"
          name="priority"
          value={formData.priority}
          onChange={handleChange}
          required
          className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        >
          <option value="low">Low</option>
          <option value="medium">Medium</option>
          <option value="high">High</option>
        </select>
        {errors.priority && <p className="text-red-500 text-sm mt-1">{errors.priority}</p>}
      </div>

      {/* Assign To Select Field */}
      <div>
        <label htmlFor="edit-user_id" className="block text-sm font-medium text-gray-700 mb-1">
          Assign To
        </label>
        <select
          name="user_id"
          id="edit-user_id"
          value={formData.user_id}
          onChange={handleChange}
          className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        >
          <option value="">Select User</option>
          {users.map(user => (
            <option key={user.id} value={user.id}>{user.name}</option>
          ))}
        </select>
        {errors.user_id && <p className="text-red-500 text-sm mt-1">{errors.user_id}</p>}
      </div>

      {/* Form Buttons */}
      <div className="flex justify-end gap-3 pt-2">
        <button
          type="button"
          className="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors duration-200"
          onClick={onClose}
        >
          Cancel
        </button>
        <button
          type="submit"
          className="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200"
        >
          Save Changes
        </button>
      </div>
    </form>
  );
};


// Confirmation Modal Component (replaces browser's confirm())
const ConfirmationModal = ({ message, onConfirm, onCancel }) => {
  return (
    <div className="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4 font-inter">
      <div className="bg-white rounded-lg shadow-xl w-full max-w-sm mx-auto transform transition-all">
        <div className="p-6">
          <p className="text-lg font-semibold text-gray-900 mb-4">{message}</p>
          <div className="flex justify-end gap-3">
            <button
              type="button"
              className="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors duration-200"
              onClick={onCancel}
            >
              Cancel
            </button>
            <button
              type="button"
              className="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors duration-200"
              onClick={onConfirm}
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default App;
