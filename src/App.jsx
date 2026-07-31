import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import Home from './pages/Home';
import AllProjects from './pages/AllProjects';
import { AdminLayout, DashboardHome } from './pages/admin/Dashboard';
import Login from './pages/admin/Login';
import ManageRequests from './pages/admin/ManageRequests';
import ManageCategories from './pages/admin/ManageCategories';
import ManageProjects from './pages/admin/ManageProjects';
import ManageReviews from './pages/admin/ManageReviews';
import { AuthProvider } from './context/AuthContext';

function App() {
  return (
    <AuthProvider>
      <Router>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/projects" element={<AllProjects />} />
          
          <Route path="/login" element={<Login />} />
          <Route path="/admin" element={<AdminLayout />}>
            <Route index element={<DashboardHome />} />
            <Route path="requests" element={<ManageRequests />} />
            <Route path="categories" element={<ManageCategories />} />
            <Route path="projects" element={<ManageProjects />} />
            <Route path="reviews" element={<ManageReviews />} />
          </Route>
          
          <Route path="*" element={<Navigate to="/" />} />
        </Routes>
      </Router>
    </AuthProvider>
  );
}

export default App;
