<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once 'auth_check.php';

$projects = get_projects($firebaseDatabase);
$reviews = get_reviews($firebaseDatabase);
$categories = get_categories($firebaseDatabase);
$requests = get_requests($firebaseDatabase);

$project_count = count($projects);
$review_count = count($reviews);
$category_count = count($categories);
$request_count = count_unread_requests($firebaseDatabase);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Portfolio Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-header">
                    <h3>AMADI ADMIN</h3>
                </div>
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="dashboard.php">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_categories.php">
                                <i class="fas fa-list"></i> Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_portfolio.php">
                                <i class="fas fa-briefcase"></i> Portfolio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_reviews.php">
                                <i class="fas fa-star"></i> Reviews
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_requests.php">
                                <i class="fas fa-envelope"></i> Requests
                            </a>
                        </li>
                        <li class="nav-item mt-5">
                            <a class="nav-link text-danger" href="logout.php">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main role="main" class="col-md-10 ml-sm-auto main-content">
                <div class="page-header">
                    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_user']); ?>!</h2>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h1 class="display-4" style="color: #FF6F61;"><?php echo $project_count; ?></h1>
                                <p class="lead">Projects</p>
                                <a href="manage_portfolio.php" class="btn btn-outline-primary btn-sm">Manage</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h1 class="display-4" style="color: #FF6F61;"><?php echo $review_count; ?></h1>
                                <p class="lead">Reviews</p>
                                <a href="manage_reviews.php" class="btn btn-outline-primary btn-sm">Manage</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h1 class="display-4" style="color: #FF6F61;"><?php echo $category_count; ?></h1>
                                <p class="lead">Categories</p>
                                <a href="manage_categories.php" class="btn btn-outline-primary btn-sm">Manage</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h1 class="display-4" style="color: #FF6F61;"><?php echo $request_count; ?></h1>
                                <p class="lead">New Requests</p>
                                <a href="manage_requests.php" class="btn btn-outline-primary btn-sm">Manage</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="card">
                        <div class="card-header">Quick Actions</div>
                        <div class="card-body">
                            <p>Use the sidebar to manage your portfolio content. Changes made here will reflect immediately on your live website.</p>
                            <a href="../index.php" target="_blank" class="btn btn-primary">View Live Website</a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
