import React, { useEffect, useRef } from 'react';
import Typed from 'typed.js';

const Hero = () => {
    const typedRef = useRef(null);

    useEffect(() => {
        const typed = new Typed(typedRef.current, {
            strings: ['Web Designer', 'Web Developer', 'Front End Developer', 'Mobile App Developer'],
            typeSpeed: 100,
            backSpeed: 20,
            smartBackspace: false,
            loop: true,
        });

        return () => {
            typed.destroy();
        };
    }, []);

    return (
        <>
            <div className="header" id="header">
                <div className="content-inner">
                    <p>I'm</p>
                    <h1>Emmanuel Amadi</h1>
                    <h2 ref={typedRef}></h2>
                </div>
            </div>
            
            <div className="large-btn">
                <div className="content-inner">
                    <a className="btn" href="/img/resume.pdf" target="_blank" rel="noreferrer" download><i className="fa fa-download"></i>Resume</a>
                    <a className="btn" href="#contact"><i className="fa fa-hands-helping"></i>Hire Me</a>
                </div>
            </div>
        </>
    );
};

export default Hero;
