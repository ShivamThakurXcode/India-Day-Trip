<?php
session_start();
require_once '../config.php';
checkAdminLogin();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    try {
        $id = $_POST['id'] ?? null;
        $title = trim($_POST['title']);
        $slug = trim($_POST['slug']);
        $content = trim($_POST['content']);
        $excerpt = trim($_POST['excerpt']);
        $author = trim($_POST['author']);
        $publication_date = $_POST['publication_date'];
        $category_id = $_POST['category_id'] ?: null;
        $status = $_POST['status'];
        $tags = json_decode($_POST['tags'], true) ?: [];

        // Generate slug if empty
        if (empty($slug)) {
            $slug = generateSlug($title, 'blogs', $id);
        }

        $featured_image = '';
        if (!empty($_FILES['featured_image']['name'])) {
            $upload_dir = "../assets/img/blog/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            $filename = basename($_FILES['featured_image']['name']);
            $target = $upload_dir . $filename;
            if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
                $featured_image = $filename;
            }
        } elseif (!empty($_POST['current_featured_image'])) {
            $featured_image = $_POST['current_featured_image'];
        }

        $tags_json = json_encode($tags);

        if ($id) {
            $stmt = $pdo->prepare("UPDATE blogs SET title = ?, slug = ?, content = ?, excerpt = ?, author = ?, publication_date = ?, category_id = ?, status = ?, tags = ?, featured_image = ? WHERE id = ?");
            $stmt->execute([$title, $slug, $content, $excerpt, $author, $publication_date, $category_id, $status, $tags_json, $featured_image, $id]);
            $message = 'Blog updated successfully!';
        } else {
            $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, content, excerpt, author, publication_date, category_id, status, tags, featured_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $content, $excerpt, $author, $publication_date, $category_id, $status, $tags_json, $featured_image]);
            $message = 'Blog added successfully!';
        }
        echo json_encode(['success' => true, 'message' => $message]);
    } catch (Exception $e) {
        error_log('Blog save error: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $message = 'Blog deleted successfully!';
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs Management - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="../assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .modal-dialog {
            max-width: 90vw;
            height: 90vh;
            margin: auto auto;
            top: 5%;
        }
        .modal-content {
            height: 100%;
            overflow: hidden;
        }
        .modal-body {
            height: calc(100% - 120px);
            overflow-y: auto;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .modal-footer {
            justify-content: flex-end;
            gap: 10px;
        }
        .modal-footer .btn {
            min-width: 100px;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <?php include 'header.php'; ?>
    <div class="main-content">
        <div class="content-wrapper">
            <div class="d-flex mb-3 justify-content-between align-items-center">
                <h1 class="page-title">Blogs Management</h1>
                <?php if ($message): ?>
                    <div class="alert alert-info"><?php echo $message; ?></div>
                <?php endif; ?>
                <button type="button" class="btn btn-primary mb-3" onclick="openAddModal()" aria-label="Add new blog">Add New Blog</button>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Publication Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT b.*, c.name as category_name FROM blogs b LEFT JOIN categories c ON b.category_id = c.id ORDER BY b.created_at DESC");
                    while ($row = $stmt->fetch()) {
                        $truncatedTitle = strlen($row['title']) > 50 ? substr($row['title'], 0, 50) . '...' : $row['title'];
                        echo "<tr>
                            <td>{$truncatedTitle}</td>
                            <td>{$row['author']}</td>
                            <td>{$row['category_name']}</td>
                            <td><span class='badge badge-" . ($row['status'] == 'published' ? 'success' : 'secondary') . "'>{$row['status']}</span></td>
                            <td>" . date('Y-m-d', strtotime($row['publication_date'])) . "</td>
                            <td>
                                <a href='#' onclick='openEditModal({$row['id']})' class='btn btn-sm btn-warning'>Edit</a>
                                <a href='?action=delete&id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Delete this blog?\")'>Delete</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="blogModal" tabindex="-1" role="dialog" aria-labelledby="blogModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="blogModalLabel">Add New Blog</h5>
                    <button type="button" class="close" onclick="$('#blogModal').modal('hide')" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="blogForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="blogId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title *</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Slug *</label>
                                    <input type="text" name="slug" id="slug" class="form-control" required>
                                    <small class="form-text text-muted">URL-friendly version of the title. Auto-generated if left empty.</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Content *</label>
                            <textarea name="content" class="form-control" rows="10" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Excerpt</label>
                            <textarea name="excerpt" class="form-control" rows="3" placeholder="Short summary of the blog post"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Author *</label>
                                    <input type="text" name="author" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Publication Date *</label>
                                    <input type="date" name="publication_date" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">Select Category</option>
                                        <?php
                                        $cat_stmt = $pdo->query("SELECT * FROM categories WHERE type = 'blog'");
                                        while ($cat = $cat_stmt->fetch()) {
                                            echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tags (comma-separated)</label>
                            <input type="text" name="tags_input" id="tagsInput" class="form-control" placeholder="tag1, tag2, tag3">
                            <input type="hidden" name="tags" id="tagsHidden">
                        </div>
                        <div class="form-group">
                            <label>Featured Image</label>
                            <input type="file" name="featured_image" class="form-control-file" accept="image/*">
                            <input type="hidden" name="current_featured_image" id="currentFeaturedImage">
                            <div id="currentImagePreview"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="$('#blogModal').modal('hide')">Cancel</button>
                    <button type="button" id="saveBlogBtn" class="btn btn-success">Save Blog</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script>
        function openAddModal() {
            $('#blogForm')[0].reset();
            $('#blogId').val('');
            $('#currentImagePreview').html('');
            $('#blogModalLabel').text('Add New Blog');
            $('#blogModal').modal('show');
        }

        function openEditModal(id) {
            $.get('get_blog.php?id=' + id, function(data) {
                var blog = JSON.parse(data);
                $('#blogId').val(blog.id);
                $('input[name="title"]').val(blog.title);
                $('input[name="slug"]').val(blog.slug);
                $('textarea[name="content"]').val(blog.content);
                $('textarea[name="excerpt"]').val(blog.excerpt);
                $('input[name="author"]').val(blog.author);
                $('input[name="publication_date"]').val(blog.publication_date);
                $('select[name="category_id"]').val(blog.category_id);
                $('select[name="status"]').val(blog.status);
                var tags = JSON.parse(blog.tags || '[]');
                $('#tagsInput').val(tags.join(', '));
                $('#tagsHidden').val(JSON.stringify(tags));
                $('#currentFeaturedImage').val(blog.featured_image);
                if (blog.featured_image) {
                    $('#currentImagePreview').html('<img src="../assets/img/blog/' + blog.featured_image + '" width="100" height="100" style="object-fit: cover;">');
                }
                $('#blogModalLabel').text('Edit Blog');
                $('#blogModal').modal('show');
            });
        }

        $(document).ready(function() {
            $('input[name="title"]').on('input', function() {
                var title = $(this).val();
                var slug = title.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                $('input[name="slug"]').val(slug);
            });

            $('#tagsInput').on('input', function() {
                var tags = $(this).val().split(',').map(tag => tag.trim()).filter(tag => tag);
                $('#tagsHidden').val(JSON.stringify(tags));
            });

            $('#saveBlogBtn').click(function() {
                var $btn = $(this);
                var originalText = $btn.text();
                $btn.prop('disabled', true).text('Saving...');
                var formData = new FormData($('#blogForm')[0]);
                $.ajax({
                    url: 'blog.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    timeout: 10000,
                    success: function(response) {
                        try {
                            var res = JSON.parse(response);
                            alert(res.message);
                            $btn.prop('disabled', false).text(originalText);
                            if (res.success) {
                                $('#blogModal').modal('hide');
                                location.reload();
                            }
                        } catch (e) {
                            alert('Invalid response from server.');
                            $btn.prop('disabled', false).text(originalText);
                        }
                    },
                    error: function(xhr, status, error) {
                        if (status === 'timeout') {
                            alert('Request timed out. Please try again.');
                        } else {
                            alert('An error occurred while saving: ' + error);
                        }
                        $btn.prop('disabled', false).text(originalText);
                    }
                });
            });
        });
    </script>
</body>
</html>