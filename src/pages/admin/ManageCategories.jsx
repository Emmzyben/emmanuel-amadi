import React, { useState, useEffect } from 'react';
import { ref, get, push, remove, update } from 'firebase/database';
import { db } from '../../config/firebase';

const ManageCategories = () => {
    const [categories, setCategories] = useState([]);
    const [loading, setLoading] = useState(true);
    const [formData, setFormData] = useState({ name: '', slug: '' });
    const [editingId, setEditingId] = useState(null);

    const fetchCategories = async () => {
        try {
            setLoading(true);
            const snapshot = await get(ref(db, 'categories'));
            if (snapshot.exists()) {
                const data = snapshot.val();
                const cats = Object.keys(data).map(key => ({ id: key, ...data[key] }));
                cats.sort((a, b) => (a.name || '').localeCompare(b.name || ''));
                setCategories(cats);
            } else {
                setCategories([]);
            }
        } catch (error) {
            console.error("Error fetching categories", error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchCategories();
    }, []);

    const handleInputChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            if (editingId) {
                await update(ref(db, `categories/${editingId}`), formData);
                setEditingId(null);
            } else {
                await push(ref(db, 'categories'), formData);
            }
            setFormData({ name: '', slug: '' });
            fetchCategories();
        } catch (error) {
            console.error("Error saving category", error);
        }
    };

    const handleEdit = (cat) => {
        setFormData({ name: cat.name, slug: cat.slug });
        setEditingId(cat.id);
    };

    const handleDelete = async (id) => {
        if (window.confirm("Are you sure you want to delete this category?")) {
            try {
                await remove(ref(db, `categories/${id}`));
                fetchCategories();
            } catch (error) {
                console.error("Error deleting category", error);
            }
        }
    };

    return (
        <div>
            <h2 className="admin-title">Manage Categories</h2>
            
            <div className="glass-card mb-5">
                <h5 className="mb-4" style={{color: '#222'}}>
                    {editingId ? 'Edit Category' : 'Add New Category'}
                </h5>
                <form onSubmit={handleSubmit}>
                    <div className="row g-3 align-items-end">
                        <div className="col-md-5">
                            <label className="glass-label">Category Name</label>
                            <input type="text" name="name" className="glass-input" placeholder="e.g. Web Development" value={formData.name} onChange={handleInputChange} required />
                        </div>
                        <div className="col-md-5">
                            <label className="glass-label">Slug</label>
                            <input type="text" name="slug" className="glass-input" placeholder="e.g. web-dev" value={formData.slug} onChange={handleInputChange} required />
                        </div>
                        <div className="col-md-2">
                            <button type="submit" className="btn-glass-primary w-100">
                                {editingId ? 'Update' : 'Save'}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {loading ? (
                <div className="d-flex justify-content-center py-5">
                    <div className="spinner-border text-primary" role="status"></div>
                </div>
            ) : (
                <div className="glass-table-wrapper">
                    <table className="glass-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th width="180">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {categories.length === 0 ? (
                                <tr><td colSpan="3" className="text-center py-4" style={{color: '#555'}}>No categories found.</td></tr>
                            ) : (
                                categories.map(cat => (
                                    <tr key={cat.id}>
                                        <td className="fw-500" style={{color: '#222'}}>{cat.name}</td>
                                        <td><span className="glass-badge">{cat.slug}</span></td>
                                        <td>
                                            <button className="btn-glass-info" onClick={() => handleEdit(cat)}>
                                                <i className="fa fa-edit"></i> Edit
                                            </button>
                                            <button className="btn-glass-danger" onClick={() => handleDelete(cat.id)}>
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

export default ManageCategories;
