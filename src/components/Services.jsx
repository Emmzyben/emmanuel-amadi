import React from 'react';

const Services = () => {
    return (
        <div className="service" id="service">
            <div className="content-inner">
                <div className="content-header">
                    <h2>Service</h2>
                </div>
                <div className="row align-items-center">
                    <div className="col-md-6">
                        <div className="srv-col">
                            <i className="fa fa-code"></i>
                            <h3>Web Development</h3>
                            <p>Building responsive, high-performance, and scalable web applications using modern
                                technologies like React, Node.js, and PHP.</p>
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="srv-col">
                            <i className="fa fa-mobile-alt"></i>
                            <h3>Mobile App Development</h3>
                            <p>Developing custom cross-platform mobile applications for iOS and Android using React
                                Native Expo for a seamless user experience.</p>
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="srv-col">
                            <i className="fa fa-server"></i>
                            <h3>Backend & API Development</h3>
                            <p>Architecting robust server-side infrastructures and designing RESTful APIs that
                                provide secure and reliable data integration.</p>
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="srv-col">
                            <i className="fab fa-wordpress"></i>
                            <h3>WordPress & CMS Development</h3>
                            <p>Crafting professional, customizable, and easy-to-manage websites using WordPress and
                                other Content Management Systems.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Services;
