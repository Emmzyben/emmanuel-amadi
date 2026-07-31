import React, { useState, useEffect } from 'react';
import { ref, get, remove } from 'firebase/database';
import { db } from '../../config/firebase';

const ManageRequests = () => {
    const [requests, setRequests] = useState([]);
    const [loading, setLoading] = useState(true);

    const fetchRequests = async () => {
        try {
            setLoading(true);
            const snapshot = await get(ref(db, 'contact_requests'));
            if (snapshot.exists()) {
                const data = snapshot.val();
                const reqs = Object.keys(data).map(key => ({ id: key, ...data[key] }));
                reqs.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                setRequests(reqs);
            } else {
                setRequests([]);
            }
        } catch (error) {
            console.error("Error fetching requests", error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchRequests();
    }, []);

    const handleDelete = async (id) => {
        if (window.confirm("Are you sure you want to delete this request?")) {
            try {
                await remove(ref(db, `contact_requests/${id}`));
                fetchRequests();
            } catch (error) {
                console.error("Error deleting request", error);
            }
        }
    };

    return (
        <div>
            <h2 className="admin-title">Manage Contact Requests</h2>
            
            {loading ? (
                <div className="d-flex justify-content-center py-5">
                    <div className="spinner-border text-primary" role="status"></div>
                </div>
            ) : (
                <div className="glass-table-wrapper mt-4 animate-slide-up">
                    <table className="glass-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Contact Info</th>
                                <th>Message Details</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {requests.length === 0 ? (
                                <tr><td colSpan="5" className="text-center py-4" style={{color: '#555'}}>No requests found.</td></tr>
                            ) : (
                                requests.map(req => (
                                    <tr key={req.id}>
                                        <td style={{color: '#666', fontSize: '0.85rem'}}>
                                            {new Date(req.created_at).toLocaleDateString()}<br/>
                                            {new Date(req.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                        </td>
                                        <td className="fw-500" style={{color: '#222'}}>{req.name}</td>
                                        <td>
                                            <a href={`mailto:${req.email}`} style={{color: '#03C4EB', textDecoration: 'none'}}>
                                                <i className="fa fa-envelope me-1"></i> {req.email}
                                            </a>
                                        </td>
                                        <td>
                                            <div style={{fontWeight: '600', color: '#222', marginBottom: '4px'}}>{req.subject || 'No Subject'}</div>
                                            <div style={{
                                                maxHeight: '60px', 
                                                overflow: 'hidden', 
                                                textOverflow: 'ellipsis', 
                                                display: '-webkit-box', 
                                                WebkitLineClamp: 2, 
                                                WebkitBoxOrient: 'vertical',
                                                fontSize: '0.9rem',
                                                color: '#555'
                                            }} title={req.message}>
                                                {req.message}
                                            </div>
                                        </td>
                                        <td>
                                            <button className="btn-glass-danger" onClick={() => handleDelete(req.id)} title="Delete Request">
                                                <i className="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            )}
        </div>
    );
};

export default ManageRequests;
