<?php
ob_start();
session_start();
require_once '../config.php';
checkAdminLogin();

$message = '';

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $id = $_POST['id'] ?? null;
        $title = trim($_POST['title']);
        $slug = trim($_POST['slug']);
        $content = $_POST['content'];
        $excerpt = trim($_POST['excerpt']);
        $author = trim($_POST['author']);
        $publication_date = $_POST['publication_date'];
        $status = $_POST['status'];
        $tags = array_map('trim', explode(',', $_POST['tags']));
        $tags_json = json_encode($tags);
        $category_id = $_POST['category_id'] ?? null;

        // Generate slug if empty
        if (empty($slug)) {
            $slug = generateSlug($title, 'blogs', $id);
        }

        $featured_image = '';
        if (!empty($_FILES['featured_image']['name'])) {
            $filename = basename($_FILES['featured_image']['name']);
            $target = "../assets/img/blog/" . $filename;
            if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
                $featured_image = $filename;
            }
        }

        if ($id) {
            $query = "UPDATE blogs SET title = ?, slug = ?, content = ?, excerpt = ?, author = ?, publication_date = ?, status = ?, tags = ?, category_id = ?";
            $params = [$title, $slug, $content, $excerpt, $author, $publication_date, $status, $tags_json, $category_id];
            if ($featured_image) {
                $query .= ", featured_image = ?";
                $params[] = $featured_image;
            }
            $query .= " WHERE id = ?";
            $params[] = $id;
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            $_SESSION['message'] = 'Blog updated successfully!';
        } else {
            $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, content, excerpt, author, publication_date, status, tags, category_id, featured_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $content, $excerpt, $author, $publication_date, $status, $tags_json, $category_id, $featured_image]);
            $_SESSION['message'] = 'Blog added successfully!';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
    header('Location: blogs.php');
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $_SESSION['message'] = 'Blog deleted successfully!';
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
    header('Location: blogs.php');
    exit;
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
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <style>
        /* Modal Styles */
        .modal {
            z-index: 9999;
        }
        .modal-dialog {
            max-width: 80vw;
            height: 80vh;
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
        .input-group-text{
            height: 100%;
        }
    </style>
    <style>
        /* Color Switcher Enhancement */
        .color-switch-btns button {
            position: relative;
            transition: all 0.3s ease;
        }

        .color-switch-btns button.active {
            transform: scale(1.2);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            border: 2px solid #fff;
        }

        .color-switch-btns button:hover {
            transform: scale(1.1);
        }

        /* Tour Slider Section Header Styling */
        .tour-area .row.align-items-center {
            margin-bottom: 30px;
        }

        .tour-area .title-area .sec-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--title-color);
            margin-bottom: 0;
        }

        /* Tour Location Styling */
        .tour-location {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        @media (max-width: 767px) {
            .tour-area .row.align-items-center {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 15px;
            }

            .tour-area .row.align-items-center .col-auto:last-child {
                width: 100%;
            }

            .tour-area .row.align-items-center .col-auto:last-child .line-btn {
                width: 100%;
                text-align: center;
                display: inline-block;
            }

            .tour-area .title-area .sec-title {
                font-size: 24px;
            }
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
                            <td>{$row['status']}</td>
                            <td>{$row['publication_date']}</td>
                            <td>
                                <a href='#' onclick='openEditModal({$row['id']}); return false;' class='btn btn-sm btn-warning'>Edit</a>
                                <a href='?action=delete&id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Delete this blog?\")'>Delete</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>

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
                            <form id="blogForm" method="POST" enctype="multipart/form-data" onsubmit="updateForm()">
                                <input type="hidden" name="id" id="blogId">
                                <div class="form-group">
                                    <label>Title *</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                        </div>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Slug *</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-link"></i></span>
                                        </div>
                                        <input type="text" name="slug" id="slug" class="form-control" required>
                                    </div>
                                    <small class="form-text text-muted">URL-friendly version of the title. Auto-generated if left empty.</small>
                                </div>
                                <div class="form-group">
                                    <label>Content *</label>
                                    <textarea name="content" id="content" class="form-control" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Excerpt</label>
                                    <textarea name="excerpt" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Author</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" name="author" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Publication Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <input type="date" name="publication_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                                                </div>
                                                <select name="status" class="form-control">
                                                    <option value="draft">Draft</option>
                                                    <option value="published">Published</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-list"></i></span>
                                                </div>
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
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tags (comma separated)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                        </div>
                                        <input type="text" name="tags" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Featured Image</label>
                                    <input type="file" name="featured_image" class="form-control">
                                    <div id="currentImage"></div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="$('#blogModal').modal('hide')">Cancel</button>
                            <button type="submit" form="blogForm" class="btn btn-success">Save Blog</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/swiper-bundle.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery.magnific-popup.min.js"></script>
    <script src="../assets/js/jquery.counterup.min.js"></script>
    <script src="../assets/js/jquery-ui.min.js"></script>
    <script src="../assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="../assets/js/isotope.pkgd.min.js"></script>
    <script src="../assets/js/gsap.min.js"></script>
    <script src="../assets/js/circle-progress.js"></script>
    <script src="../assets/js/matter.min.js"></script>
    <script src="../assets/js/matterjs-custom.js"></script>
    <script src="../assets/js/nice-select.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
        function openAddModal() {
            $('#blogForm')[0].reset();
            $('#blogId').val('');
            $('#currentImage').html('');
            $('#blogModalLabel').text('Add New Blog');
            $('#blogModal').modal('show');
            if (CKEDITOR.instances.content) {
                CKEDITOR.instances.content.destroy();
            }
            CKEDITOR.replace('content');
            $('input[name="publication_date"]').val(new Date().toISOString().split('T')[0]);
            $('select[name="status"]').val('draft');
        }

        function openEditModal(id) {
            $.get('get_blog.php?id=' + id, function(data) {
                try {
                    var blog = JSON.parse(data);
                    $('#blogId').val(blog.id);
                    $('input[name="title"]').val(blog.title);
                    $('input[name="slug"]').val(blog.slug);
                    $('textarea[name="content"]').val(blog.content);
                    $('textarea[name="excerpt"]').val(blog.excerpt);
                    $('input[name="author"]').val(blog.author);
                    $('input[name="publication_date"]').val(blog.publication_date);
                    $('select[name="status"]').val(blog.status);
                    $('select[name="category_id"]').val(blog.category_id);
                    $('input[name="tags"]').val(blog.tags ? JSON.parse(blog.tags).join(', ') : '');
                    if (blog.featured_image) {
                        $('#currentImage').html('<img src="../assets/img/blog/' + blog.featured_image + '" width="100" class="mt-2 border rounded">');
                    } else {
                        $('#currentImage').html('');
                    }
                    $('#blogModalLabel').text('Edit Blog');
                    $('#blogModal').modal('show');
                    if (CKEDITOR.instances.content) {
                        CKEDITOR.instances.content.destroy();
                    }
                    CKEDITOR.replace('content');
                } catch(e) {
                    alert('Error parsing blog data: ' + e.message);
                }
            }).fail(function() {
                alert('Error loading blog data.');
            });
        }

        function updateForm() {
            if (CKEDITOR.instances.content) {
                CKEDITOR.instances.content.updateElement();
            }
            return true;
        }

        // Auto-generate slug from title
        $(document).ready(function() {
            $('input[name="title"]').on('input', function() {
                var title = $(this).val();
                var slug = title.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                $('input[name="slug"]').val(slug);
            });

            // Image preview on change
            $('input[name="featured_image"]').on('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#currentImage').html('<img src="' + e.target.result + '" width="100" class="mt-2 border rounded"> <p>New image selected</p>');
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#currentImage').html('');
                }
            });
        });

        // Enhanced Color Switcher Fix
        jQuery(document).ready(function($) {
            // Initialize color buttons with their colors
            $(".color-switch-btns button").each(function() {
                const $button = $(this);
                const color = $button.data("color");

                // Set the button's background color preview
                $button.css("--theme-color", color);
                $button.css("background-color", color);

                // Add click handler
                $button.on("click", function() {
                    const selectedColor = $(this).data("color");

                    // Update both theme-color and primary-color CSS variables
                    $(":root").css("--theme-color", selectedColor);
                    $(":root").css("--primary-color", selectedColor);

                    // Store in localStorage for persistence
                    localStorage.setItem("theme-color", selectedColor);

                    // Add active class to clicked button
                    $(".color-switch-btns button").removeClass("active");
                    $(this).addClass("active");
                });
            });

            // Load saved color from localStorage on page load
            const savedColor = localStorage.getItem("theme-color");
            if (savedColor) {
                $(":root").css("--theme-color", savedColor);
                $(":root").css("--primary-color", savedColor);

                // Mark the corresponding button as active
                $(".color-switch-btns button").each(function() {
                    if ($(this).data("color") === savedColor) {
                        $(this).addClass("active");
                    }
                });
            }

            // Toggle color scheme panel
            $(document).on("click", ".switchIcon", function() {
                $(".color-scheme-wrap").toggleClass("active");
            });
        });
    </script>
</body>
</html>