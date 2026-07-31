<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once 'auth_check.php';

$message = "";

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    firebase_delete('contact_requests', $id, $firebaseDatabase);
    $message = 'Request deleted successfully!';
}

if (isset($_GET['read'])) {
    $id = $_GET['read'];
    firebase_update('contact_requests', $id, ['status' => 'read'], $firebaseDatabase);
    $message = 'Request marked as read!';
}

$requests = get_requests($firebaseDatabase);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Requests - Amadi Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
    <style>
        .unread { background-color: rgba(255, 111, 97, 0.1); border-left: 4px solid #FF6F61; }
        .message-row td { padding: 20px 10px; }
    </style>
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
                            <a class="nav-link" href="dashboard.php">
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
                            <a class="nav-link active" href="manage_requests.php">
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
                    <h2>Contact Requests</h2>
                </div>

                <?php if ($message): ?>
                    <div class="alert alert-success"><?php echo $message; ?></div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">Messages from Visitors</div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Sender</th>
                                        <th>Details</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($requests as $req): ?>
                                        <tr class="message-row <?php echo $req['status'] === 'unread' ? 'unread' : ''; ?>">
                                            <td>
                                                <strong><?php echo htmlspecialchars($req['name']); ?></strong><br>
                                                <small><?php echo htmlspecialchars($req['email']); ?></small>
                                            </td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($req['subject']); ?></strong>
                                            </td>
                                            <td>
                                                <p style="max-width: 400px;"><?php echo nl2br(htmlspecialchars($req['message'])); ?></p>
                                            </td>
                                            <td>
                                                <small><?php echo date('M d, Y h:i A', strtotime($req['created_at'])); ?></small>
                                            </td>
                                            <td>
                                                <?php if ($req['status'] === 'unread'): ?>
                                                    <a href="?read=<?php echo $req['id']; ?>" class="btn btn-outline-primary btn-sm mb-1" title="Mark as Read">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="?delete=<?php echo $req['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this request?')" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($requests)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-5">No contact requests found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
