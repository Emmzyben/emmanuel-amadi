<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once 'auth_check.php';

$message = "";

if (isset($_POST['add_review'])) {
    $name = trim($_POST['reviewer_name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $review_text = trim($_POST['review_text'] ?? '');

    if ($name && $location && $review_text) {
        firebase_create('reviews', [
            'reviewer_name' => $name,
            'location' => $location,
            'review_text' => $review_text,
            'created_at' => date('Y-m-d H:i:s'),
        ], $firebaseDatabase);
        $message = 'Review added successfully!';
    }
}

if (isset($_POST['edit_review'])) {
    $id = $_POST['review_id'] ?? '';
    $name = trim($_POST['reviewer_name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $review_text = trim($_POST['review_text'] ?? '');

    if ($id && $name && $location && $review_text) {
        firebase_update('reviews', $id, [
            'reviewer_name' => $name,
            'location' => $location,
            'review_text' => $review_text,
        ], $firebaseDatabase);
        $message = 'Review updated successfully!';
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    firebase_delete('reviews', $id, $firebaseDatabase);
    $message = 'Review deleted successfully!';
}

$reviews = get_reviews($firebaseDatabase);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reviews - Amadi Admin</title>
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
                            <a class="nav-link active" href="manage_reviews.php">
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
                    <h2>Manage Reviews</h2>
                </div>

                <?php if ($message): ?>
                    <div class="alert alert-success"><?php echo $message; ?></div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">Add New Review</div>
                            <div class="card-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Reviewer Name</label>
                                                <input type="text" name="reviewer_name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Location / Profession</label>
                                                <input type="text" name="location" class="form-control" required placeholder="e.g. Lagos, Nigeria or CEO, Tech Co">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Review Text</label>
                                                <textarea name="review_text" class="form-control" rows="3" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="add_review" class="btn btn-primary">Save Review</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Existing Reviews</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Location</th>
                                                <th>Review</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reviews as $rev): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($rev['reviewer_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($rev['location']); ?></td>
                                                    <td><small><?php echo substr(htmlspecialchars($rev['review_text']), 0, 50); ?>...</small></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary edit-review" 
                                                                data-id="<?php echo $rev['id']; ?>" 
                                                                data-name="<?php echo htmlspecialchars($rev['reviewer_name']); ?>"
                                                                data-location="<?php echo htmlspecialchars($rev['location']); ?>"
                                                                data-text="<?php echo htmlspecialchars($rev['review_text']); ?>"
                                                                title="Edit Review">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <a href="?delete=<?php echo $rev['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this review?')" title="Delete Review">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php if (empty($reviews)): ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">No reviews found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="review_id" id="edit_id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Reviewer Name</label>
                                    <input type="text" name="reviewer_name" id="edit_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location / Profession</label>
                                    <input type="text" name="location" id="edit_location" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Review Text</label>
                                    <textarea name="review_text" id="edit_text" class="form-control" rows="4" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="edit_review" class="btn btn-primary">Update Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.edit-review').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var location = $(this).data('location');
                var text = $(this).data('text');
                
                $('#edit_id').val(id);
                $('#edit_name').val(name);
                $('#edit_location').val(location);
                $('#edit_text').val(text);
                $('#editModal').modal('show');
            });
        });
    </script>
</body>
</html>
