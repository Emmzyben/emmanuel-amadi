import React from 'react';
import Sidebar from '../components/Sidebar';
import Hero from '../components/Hero';
import About from '../components/About';
import Education from '../components/Education';
import Experience from '../components/Experience';
import Services from '../components/Services';
import Portfolio from '../components/Portfolio';
import Reviews from '../components/Reviews';
import Contact from '../components/Contact';

const Home = () => {
    return (
        <div className="wrapper">
            <Sidebar />
            <div className="content">
                <Hero />
                <About />
                <Education />
                <Experience />
                <Services />
                <Portfolio />
                <Reviews />
                <Contact />
                
                <div className="footer">
                    <div className="content-inner">
                        <div className="row align-items-center">
                            <div className="col-md-12">
                                <p>&copy; Copyright {new Date().getFullYear()} Emmanuel Amadi, All Rights Reserved</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <a href="https://wa.me/2349056897432?text=Hello%20Emmanuel,%20I%20am%20interested%20in%20your%20services." className="whatsapp-widget" target="_blank" rel="noreferrer">
                <i className="fab fa-whatsapp"></i>
            </a>
            
            <a href="#" className="back-to-top"><i className="fa fa-angle-double-up"></i></a>
        </div>
    );
};

export default Home;
