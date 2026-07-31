import React, { useState } from 'react';

const Sidebar = () => {
    const [navOpen, setNavOpen] = useState(false);

    const handleNavClick = (e) => {
        // Close the nav on mobile after clicking a link
        setNavOpen(false);
    };

    return (
        <div className="sidebar">
            <div className="sidebar-header">
                <img src="/img/bg.png" alt="Emmanuel Amadi - Full Stack & Mobile App Developer" />
            </div>
            <div className="sidebar-content">
                <nav className="navbar navbar-expand-md bg-dark navbar-dark">
                    <a href="#" className="navbar-brand">Navigation</a>
                    <button
                        type="button"
                        className="navbar-toggler"
                        onClick={() => setNavOpen(!navOpen)}
                        aria-expanded={navOpen}
                        aria-label="Toggle navigation"
                    >
                        <span className="navbar-toggler-icon"></span>
                    </button>
                    <div className={`collapse navbar-collapse${navOpen ? ' show' : ''}`} id="navbarCollapse">
                        <ul className="nav navbar-nav">
                            <li className="nav-item">
                                <a className="nav-link" href="#header" onClick={handleNavClick}>Home<i className="fa fa-home"></i></a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href="#about" onClick={handleNavClick}>About<i className="fa fa-address-card"></i></a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href="#experience" onClick={handleNavClick}>Experience<i className="fa fa-star"></i></a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href="#service" onClick={handleNavClick}>Service<i className="fa fa-tasks"></i></a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href="#portfolio" onClick={handleNavClick}>Portfolio<i className="fa fa-file-archive"></i></a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href="#contact" onClick={handleNavClick}>Contact<i className="fa fa-envelope"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div className="sidebar-footer">
                <a href="https://www.facebook.com/emmanuel.amadi.3760" target="_blank" rel="noreferrer"><i className="fab fa-facebook-f"></i></a>
                <a href="https://github.com/Emmzyben" target="_blank" rel="noreferrer"><i className="fab fa-github"></i></a>
                <a href="https://www.linkedin.com/in/emmanuel-amadi-486582234" target="_blank" rel="noreferrer"><i className="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    );
};

export default Sidebar;
