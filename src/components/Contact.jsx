import React, { useState } from 'react';
import { ref, push } from 'firebase/database';
import { db } from '../config/firebase';

const Contact = () => {
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        subject: '',
        message: ''
    });
    const [status, setStatus] = useState('');

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const requestsRef = ref(db, 'contact_requests');
            await push(requestsRef, {
                ...formData,
                status: 'unread',
                created_at: new Date().toISOString()
            });
            setStatus('success');
            setFormData({ name: '', email: '', subject: '', message: '' });
        } catch (error) {
            console.error("Error submitting contact form", error);
            setStatus('error');
        }
    };

    return (
        <div className="contact" id="contact">
            <div className="content-inner">
                <div className="content-header">
                    <h2>Contact Me</h2>
                </div>
                <div className="row align-items-center">
                    <div className="col-md-6">
                        <div className="contact-info">
                            <p><i className="fa fa-user"></i>Emmanuel Amadi</p>
                            <p><i className="fa fa-tag"></i>Full Stack & Mobile App Developer</p>
                            <p><i className="fa fa-envelope"></i><a href="mailto:emmco96@gmail.com">emmco96@gmail.com</a></p>
                            <p><i className="fa fa-phone"></i><a href="tel:+2349056897432">+234 905 689 7432</a></p>
                            <p><i className="fa fa-map-marker"></i>Port Harcourt, Rivers State, Nigeria</p>
                            <div className="social">
                                <a className="btn" href="https://www.facebook.com/emmanuel.amadi.3760" target="_blank" rel="noreferrer"><i className="fab fa-facebook-f"></i></a>
                                <a href="https://github.com/Emmzyben" target="_blank" rel="noreferrer" className="btn"><i className="fab fa-github"></i></a>
                                <a className="btn" href="https://www.linkedin.com/in/emmanuel-amadi-486582234" target="_blank" rel="noreferrer"><i className="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="form">
                            {status === 'success' && (
                                <div className="alert alert-success">Message sent successfully! I will get back to you soon.</div>
                            )}
                            {status === 'error' && (
                                <div className="alert alert-danger">Failed to send message. Please try again.</div>
                            )}
                            
                            <form onSubmit={handleSubmit}>
                                <div className="form-row">
                                    <div className="form-group col-md-6">
                                        <input type="text" name="name" className="form-control" placeholder="Your Name" required value={formData.name} onChange={handleChange} />
                                    </div>
                                    <div className="form-group col-md-6">
                                        <input type="email" name="email" className="form-control" placeholder="Your Email" required value={formData.email} onChange={handleChange} />
                                    </div>
                                </div>
                                <div className="form-group">
                                    <input type="text" name="subject" className="form-control" placeholder="Subject" value={formData.subject} onChange={handleChange} />
                                </div>
                                <div className="form-group">
                                    <textarea name="message" className="form-control" rows="5" placeholder="Message" required value={formData.message} onChange={handleChange}></textarea>
                                </div>
                                <div><button className="btn" type="submit">Send Message</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Contact;
