<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once 'auth_check.php';

$message = "";

if (isset($_POST['add_category'])) {
    $name = trim($_POST['name'] ?? '');
    $slug = strtolower(str_replace(' ', '-', $name));

    if ($name) {
        firebase_create('categories', [
            'name' => $name,
            'slug' => $slug,
            'created_at' => date('Y-m-d H:i:s'),
        ], $firebaseDatabase);
        $message = 'Category added successfully!';
    }
}

if (isset($_POST['edit_category'])) {
    $id = $_POST['category_id'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $slug = strtolower(str_replace(' ', '-', $name));

    if ($id && $name) {
        firebase_update('categories', $id, ['name' => $name, 'slug' => $slug], $firebaseDatabase);
        $message = 'Category updated successfully!';
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    firebase_delete('categories', $id, $firebaseDatabase);
    $message = 'Category deleted successfully!';
}

$categories = get_categories($firebaseDatabase);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Amadi Admin</title>
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
                            <a class="nav-link active" href="manage_categories.php">
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
                    <h2>Manage Categories</h2>
                </div>

                <?php if ($message): ?>
                    <div class="alert alert-success"><?php echo $message; ?></div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">Add New Category</div>
                            <div class="card-body">
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input type="text" name="name" class="form-control" required placeholder="e.g. Web Design">
                                    </div>
                                    <button type="submit" name="add_category" class="btn btn-primary">Save Category</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Existing Categories</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Slug</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($categories as $cat): ?>
                                                <tr>
                                                    <td><?php echo $cat['id']; ?></td>
                                                    <td><?php echo htmlspecialchars($cat['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($cat['slug']); ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary edit-category" 
                                                                data-id="<?php echo $cat['id']; ?>" 
                                                                data-name="<?php echo htmlspecialchars($cat['name']); ?>" 
                                                                title="Edit Category">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <a href="?delete=<?php echo $cat['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure? This will delete all projects in this category.')" title="Delete Category">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php if (empty($categories)): ?>
                                                <tr>
                                                    <td colspan="4" class="text-center">No categories found.</td>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="category_id" id="edit_id">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="edit_category" class="btn btn-primary">Update Category</button>
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
            $('.edit-category').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                
                $('#edit_id').val(id);
                $('#edit_name').val(name);
                $('#editModal').modal('show');
            });
        });
    </script>
</body>
</html>
