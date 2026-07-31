<!-- Contact Start -->
<div class="contact" id="contact">
    <div class="content-inner">
        <div class="content-header">
            <h2>Contact Me</h2>
        </div>
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="contact-info">
                    <p><i class="fa fa-user"></i>Emmanuel Amadi</p>
                    <p><i class="fa fa-tag"></i>Full Stack & Mobile App Developer</p>
                    <p><i class="fa fa-envelope"></i><a href="mailto:emmco96@gmail.com">emmco96@gmail.com</a></p>
                    <p><i class="fa fa-phone"></i><a href="tel:+2349056897432">+234 905 689 7432</a></p>
                    <p><i class="fa fa-map-marker"></i>Port Harcourt, Rivers State, Nigeria</p>
                    <div class="social">
                        <a class="btn" href="https://www.facebook.com/emmanuel.amadi.3760" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://github.com/Emmzyben" target="_blank" class="btn"><i class="fab fa-github"></i></a>
                        <a class="btn" href="https://www.linkedin.com/in/emmanuel-amadi-486582234" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form">
                    <?php if (isset($_GET['contact_status'])): ?>
                        <?php if ($_GET['contact_status'] === 'success'): ?>
                            <div class="alert alert-success">Message sent successfully! I will get back to you soon.</div>
                        <?php else: ?>
                            <div class="alert alert-danger">Failed to send message. Please fill all required fields.</div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <form action="api/submit_contact.php" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required />
                            </div>
                            <div class="form-group col-md-6">
                                <input type="email" name="email" class="form-control" placeholder="Your Email" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="subject" class="form-control" placeholder="Subject" />
                        </div>
                        <div class="form-group">
                            <textarea name="message" class="form-control" rows="5" placeholder="Message" required></textarea>
                        </div>
                        <div><button class="btn" type="submit">Send Message</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->
