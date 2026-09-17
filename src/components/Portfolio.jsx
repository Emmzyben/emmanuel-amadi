import React, { useState, useEffect } from 'react';
import { ref, get } from 'firebase/database';
import { db } from '../config/firebase';

const Portfolio = () => {
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
                    // Sort categories by name
                    catsData.sort((a, b) => (a.name || '').localeCompare(b.name || ''));
                    setCategories(catsData);
                }

                if (projsSnapshot.exists()) {
                    const data = projsSnapshot.val();
                    let projsData = Object.keys(data).map(key => ({ id: key, ...data[key] }));
                    
                    // Add category info to projects
                    const catMap = {};
                    catsData.forEach(c => { catMap[c.id] = c; });
                    
                    projsData = projsData.map(p => {
                        const c = catMap[p.category_id] || {};
                        return { ...p, category_name: c.name || '', category_slug: c.slug || '' };
                    });

                    // Sort by created_at asc (oldest first, newest last)
                    projsData.sort((a, b) => new Date(a.created_at || 0) - new Date(b.created_at || 0));
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
        <div className="portfolio" id="portfolio">
            <div className="content-inner">
                <div className="content-header">
                    <h2>Portfolio</h2>
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
                            <p className="text-white">No projects published yet.</p>
                        </div>
                    ) : (
                        filteredProjects.slice(0, 6).map(proj => (
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
                <div className="col-12 text-center mt-5">
                    <a href="/projects" className="btn" style={{background: '#FF6F61', color: '#ffffff', borderRadius: 0, padding: '12px 30px', fontWeight: 700}}>View All Projects</a>
                </div>
            </div>
        </div>
    );
};

export default Portfolio;
