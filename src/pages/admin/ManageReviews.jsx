import React, { useState, useEffect } from 'react';
import { ref, get, push, remove, update } from 'firebase/database';
import { db } from '../../config/firebase';

const ManageReviews = () => {
    const [reviews, setReviews] = useState([]);
    const [loading, setLoading] = useState(true);
    const [formData, setFormData] = useState({ reviewer_name: '', location: '', review_text: '' });
    const [editingId, setEditingId] = useState(null);

    const fetchReviews = async () => {
        try {
            setLoading(true);
            const snapshot = await get(ref(db, 'reviews'));
            if (snapshot.exists()) {
                const data = snapshot.val();
                const revs = Object.keys(data).map(key => ({ id: key, ...data[key] }));
                revs.sort((a, b) => new Date(b.created_at || Date.now()) - new Date(a.created_at || Date.now()));
                setReviews(revs);
            } else {
                setReviews([]);
            }
        } catch (error) {
            console.error("Error fetching reviews", error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchReviews();
    }, []);

    const handleInputChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const payload = { ...formData, created_at: new Date().toISOString() };
            if (editingId) {
                await update(ref(db, `reviews/${editingId}`), payload);
                setEditingId(null);
            } else {
                await push(ref(db, 'reviews'), payload);
            }
            setFormData({ reviewer_name: '', location: '', review_text: '' });
            fetchReviews();
        } catch (error) {
            console.error("Error saving review", error);
        }
    };

    const handleEdit = (rev) => {
        setFormData({ reviewer_name: rev.reviewer_name, location: rev.location, review_text: rev.review_text });
        setEditingId(rev.id);
    };

    const handleDelete = async (id) => {
        if (window.confirm("Are you sure you want to delete this review?")) {
            try {
                await remove(ref(db, `reviews/${id}`));
                fetchReviews();
            } catch (error) {
                console.error("Error deleting review", error);
            }
        }
    };

    return (
        <div>
            <h2 className="admin-title">Manage Reviews</h2>
            
            <div className="glass-card mb-5 mt-3 animate-slide-up">
                <h5 className="mb-4" style={{color: '#222'}}>{editingId ? 'Edit Review' : 'Add New Review'}</h5>
                <form onSubmit={handleSubmit}>
                    <div className="row g-3 mb-4">
                        <div className="col-md-6">
                            <label className="glass-label">Reviewer Name</label>
                            <input type="text" name="reviewer_name" className="glass-input" placeholder="e.g. John Doe" value={formData.reviewer_name} onChange={handleInputChange} required />
                        </div>
                        <div className="col-md-6">
                            <label className="glass-label">Location / Role</label>
                            <input type="text" name="location" className="glass-input" placeholder="e.g. CEO at Company" value={formData.location} onChange={handleInputChange} required />
                        </div>
                    </div>
                    <div className="mb-4">
                        <label className="glass-label">Review Text</label>
                        <textarea name="review_text" className="glass-input" rows="4" placeholder="What did they say?" value={formData.review_text} onChange={handleInputChange} required></textarea>
                    </div>
                    <div className="d-flex gap-2">
                        <button type="submit" className="btn-glass-primary">
                            {editingId ? 'Update Review' : 'Add Review'}
                        </button>
                        {editingId && (
                            <button type="button" className="btn-glass-danger" style={{border: 'none'}} onClick={() => { setEditingId(null); setFormData({ reviewer_name: '', location: '', review_text: '' }) }}>Cancel</button>
                        )}
                    </div>
                </form>
            </div>

            {loading ? (
                <div className="d-flex justify-content-center py-5">
                    <div className="spinner-border text-primary" role="status"></div>
                </div>
            ) : (
                <div className="glass-table-wrapper animate-slide-up" style={{animationDelay: '0.1s'}}>
                    <table className="glass-table">
                        <thead>
                            <tr>
                                <th>Reviewer</th>
                                <th>Location</th>
                                <th>Review</th>
                                <th width="180">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {reviews.length === 0 ? (
                                <tr><td colSpan="4" className="text-center py-4" style={{color: '#555'}}>No reviews found.</td></tr>
                            ) : (
                                reviews.map(rev => (
                                    <tr key={rev.id}>
                                        <td className="fw-500" style={{color: '#222'}}>{rev.reviewer_name}</td>
                                        <td><span className="glass-badge">{rev.location}</span></td>
                                        <td>
                                            <div style={{
                                                maxHeight: '60px', 
                                                overflow: 'hidden', 
                                                textOverflow: 'ellipsis', 
                                                display: '-webkit-box', 
                                                WebkitLineClamp: 2, 
                                                WebkitBoxOrient: 'vertical',
                                                color: '#555'
                                            }} title={rev.review_text}>
                                                "{rev.review_text}"
                                            </div>
                                        </td>
                                        <td>
                                            <button className="btn-glass-info" onClick={() => handleEdit(rev)}>
                                                <i className="fa fa-edit"></i> Edit
                                            </button>
                                            <button className="btn-glass-danger" onClick={() => handleDelete(rev.id)}>
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

export default ManageReviews;
