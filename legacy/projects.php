<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$categories = get_categories($firebaseDatabase);
$projects = get_projects($firebaseDatabase); // All projects
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>All Projects | Emmanuel Amadi - Full Stack Developer</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta
        content="full stack developer portfolio, mobile app developer projects, web developer showcase, wordpress projects, Emmanuel Amadi work"
        name="keywords">
    <meta
        content="Browse the complete portfolio of Emmanuel Amadi, featuring high-quality web and mobile applications developed with React, Node.js, and WordPress."
        name="description">
    <link rel="canonical" href="http://localhost/my-portfolio/projects.php" />

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
    <style>
        .portfolio {
            padding: 60px 0;
            min-height: 80vh;
        }

        .back-home {
            margin-bottom: 30px;
            display: inline-block;
            color: #FF6F61;
            font-weight: 700;
            text-decoration: none;
        }

        .back-home:hover {
            color: #ffffff;
        }
    </style>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="51">
    <div class="wrapper full-screen">

        <div class="content">
            <!-- Portfolio Start -->
            <div class="portfolio" id="portfolio" style="padding:20px">
                <div class="content-inner">
                    <div class="content-header">
                        <h2>Full Portfolio</h2>
                    </div>

                    <a href="index.php" class="back-home"><i class="fa fa-arrow-left mr-2"></i>Back to Home</a>

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
                        <?php endif; ?>
                    </div>
                    <!-- Contact Section Include -->
                    <?php include 'includes/contact_section.php'; ?>
                </div>
            </div>
            <!-- Portfolio End -->

            <!-- Footer Start -->
            <div class="footer">
                <div class="content-inner">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p>&copy; Copyright 2026 Emmanuel Amadi, All Rights Reserved</p>
                        </div>
                        <div class="col-md-6 text-md-right footer-social">
                            <a href="https://www.facebook.com/emmanuel.amadi.3760" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://github.com/Emmzyben" target="_blank"><i class="fab fa-github"></i></a>
                            <a href="https://www.linkedin.com/in/emmanuel-amadi-486582234" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
    </div>

    <!-- WhatsApp Widget -->
    <a href="https://wa.me/2349056897432?text=Hello%20Emmanuel,%20I%20am%20interested%20in%20your%20services."
        class="whatsapp-widget" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

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