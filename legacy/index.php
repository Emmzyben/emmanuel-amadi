<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$categories = get_categories($firebaseDatabase);
$projects = get_projects($firebaseDatabase, 6); // Limit to 6 on homepage
$reviews = get_reviews($firebaseDatabase);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Emmanuel Amadi | Full Stack & Mobile App Developer Portfolio</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta
        content="full stack developer, mobile app developer, web developer, wordpress developer, Emmanuel Amadi, Nigeria developer, React developer, Node.js expert"
        name="keywords">
    <meta
        content="Portfolio of Emmanuel Amadi, a professional Full Stack Developer and Mobile App Specialist based in Nigeria. Expert in React, Node.js, PHP, and WordPress Development."
        name="description">
    <link rel="canonical" href="http://localhost/my-portfolio/index.php" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://localhost/my-portfolio/index.php">
    <meta property="og:title" content="Emmanuel Amadi | Full Stack & Mobile App Developer">
    <meta property="og:description"
        content="Professional Full Stack & Mobile App Developer specializing in React, Node.js, and WordPress. Check out my latest projects.">
    <meta property="og:image" content="img/bg.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="http://localhost/my-portfolio/index.php">
    <meta property="twitter:title" content="Emmanuel Amadi | Full Stack & Mobile App Developer">
    <meta property="twitter:description"
        content="Professional Full Stack & Mobile App Developer specializing in React, Node.js, and WordPress. Check out my latest projects.">
    <meta property="twitter:image" content="img/bg.png">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/slick/slick.css" rel="stylesheet">
    <link href="lib/slick/slick-theme.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="51">
    <div class="wrapper">
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="img/bg.png" alt="Emmanuel Amadi - Full Stack & Mobile App Developer">
            </div>
            <div class="sidebar-content">
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a href="#" class="navbar-brand">Navigation</a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="nav navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#header">Home<i class="fa fa-home"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#about">About<i class="fa fa-address-card"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#experience">Experience<i class="fa fa-star"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#service">Service<i class="fa fa-tasks"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#portfolio">Portfolio<i class="fa fa-file-archive"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#contact">Contact<i class="fa fa-envelope"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="sidebar-footer">
                <a href="https://www.facebook.com/emmanuel.amadi.3760" target="_blank"><i
                        class="fab fa-facebook-f"></i></a>
                <a href="https://github.com/Emmzyben" target="_blank"><i class="fab fa-github"></i></a>
                <a href="https://www.linkedin.com/in/emmanuel-amadi-486582234" target="_blank"><i
                        class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
        <div class="content">
            <!-- Header Start -->
            <div class="header" id="header">
                <div class="content-inner">
                    <p>I'm</p>
                    <h1>Emmanuel Amadi</h1>
                    <h2></h2>
                    <div class="typed-text">Web Designer, Web Developer, Front End Developer, Mobile App Developer</div>
                </div>
            </div>
            <!-- Header End -->

            <!-- Large Button Start -->
            <div class="large-btn">
                <div class="content-inner">
                    <a class="btn" href="img/resume.pdf" target="_blank" download><i
                            class="fa fa-download"></i>Resume</a>
                    <a class="btn" href="#contact"><i class="fa fa-hands-helping"></i>Hire Me</a>
                </div>
            </div>
            <!-- Large Button End -->

            <!-- About Start -->
            <div class="about" id="about">
                <div class="content-inner">
                    <div class="content-header">
                        <h2>About Me</h2>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-6 col-lg-5">
                            <img src="img/bg.png" alt="About Emmanuel Amadi - Web and Mobile Development Specialist">
                        </div>
                        <div class="col-md-6 col-lg-7">
                            <p>
                                I am a passionate and detail-oriented software developer with a strong foundation in web
                                and mobile application development. I specialize in creating seamless, user-friendly
                                interfaces and robust backend systems. My goal is to leverage my technical skills to
                                build innovative solutions that solve real-world problems and deliver exceptional user
                                experiences.
                            </p>
                            <a class="btn" href="#contact">Hire Me</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="skills">
                                <div class="skill-name">
                                    <p>Html</p>
                                    <p>99%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="85" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="skill-name">
                                    <p>CSS</p>
                                    <p>95%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="skill-name">
                                    <p>Node Js</p>
                                    <p>90%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="skill-name">
                                    <p>Express.js</p>
                                    <p>90%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="skill-name">
                                    <p>PostgreSQL</p>
                                    <p>85%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="85" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="skill-name">
                                    <p>REST APIs</p>
                                    <p>95%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="skill-name">
                                    <p>WordPress</p>
                                    <p>90%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="skills">
                                <div class="skill-name">
                                    <p>React Js</p>
                                    <p>90%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="skill-name">
                                    <p>React Native</p>
                                    <p>90%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="85" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>

                                <div class="skill-name">
                                    <p>PHP/MySQL</p>
                                    <p>95%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="skill-name">
                                    <p>Redux</p>
                                    <p>90%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="skill-name">
                                    <p>Firebase</p>
                                    <p>85%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="85" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="skill-name">
                                    <p>Git</p>
                                    <p>95%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="skill-name">
                                    <p>GHL (GoHighLevel)</p>
                                    <p>90%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- About End -->

            <!-- Education Start -->
            <div class="education" id="education">
                <div class="content-inner">
                    <div class="content-header">
                        <h2>Education</h2>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="edu-col">
                                <span>2024 <i>to</i> Present</span>
                                <h3>Masters in Fisheries Management (in View)</h3>
                                <p>University of Port Harcourt, Rivers State</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="edu-col">
                                <span>2016 <i>to</i> 2023</span>
                                <h3>Bachelor of Aquatic science</h3>
                                <p>University of Port Harcourt, Rivers State</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Education Start -->

            <!-- Experience Start -->
            <div class="experience" id="experience">
                <div class="content-inner">
                    <div class="content-header">
                        <h2>Experience</h2>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="exp-col">
                                <span>2024 <i>to</i> 2026</span>
                                <h3>Gita-allied tech solutions</h3>
                                <h4>Nigeria</h4>
                                <h5>Web/Mobile App Developer</h5>
                                <p>Developed high-performance full-stack web and mobile applications using React, React
                                    Native, Node.js, and Firebase, while streamlining development workflows through
                                    automated CI/CD pipelines and reusable backend services.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="exp-col">
                                <span>2023 <i>to</i> 2024</span>
                                <h3>Crystal business solutions</h3>
                                <h4>United Kingdom (Remote)</h4>
                                <h5>Full-Stack Developer</h5>
                                <p>Designed and developed various company websites and a comprehensive e-learning
                                    platform with sophisticated dashboards and secure Stripe payment integration.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="exp-col">
                                <span>2022 <i>to</i> 2023</span>
                                <h3>Pharmers Academy</h3>
                                <h4>South Africa (Remote)</h4>
                                <h5>Full-stack developer</h5>
                                <p>Engineered a scalable e-learning system using PHP/MySQL, implementing RESTful APIs
                                    for course management and integration with payment gateways.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="exp-col">
                                <span>2021 <i>to</i> 2022</span>
                                <h3>Grandida LLC</h3>
                                <h4>USA (Remote)</h4>
                                <h5>Solidity Developer</h5>
                                <p>Built decentralized applications (dApps) using Solidity and React, leveraging
                                    IPFS for secure, scalable, and resilient cloud-native development.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Experience Start -->

            <!-- Service Start -->
            <div class="service" id="service">
                <div class="content-inner">
                    <div class="content-header">
                        <h2>Service</h2>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="srv-col">
                                <i class="fa fa-code"></i>
                                <h3>Web Development</h3>
                                <p>Building responsive, high-performance, and scalable web applications using modern
                                    technologies like React, Node.js, and PHP.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="srv-col">
                                <i class="fa fa-mobile-alt"></i>
                                <h3>Mobile App Development</h3>
                                <p>Developing custom cross-platform mobile applications for iOS and Android using React
                                    Native Expo for a seamless user experience.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="srv-col">
                                <i class="fa fa-server"></i>
                                <h3>Backend & API Development</h3>
                                <p>Architecting robust server-side infrastructures and designing RESTful APIs that
                                    provide secure and reliable data integration.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="srv-col">
                                <i class="fab fa-wordpress"></i>
                                <h3>WordPress & CMS Development</h3>
                                <p>Crafting professional, customizable, and easy-to-manage websites using WordPress and
                                    other Content Management Systems.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Service Start -->

            <!-- Portfolio Start -->
            <div class="portfolio" id="portfolio">
                <div class="content-inner">
                    <div class="content-header">
                        <h2>Portfolio</h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul id="portfolio-flters">
                                <li data-filter="*" class="filter-active">All</li>
                                <?php foreach ($categories as $cat): ?>
                                    <li data-filter=".<?php echo htmlspecialchars($cat['slug']); ?>">
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="row portfolio-container">
                        <?php foreach ($projects as $proj): ?>
                            <div
                                class="col-lg-4 col-md-6 portfolio-item <?php echo htmlspecialchars($proj['category_slug']); ?>">
                                <div class="portfolio-wrap">
                                    <figure>
                                        <img src="<?php echo htmlspecialchars(resolve_media_url($proj['image'] ?? '')); ?>" class="img-fluid"
                                            alt="<?php echo htmlspecialchars($proj['name']); ?>">
                                        <a href="<?php echo htmlspecialchars(resolve_media_url($proj['image'] ?? '')); ?>"
                                            data-lightbox="portfolio"
                                            data-title="<?php echo htmlspecialchars($proj['name']); ?>" class="link-preview"
                                            title="Preview"><i class="fa fa-eye"></i></a>
                                    </figure>
                                    <div class="portfolio-info">
                                        <h4><?php echo htmlspecialchars($proj['name']); ?></h4>
                                        <p><?php echo htmlspecialchars($proj['category_name']); ?></p>
                                        <a href="<?php echo htmlspecialchars($proj['link']); ?>" target="_blank"
                                            class="btn-view">View Project <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php if (empty($projects)): ?>
                            <div class="col-12 text-center py-5">
                                <p class="text-white">No projects published yet.</p>
                            </div>
                        <?php else: ?>

                        <?php endif; ?>
                    </div>
                    <div class="col-12 text-center mt-5">
                        <a href="projects.php" class="btn"
                            style="background: #FF6F61; color: #ffffff; border-radius: 0; padding: 12px 30px; font-weight: 700;">View
                            All Projects</a>
                    </div>
                </div>
            </div>
            <!-- Portfolio Start -->

            <!-- Review Start -->
            <div class="review" id="review">
                <div class="content-inner">
                    <div class="content-header">
                        <h2>Reviews</h2>
                    </div>
                    <div class="row align-items-center review-slider">
                        <?php foreach ($reviews as $rev): ?>
                            <div class="col-md-12">
                                <div class="review-slider-item">
                                    <div class="review-text">
                                        <p><?php echo htmlspecialchars($rev['review_text']); ?></p>
                                    </div>
                                    <div class="review-img">
                                        <div class="review-name">
                                            <h3><?php echo htmlspecialchars($rev['reviewer_name']); ?></h3>
                                            <p><?php echo htmlspecialchars($rev['location']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php if (empty($reviews)): ?>
                            <div class="col-12 text-center py-5">
                                <p class="text-white">No reviews yet</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- Review End -->

            <?php include 'includes/contact_section.php'; ?>

            <!-- Footer Start -->
            <div class="footer">
                <div class="content-inner">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <p>&copy; Copyright 2026 Emmanuel Amadi, All Rights Reserved</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Start -->
        </div>
    </div>

    <!-- Back to Top -->
    <!-- WhatsApp Widget -->
    <a href="https://wa.me/2349056897432?text=Hello%20Emmanuel,%20I%20am%20interested%20in%20your%20services."
        class="whatsapp-widget" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <a href="#" class="back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/slick/slick.min.js"></script>
    <script src="lib/typed/typed.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>