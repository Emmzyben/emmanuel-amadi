import React, { useState, useEffect } from 'react';
import { ref, get, push, remove, update } from 'firebase/database';
import { db } from '../../config/firebase';

const ManageProjects = () => {
    const [projects, setProjects] = useState([]);
    const [categories, setCategories] = useState([]);
    const [loading, setLoading] = useState(true);
    const [formData, setFormData] = useState({ name: '', category_id: '', link: '', image: '' });
    const [editingId, setEditingId] = useState(null);
    const [uploading, setUploading] = useState(false);

    const fetchData = async () => {
        try {
            setLoading(true);
            const [catsSnap, projsSnap] = await Promise.all([
                get(ref(db, 'categories')),
                get(ref(db, 'projects'))
            ]);

            let catsList = [];
            if (catsSnap.exists()) {
                const data = catsSnap.val();
                catsList = Object.keys(data).map(key => ({ id: key, ...data[key] }));
                setCategories(catsList);
            }

            if (projsSnap.exists()) {
                const data = projsSnap.val();
                const projsList = Object.keys(data).map(key => ({ id: key, ...data[key] }));
                projsList.sort((a, b) => new Date(b.created_at || Date.now()) - new Date(a.created_at || Date.now()));
                setProjects(projsList);
            } else {
                setProjects([]);
            }
        } catch (error) {
            console.error("Error fetching data", error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchData();
    }, []);

    const handleInputChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleFileChange = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        setUploading(true);

        try {
            const formData = new FormData();
            formData.append('file', file);

            const response = await fetch('https://crystalsbusinesssolution.com/file_upload_api/upload.php', {
                method: 'POST',
                body: formData,
            });

            const responseText = await response.text();
            console.log('[upload] Raw response:', responseText.substring(0, 300));

            let result;
            try {
                result = JSON.parse(responseText);
            } catch (parseError) {
                throw new Error(`Invalid response from server: ${responseText.substring(0, 100)}`);
            }

            if (result.status !== 'success') {
                throw new Error(result.message || 'File upload failed');
            }

            const url = result.data.url;
            console.log('[upload] Success:', url);
            setFormData(prev => ({ ...prev, image: url }));

        } catch (error) {
            console.error('[upload] Error:', error);
            alert('Upload failed: ' + (error.message || 'Unknown error. You can paste an image URL manually.'));
        } finally {
            setUploading(false);
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const payload = { ...formData, created_at: new Date().toISOString() };
            if (editingId) {
                await update(ref(db, `projects/${editingId}`), payload);
                setEditingId(null);
            } else {
                await push(ref(db, 'projects'), payload);
            }
            setFormData({ name: '', category_id: '', link: '', image: '' });
            fetchData();
        } catch (error) {
            console.error("Error saving project", error);
        }
    };

    const handleEdit = (proj) => {
        setFormData({ name: proj.name, category_id: proj.category_id, link: proj.link, image: proj.image });
        setEditingId(proj.id);
    };

    const handleDelete = async (id) => {
        if (window.confirm("Are you sure you want to delete this project?")) {
            try {
                await remove(ref(db, `projects/${id}`));
                fetchData();
            } catch (error) {
                console.error("Error deleting project", error);
            }
        }
    };

    const getCategoryName = (id) => {
        const cat = categories.find(c => c.id === id);
        return cat ? cat.name : 'Unknown';
    };

    return (
        <div>
            <h2 className="admin-title">Manage Projects</h2>

            <div className="glass-card mb-5 mt-3 animate-slide-up">
                <h5 className="mb-4" style={{ color: '#222' }}>{editingId ? 'Edit Project' : 'Add New Project'}</h5>
                <form onSubmit={handleSubmit}>
                    <div className="row g-3 mb-4">
                        <div className="col-md-6">
                            <label className="glass-label">Project Name</label>
                            <input type="text" name="name" className="glass-input" placeholder="e.g. Portfolio Website" value={formData.name} onChange={handleInputChange} required />
                        </div>
                        <div className="col-md-6">
                            <label className="glass-label">Category</label>
                            <select name="category_id" className="glass-input" value={formData.category_id} onChange={handleInputChange} required style={{ appearance: 'none' }}>
                                <option value="">Select Category</option>
                                {categories.map(cat => (
                                    <option key={cat.id} value={cat.id}>{cat.name}</option>
                                ))}
                            </select>
                        </div>
                    </div>
                    <div className="row g-3 mb-4 align-items-end">
                        <div className="col-md-6">
                            <label className="glass-label">Project Link</label>
                            <input type="url" name="link" className="glass-input" placeholder="https://..." value={formData.link} onChange={handleInputChange} />
                        </div>
                        <div className="col-md-6">
                            <label className="glass-label">Image URL (or Upload)</label>
                            <div className="d-flex gap-2">
                                <input type="text" name="image" className="glass-input" placeholder="https://..." value={formData.image} onChange={handleInputChange} required />
                                <label className="btn-glass-info mb-0 d-flex align-items-center justify-content-center" style={{ cursor: 'pointer', whiteSpace: 'nowrap' }}>
                                    <i className="fa fa-upload me-2"></i> Upload
                                    <input type="file" hidden accept="image/*" onChange={handleFileChange} />
                                </label>
                            </div>
                            {uploading && <small style={{ color: '#03C4EB', marginTop: '8px', display: 'block' }}>Uploading image...</small>}
                        </div>
                    </div>
                    <div className="d-flex gap-2">
                        <button type="submit" className="btn-glass-primary" disabled={uploading}>
                            {editingId ? 'Update Project' : 'Add Project'}
                        </button>
                        {editingId && (
                            <button type="button" className="btn-glass-danger" style={{ border: 'none' }} onClick={() => { setEditingId(null); setFormData({ name: '', category_id: '', link: '', image: '' }) }}>Cancel</button>
                        )}
                    </div>
                </form>
            </div>

            {loading ? (
                <div className="d-flex justify-content-center py-5">
                    <div className="spinner-border text-primary" role="status"></div>
                </div>
            ) : (
                <div className="glass-table-wrapper animate-slide-up" style={{ animationDelay: '0.1s' }}>
                    <table className="glass-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Link</th>
                                <th width="180">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {projects.length === 0 ? (
                                <tr><td colSpan="5" className="text-center py-4" style={{ color: '#555' }}>No projects found.</td></tr>
                            ) : (
                                projects.map(proj => (
                                    <tr key={proj.id}>
                                        <td>
                                            {proj.image ? (
                                                <img src={proj.image.startsWith('http') ? proj.image : `/uploads/${proj.image}`} alt={proj.name} className="table-image" />
                                            ) : (
                                                <div className="table-image d-flex align-items-center justify-content-center" style={{ background: 'rgba(0,0,0,0.05)' }}>
                                                    <i className="fa fa-image text-muted"></i>
                                                </div>
                                            )}
                                        </td>
                                        <td className="fw-500" style={{ color: '#222' }}>{proj.name}</td>
                                        <td><span className="glass-badge">{getCategoryName(proj.category_id)}</span></td>
                                        <td>
                                            {proj.link && (
                                                <a href={proj.link} target="_blank" rel="noreferrer" style={{ color: '#03C4EB', textDecoration: 'none' }}>
                                                    <i className="fa fa-external-link-alt"></i> View
                                                </a>
                                            )}
                                        </td>
                                        <td>
                                            <button className="btn-glass-info" onClick={() => handleEdit(proj)}>
                                                <i className="fa fa-edit"></i> Edit
                                            </button>
                                            <button className="btn-glass-danger" onClick={() => handleDelete(proj.id)}>
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

export default ManageProjects;
