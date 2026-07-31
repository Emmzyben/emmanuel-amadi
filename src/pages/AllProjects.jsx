import React, { useState, useEffect } from 'react';
import { ref, get } from 'firebase/database';
import { db } from '../config/firebase';

const AllProjects = () => {
    const [projects, setProjects] = useState([]);
    const [categories, setCategories] = useState([]);
    const [filter, setFilter] = useState('*');
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const catsRef = ref(db, 'categories');
                const projsRef = ref(db, 'projects');
                
                const [catsSnapshot, projsSnapshot] = await Promise.all([
                    get(catsRef),
                    get(projsRef)
                ]);

                let catsData = [];
                if (catsSnapshot.exists()) {
                    const data = catsSnapshot.val();
                    catsData = Object.keys(data).map(key => ({ id: key, ...data[key] }));
                    catsData.sort((a, b) => (a.name || '').localeCompare(b.name || ''));
                    setCategories(catsData);
                }

                if (projsSnapshot.exists()) {
                    const data = projsSnapshot.val();
                    let projsData = Object.keys(data).map(key => ({ id: key, ...data[key] }));
                    
                    const catMap = {};
                    catsData.forEach(c => { catMap[c.id] = c; });
                    
                    projsData = projsData.map(p => {
                        const c = catMap[p.category_id] || {};
                        return { ...p, category_name: c.name || '', category_slug: c.slug || '' };
                    });

                    projsData.sort((a, b) => new Date(b.created_at || Date.now()) - new Date(a.created_at || Date.now()));
                    setProjects(projsData);
                }
            } catch (error) {
                console.error("Error fetching portfolio data", error);
            } finally {
                setLoading(false);
            }
        };

        fetchData();
    }, []);

    const resolveMediaUrl = (url) => {
        if (!url) return '';
        if (url.startsWith('http')) return url;
        return `/uploads/${url.replace(/^\/+/, '')}`;
    };

    const filteredProjects = filter === '*' ? projects : projects.filter(p => p.category_slug === filter);

    return (
        <div className="wrapper">
            <div className="sidebar">
                <div className="sidebar-header">
                    <img src="/img/bg.png" alt="Emmanuel Amadi" />
                </div>
                <div className="sidebar-content">
                    <nav className="navbar navbar-expand-md bg-dark navbar-dark">
                        <div className="collapse navbar-collapse" id="navbarCollapse">
                            <ul className="nav navbar-nav">
                                <li className="nav-item">
                                    <a className="nav-link" href="/">Back to Home<i className="fa fa-arrow-left"></i></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            
            <div className="content">
                <div className="portfolio mt-5 pt-5" id="portfolio">
                    <div className="content-inner">
                        <div className="content-header">
                            <h2>All Projects</h2>
                        </div>
                        <div className="row">
                            <div className="col-lg-12">
                                <ul id="portfolio-flters">
                                    <li 
                                        className={filter === '*' ? 'filter-active' : ''} 
                                        onClick={() => setFilter('*')}
                                    >
                                        All
                                    </li>
                                    {categories.map(cat => (
                                        <li 
                                            key={cat.id} 
                                            className={filter === cat.slug ? 'filter-active' : ''}
                                            onClick={() => setFilter(cat.slug)}
                                        >
                                            {cat.name}
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </div>
                        <div className="row portfolio-container">
                            {loading ? (
                                <div className="col-12 text-center py-5">
                                    <p className="text-white">Loading projects...</p>
                                </div>
                            ) : filteredProjects.length === 0 ? (
                                <div className="col-12 text-center py-5">
                                    <p className="text-white">No projects found.</p>
                                </div>
                            ) : (
                                filteredProjects.map(proj => (
                                    <div key={proj.id} className={`col-lg-4 col-md-6 portfolio-item ${proj.category_slug}`}>
                                        <div className="portfolio-wrap">
                                            <figure>
                                                <img src={resolveMediaUrl(proj.image)} className="img-fluid" alt={proj.name} />
                                                <a href={resolveMediaUrl(proj.image)} data-lightbox="portfolio" data-title={proj.name} className="link-preview" title="Preview"><i className="fa fa-eye"></i></a>
                                            </figure>
                                            <div className="portfolio-info">
                                                <h4>{proj.name}</h4>
                                                <p>{proj.category_name}</p>
                                                <a href={proj.link} target="_blank" rel="noreferrer" className="btn-view">View Project <i className="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                ))
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default AllProjects;
