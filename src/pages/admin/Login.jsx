import React, { useState, useEffect } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { ref, get } from 'firebase/database';
import { db } from '../../config/firebase';
import { useAuth } from '../../context/AuthContext';
import bcrypt from 'bcryptjs';
import '../../admin.css';

const Login = () => {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);
    
    const { login } = useAuth();
    const navigate = useNavigate();

    // Add class to body when mounted
    useEffect(() => {
        document.body.classList.add('admin-body');
        return () => {
            document.body.classList.remove('admin-body');
        };
    }, []);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError('');
        setLoading(true);

        try {
            const adminsRef = ref(db, 'admins');
            const snapshot = await get(adminsRef);
            
            if (snapshot.exists()) {
                const admins = snapshot.val();
                let foundAdmin = null;
                
                for (const key in admins) {
                    if (admins[key].username === username) {
                        foundAdmin = { id: key, ...admins[key] };
                        break;
                    }
                }
                
                if (foundAdmin) {
                    const isMatch = bcrypt.compareSync(password, foundAdmin.password);
                    
                    if (isMatch || foundAdmin.password === password) { 
                        login({ username: foundAdmin.username, id: foundAdmin.id });
                        navigate('/admin');
                    } else {
                        setError('Invalid credentials');
                    }
                } else {
                    setError('Invalid credentials');
                }
            } else {
                setError('No admin accounts configured');
            }
        } catch (err) {
            console.error(err);
            setError('Login failed. Ensure Firebase Database rules allow reading the admins node.');
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="login-wrapper">
            <div className="glass-panel login-box animate-slide-up">
                <div className="login-logo">
                    <i className="fa fa-lock"></i>
                </div>
                <h2 className="text-center mb-1 fw-bold" style={{color: '#222'}}>Welcome Back</h2>
                <p className="text-center mb-4 pb-2" style={{color: '#666'}}>Sign in to manage your portfolio</p>
                
                {error && <div className="alert alert-danger" style={{background: 'rgba(239, 68, 68, 0.1)', color: '#ef4444', border: '1px solid rgba(239, 68, 68, 0.2)', borderRadius: '12px'}}>{error}</div>}
                
                <form onSubmit={handleSubmit}>
                    <div className="mb-4">
                        <label className="glass-label">Username</label>
                        <input 
                            type="text" 
                            className="glass-input" 
                            placeholder="Enter your username"
                            value={username}
                            onChange={(e) => setUsername(e.target.value)}
                            required 
                        />
                    </div>
                    <div className="mb-4 pb-2">
                        <label className="glass-label">Password</label>
                        <input 
                            type="password" 
                            className="glass-input" 
                            placeholder="••••••••"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                            required 
                        />
                    </div>
                    <button type="submit" className="btn-glass-primary w-100" disabled={loading}>
                        {loading ? 'Authenticating...' : 'Sign In'}
                    </button>
                    
                    <div className="text-center mt-4">
                        <Link to="/" style={{color: '#FF6F61', textDecoration: 'none', fontWeight: '500', display: 'inline-flex', alignItems: 'center'}}>
                            <i className="fa fa-arrow-left me-2"></i> Back to Website
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default Login;
