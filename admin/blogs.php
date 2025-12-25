<?php
session_start();
require_once '../config.php';
checkAdminLogin();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $id = $_POST['id'] ?? null;
        $title = trim($_POST['title']);
        $slug = trim($_POST['slug']);
        $content = $_POST['content'];
        $author = trim($_POST['author']);
        $publication_date = $_POST['publication_date'];
        $tags = array_map('trim', explode(',', $_POST['tags']));
        $tags_json = json_encode($tags);
        $categories = $_POST['categories'] ?? [];
        $categories_json = json_encode($categories);

        // Generate slug if empty
        if (empty($slug)) {
            $slug = generateSlug($title, 'blogs', $id);
        }

        $featured_image = '';
        if (!empty($_FILES['featured_image']['name'])) {
            $filename = basename($_FILES['featured_image']['name']);
            $target = "../assets/img/blogs/" . $filename;
            if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
                $featured_image = $filename;
            }
        }

        if ($id) {
            $stmt = $pdo->prepare("UPDATE blogs SET title = ?, slug = ?, content = ?, author = ?, publication_date = ?, tags = ?, categories = ?, featured_image = ? WHERE id = ?");
            $stmt->execute([$title, $slug, $content, $author, $publication_date, $tags_json, $categories_json, $featured_image ?: null, $id]);
            $message = 'Blog updated successfully!';
        } else {
            $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, content, author, publication_date, tags, categories, featured_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $content, $author, $publication_date, $tags_json, $categories_json, $featured_image]);
            $message = 'Blog added successfully!';
        }
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
    }
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

$action = $_GET['action'] ?? '';
$blog = null;
if ($action == 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $blog = $stmt->fetch();
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
            <h2 class="page-title">Blogs Management</h2>
                <?php if ($message): ?>
                    <div class="alert alert-info"><?php echo $message; ?></div>
                <?php endif; ?>
                <a href="?action=add" class="btn btn-primary mb-3">Add New Blog</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Publication Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC");
                        while ($row = $stmt->fetch()) {
                            echo "<tr>
                                <td>{$row['title']}</td>
                                <td>{$row['author']}</td>
                                <td>{$row['publication_date']}</td>
                                <td>
                                    <a href='?action=edit&id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                                    <a href='?action=delete&id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Delete this blog?\")'>Delete</a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <?php if (in_array($action, ['add', 'edit'])): ?>
                <h3><?php echo $action == 'edit' ? 'Edit' : 'Add'; ?> Blog</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $blog['id'] ?? ''; ?>">
                    <div class="form-group">
                        <label>Title *</label>
                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($blog['title'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Slug *</label>
                        <input type="text" name="slug" id="slug" class="form-control" value="<?php echo htmlspecialchars($blog['slug'] ?? ''); ?>" required>
                        <small class="form-text text-muted">URL-friendly version of the title. Auto-generated if left empty.</small>
                    </div>
                    <div class="form-group">
                        <label>Content *</label>
                        <textarea name="content" id="content" class="form-control" rows="10"><?php echo htmlspecialchars($blog['content'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" name="author" class="form-control" value="<?php echo htmlspecialchars($blog['author'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Publication Date</label>
                        <input type="date" name="publication_date" class="form-control" value="<?php echo $blog['publication_date'] ?? date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <label>Tags (comma separated)</label>
                        <input type="text" name="tags" class="form-control" value="<?php echo $blog ? implode(', ', json_decode($blog['tags'], true)) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Categories</label>
                        <select name="categories[]" multiple class="form-control">
                            <?php
                            $cat_stmt = $pdo->query("SELECT * FROM categories WHERE type = 'blog'");
                            $selected_cats = $blog ? json_decode($blog['categories'], true) : [];
                            while ($cat = $cat_stmt->fetch()) {
                                $selected = in_array($cat['name'], $selected_cats) ? 'selected' : '';
                                echo "<option value='{$cat['name']}' $selected>{$cat['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Featured Image</label>
                        <input type="file" name="featured_image" class="form-control">
                        <?php if ($blog && $blog['featured_image']): ?>
                            <img src="../assets/img/blogs/<?php echo $blog['featured_image']; ?>" width="100" class="mt-2">
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-success">Save Blog</button>
                    <a href="blogs.php" class="btn btn-secondary">Cancel</a>
                </form>
                <script>CKEDITOR.replace('content');</script>
                <?php endif; ?>
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
        // Auto-generate slug from title
        $(document).ready(function() {
            $('input[name="title"]').on('input', function() {
                var title = $(this).val();
                var slug = title.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                $('input[name="slug"]').val(slug);
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