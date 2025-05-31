import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter, Routes, Route } from 'react-router-dom';

import Dashboard from './components/dashboard';
import Login from './components/auth/Login';
import Register from './components/auth/Register';
import Layout from './components/layouts/app';
import Notes from './components/notes/index';
import CreateNote from './components/notes/create';
import EditNote from './components/notes/edit';
import EditProfile from './components/profile/edit';
import UserProfile from './components/profile/index';
import ShowProfile from './components/profile/show';
import ProjectDetails from './components/projects/show';
import Projects from './components/projects/index';
import EditProject from './components/projects/edit';
import CreateP from './components/projects/create';
import TaskDetails from './components/tasks/show';
import TasksI from './components/tasks/index';
import TasksE from './components/tasks/edit';
import CreateTask from './components/tasks/create';
import ActivityHistory from './components/auth/history/Index';




const App = () => (
  <BrowserRouter>
    <Routes>
      <Route path="/dashboard" element={<Dashboard />} />
      <Route path="/login" element={<Login />} />
      <Route path="/register" element={<Register />} />
      <Route path="/app" element={<Layout />} />
      <Route path="/notes/index" element={<Notes />} />
      <Route path="/notes/create" element={<CreateNote />} />
      <Route path="/notes/edit" element={<EditNote />} />
      <Route path="/profile/edit" element={<EditProfile />} />
      <Route path="/profile/index" element={<UserProfile />} />
      <Route path="/profile/show" element={<ShowProfile />} />
      <Route path="/projects/show" element={<ProjectDetails />} />
      <Route path="/projects/index" element={<Projects />} />
      <Route path="/projects/edit" element={<EditProject />} />
      <Route path="/projects/create" element={<CreateP />} />
      <Route path="/tasks/show" element={<TaskDetails />} />
      <Route path="/tasks/index" element={<TasksI />} />
      <Route path="/tasks/edit" element={<TasksE />} />
      <Route path="/tasks/create" element={<CreateTask />} />
      <Route path="/auth/history/history" element={<ActivityHistory />} />
    </Routes>
  </BrowserRouter>
);

ReactDOM.createRoot(document.getElementById('app')).render(<App />);

export default App;
