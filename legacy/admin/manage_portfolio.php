<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once 'auth_check.php';

$message = "";

if (isset($_POST['add_project'])) {
    $name = trim($_POST['name'] ?? '');
    $category_id = $_POST['category_id'] ?? '';
    $link = trim($_POST['link'] ?? '');

    $image = $_FILES['image'] ?? null;
    $imageUrl = '';

    if ($image && $image['tmp_name']) {
        $uploadedUrl = upload_file_to_remote($image);

        if ($uploadedUrl) {
            $imageUrl = $uploadedUrl;
            firebase_create('projects', [
                'name' => $name,
                'category_id' => $category_id,
                'link' => $link,
                'image' => $imageUrl,
                'created_at' => date('Y-m-d H:i:s'),
            ], $firebaseDatabase);
            $message = 'Project added successfully!';
        } else {
            $message = 'Failed to upload image.';
        }
    }
}

if (isset($_POST['edit_project'])) {
    $id = $_POST['project_id'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $category_id = $_POST['category_id'] ?? '';
    $link = trim($_POST['link'] ?? '');

    $data = ['name' => $name, 'category_id' => $category_id, 'link' => $link];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $uploadedUrl = upload_file_to_remote($image);

        if ($uploadedUrl) {
            $data['image'] = $uploadedUrl;
            firebase_update('projects', $id, $data, $firebaseDatabase);
            $message = 'Project updated successfully!';
        }
    } else {
        firebase_update('projects', $id, $data, $firebaseDatabase);
        $message = 'Project updated successfully!';
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    firebase_delete('projects', $id, $firebaseDatabase);
    $message = 'Project deleted successfully!';
}

$categories = get_categories($firebaseDatabase);
$projects = get_projects($firebaseDatabase);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Portfolio - Amadi Admin</title>
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
                            <a class="nav-link active" href="manage_portfolio.php">
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
                    <h2>Manage Portfolio</h2>
                </div>

                <?php if ($message): ?>
                    <div class="alert alert-success"><?php echo $message; ?></div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">Add New Project</div>
                            <div class="card-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Project Name</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select name="category_id" class="form-control" required>
                                                    <option value="">Select Category</option>
                                                    <?php foreach ($categories as $cat): ?>
                                                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Project Link</label>
                                                <input type="url" name="link" class="form-control" placeholder="https://...">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Project Image</label>
                                                <input type="file" name="image" class="form-control" required accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="add_project" class="btn btn-primary">Publish Project</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Published Projects</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Link</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($projects as $proj): ?>
                                                <tr>
                                                    <td><img src="<?php echo htmlspecialchars(resolve_media_url($proj['image'] ?? '')); ?>" width="60" height="40" style="object-fit: cover; border: 1px solid #FF6F61;"></td>
                                                    <td><?php echo htmlspecialchars($proj['name']); ?></td>
                                                    <td><span class="badge badge-secondary"><?php echo htmlspecialchars($proj['category_name']); ?></span></td>
                                                    <td><small><?php echo htmlspecialchars($proj['link']); ?></small></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary edit-project" 
                                                                data-id="<?php echo $proj['id']; ?>" 
                                                                data-name="<?php echo htmlspecialchars($proj['name']); ?>"
                                                                data-category="<?php echo $proj['category_id']; ?>"
                                                                data-link="<?php echo htmlspecialchars($proj['link']); ?>"
                                                                title="Edit Project">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <a href="?delete=<?php echo $proj['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this project?')" title="Delete Project">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php if (empty($projects)): ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">No projects in portfolio.</td>
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
                    <h5 class="modal-title">Edit Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="project_id" id="edit_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Project Name</label>
                                    <input type="text" name="name" id="edit_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="category_id" id="edit_category" class="form-control" required>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Project Link</label>
                                    <input type="url" name="link" id="edit_link" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-info py-2">Leave image blank to keep current photo.</div>
                                <div class="form-group">
                                    <label>Update Image (Optional)</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="edit_project" class="btn btn-primary">Update Project</button>
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
            $('.edit-project').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var cat = $(this).data('category');
                var link = $(this).data('link');
                
                $('#edit_id').val(id);
                $('#edit_name').val(name);
                $('#edit_category').val(cat);
                $('#edit_link').val(link);
                $('#editModal').modal('show');
            });
        });
    </script>
</body>
</html>
