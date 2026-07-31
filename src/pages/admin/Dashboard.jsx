import React, { useEffect, useState } from 'react';
import { Link, Outlet, useNavigate, useLocation } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';
import '../../admin.css';

const AdminLayout = () => {
    const { currentUser, logout } = useAuth();
    const navigate = useNavigate();
    const location = useLocation();
    const [sidebarOpen, setSidebarOpen] = useState(false);

    useEffect(() => {
        document.body.classList.add('admin-body');
        return () => {
            document.body.classList.remove('admin-body');
        };
    }, []);

    // Close sidebar when route changes on mobile
    useEffect(() => {
        setSidebarOpen(false);
    }, [location.pathname]);

    const handleLogout = () => {
        logout();
        navigate('/login');
    };

    if (!currentUser) {
        navigate('/login');
        return null;
    }

    const isActive = (path) => location.pathname === path ? 'active' : '';

    return (
        <div className="admin-layout">
            {/* Hamburger button (mobile only) */}
            <button className="sidebar-toggle" onClick={() => setSidebarOpen(!sidebarOpen)}>
                <i className={`fa ${sidebarOpen ? 'fa-times' : 'fa-bars'}`}></i>
            </button>

            {/* Overlay for mobile */}
            <div className={`sidebar-overlay ${sidebarOpen ? 'open' : ''}`} onClick={() => setSidebarOpen(false)}></div>

            <div className={`admin-sidebar ${sidebarOpen ? 'open' : ''}`}>
                <div className="d-flex align-items-center mb-5 mt-2 px-2">
                    <div className="login-logo" style={{width: '40px', height: '40px', fontSize: '18px', margin: '0 15px 0 0', transform: 'rotate(0)'}}>
                        <i className="fa fa-layer-group"></i>
                    </div>
                    <h4 className="m-0 fw-bold" style={{color: '#222'}}>Admin Pro</h4>
                </div>
                
                <div className="d-flex flex-column flex-grow-1">
                    <Link className={`nav-link-glass ${isActive('/admin')}`} to="/admin">
                        <i className="fa fa-home"></i> Dashboard
                    </Link>
                    <Link className={`nav-link-glass ${isActive('/admin/categories')}`} to="/admin/categories">
                        <i className="fa fa-tags"></i> Categories
                    </Link>
                    <Link className={`nav-link-glass ${isActive('/admin/projects')}`} to="/admin/projects">
                        <i className="fa fa-briefcase"></i> Projects
                    </Link>
                    <Link className={`nav-link-glass ${isActive('/admin/reviews')}`} to="/admin/reviews">
                        <i className="fa fa-star"></i> Reviews
                    </Link>
                    <Link className={`nav-link-glass ${isActive('/admin/requests')}`} to="/admin/requests">
                        <i className="fa fa-envelope"></i> Requests
                    </Link>
                </div>
                
                <div className="mt-auto">
                    <div className="glass-card mb-3 d-flex align-items-center" style={{padding: '12px 16px'}}>
                        <div className="rounded-circle d-flex align-items-center justify-content-center me-3" style={{width: '36px', height: '36px', fontWeight: 'bold', background: '#FF6F61', color: '#fff'}}>
                            {currentUser.username.charAt(0).toUpperCase()}
                        </div>
                        <div>
                            <div style={{color: '#222', fontSize: '0.9rem', fontWeight: '700'}}>{currentUser.username}</div>
                            <div style={{color: '#666', fontSize: '0.75rem'}}>Administrator</div>
                        </div>
                    </div>
                    <button className="nav-link-glass w-100 text-start border-0 bg-transparent" onClick={handleLogout} style={{color: '#ef4444'}}>
                        <i className="fa fa-sign-out-alt" style={{color: '#ef4444'}}></i> Logout
                    </button>
                </div>
            </div>

            <div className="admin-main animate-slide-up">
                <Outlet />
            </div>
        </div>
    );
};

const DashboardHome = () => {
    const { currentUser } = useAuth();
    
    return (
        <div>
            <h1 className="admin-title">Dashboard Overview</h1>
            <p style={{color: '#555', fontSize: '1.1rem', marginBottom: '40px'}}>
                Welcome back, <strong>{currentUser.username}</strong>! Here is what's happening today.
            </p>
            
            <div className="row g-4">
                <div className="col-md-4">
                    <div className="glass-card h-100">
                        <div className="d-flex align-items-center justify-content-between mb-4">
                            <h5 className="m-0" style={{color: '#222', fontWeight: '600'}}>Projects</h5>
                            <div className="rounded p-2" style={{background: 'rgba(255, 111, 97, 0.15)', color: '#FF6F61'}}>
                                <i className="fa fa-briefcase"></i>
                            </div>
                        </div>
                        <h2 className="display-4 fw-bold mb-2" style={{color: '#222'}}>--</h2>
                        <p style={{color: '#666', fontSize: '0.9rem'}}>Total portfolio items</p>
                    </div>
                </div>
                <div className="col-md-4">
                    <div className="glass-card h-100">
                        <div className="d-flex align-items-center justify-content-between mb-4">
                            <h5 className="m-0" style={{color: '#222', fontWeight: '600'}}>Messages</h5>
                            <div className="rounded p-2" style={{background: 'rgba(3, 196, 235, 0.15)', color: '#03C4EB'}}>
                                <i className="fa fa-envelope"></i>
                            </div>
                        </div>
                        <h2 className="display-4 fw-bold mb-2" style={{color: '#222'}}>--</h2>
                        <p style={{color: '#666', fontSize: '0.9rem'}}>Contact requests</p>
                    </div>
                </div>
                <div className="col-md-4">
                    <div className="glass-card h-100">
                        <div className="d-flex align-items-center justify-content-between mb-4">
                            <h5 className="m-0" style={{color: '#222', fontWeight: '600'}}>Reviews</h5>
                            <div className="rounded p-2" style={{background: 'rgba(246, 209, 85, 0.3)', color: '#d97706'}}>
                                <i className="fa fa-star"></i>
                            </div>
                        </div>
                        <h2 className="display-4 fw-bold mb-2" style={{color: '#222'}}>--</h2>
                        <p style={{color: '#666', fontSize: '0.9rem'}}>Client testimonials</p>
                    </div>
                </div>
            </div>
        </div>
    );
};

export { AdminLayout, DashboardHome };
