// Login.jsx
import React, { useState } from 'react';
import axios from 'axios';

export default function Login() {
  const [form, setForm] = useState({ email: '', password: '' });
  const [message, setMessage] = useState('');

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const res = await axios.post('http://127.0.0.1:8000/api/login', form, {
        withCredentials: true,
      });
      setMessage(res.data.message);
      console.log('Logged in user:', res.data.user);
    } catch (err) {
      setMessage(err.response?.data?.message || 'Login failed');
    }
  };

  return (
    <div className="p-4 max-w-md mx-auto bg-white rounded shadow">
      <h1 className="text-xl font-bold mb-4">Login</h1>
      <form onSubmit={handleSubmit}>
        <input type="email" name="email" placeholder="Email" className="w-full p-2 border mb-2" onChange={handleChange} />
        <input type="password" name="password" placeholder="Password" className="w-full p-2 border mb-2" onChange={handleChange} />
        <button type="submit" className="bg-blue-500 text-white px-4 py-2 rounded">Login</button>
      </form>
      <p className="mt-2 text-red-600">{message}</p>
    </div>
  );
}
