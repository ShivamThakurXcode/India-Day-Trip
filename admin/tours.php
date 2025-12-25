<?php
session_start();
require_once '../config.php';
checkAdminLogin();

$message = '';

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $id = $_POST['id'] ?? null;
            $title = trim($_POST['title']);
            $slug = trim($_POST['slug']);
            $description = trim($_POST['description']);
            $itinerary = trim($_POST['itinerary']);
            $pricing = $_POST['pricing'] ?: null;
            $duration = trim($_POST['duration']);
            $availability = (int)$_POST['availability'];
            $category_id = $_POST['category_id'] ?: null;
            $location = trim($_POST['location']);

            // Generate slug if empty or auto-generate
            if (empty($slug)) {
                $slug = generateSlug($title, 'tours', $id);
            }

            $images = [];
            if (!empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    $filename = basename($_FILES['images']['name'][$key]);
                    $target = "../assets/img/tours/" . $filename;
                    if (move_uploaded_file($tmp_name, $target)) {
                        $images[] = $filename;
                    }
                }
            }
            $images_json = json_encode($images);

            if ($id) {
                $stmt = $pdo->prepare("UPDATE tours SET title = ?, slug = ?, description = ?, itinerary = ?, pricing = ?, duration = ?, availability = ?, category_id = ?, location = ?, images = ? WHERE id = ?");
                $stmt->execute([$title, $slug, $description, $itinerary, $pricing, $duration, $availability, $category_id, $location, $images_json, $id]);
                $message = 'Tour updated successfully!';
            } else {
                $stmt = $pdo->prepare("INSERT INTO tours (title, slug, description, itinerary, pricing, duration, availability, category_id, location, images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$title, $slug, $description, $itinerary, $pricing, $duration, $availability, $category_id, $location, $images_json]);
                $message = 'Tour added successfully!';
            }
            echo json_encode(['success' => true, 'message' => $message]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM tours WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $message = 'Tour deleted successfully!';
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
    <title>Tours Management - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="../assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
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
        
        .input-group-text{
          height: 100%;
        }
        .modal-content {
            height: 100%;
            overflow: hidden;
        }
        .modal-body {
            height: calc(100% - 120px); /* Adjust for header and footer */
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <?php include 'header.php'; ?>
    <div class="main-content">
        <div class="content-wrapper">
            <div class="d-flex mb-3 justify-content-between align-items-center">
                <h1 class="page-title">Tours Management</h1>
                <?php if ($message): ?>
                    <div class="alert alert-info"><?php echo $message; ?></div>
                <?php endif; ?>
                <button type="button" class="btn btn-primary mb-3" onclick="openAddModal()" aria-label="Add new tour">Add New Tour</button> </div>
         
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT t.*, c.name as category_name FROM tours t LEFT JOIN categories c ON t.category_id = c.id");
                        while ($row = $stmt->fetch()) {
                            echo "<tr>
                                <td>{$row['title']}</td>
                                <td>{$row['category_name']}</td>
                                <td>{$row['location']}</td>
                                <td>
                                    <a href='#' onclick='openEditModal({$row['id']})' class='btn btn-sm btn-warning'>Edit</a>
                                    <a href='?action=delete&id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Delete this tour?\")'>Delete</a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tourModal" tabindex="-1" role="dialog" aria-labelledby="tourModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tourModalLabel">Add New Tour</h5>
            <button type="button" class="close" onclick="$('#tourModal').modal('hide')" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="tourForm" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="id" id="tourId">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Title *</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                      </div>
                      <input type="text" name="title" class="form-control" required>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
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
                </div>
              </div>
              <div class="form-group">
                <label>Description</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                  </div>
                  <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label>Itinerary</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-route"></i></span>
                  </div>
                  <textarea name="itinerary" class="form-control" rows="5"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Pricing</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                      </div>
                      <input type="number" step="0.01" name="pricing" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Duration</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                      </div>
                      <input type="text" name="duration" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Availability</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-users"></i></span>
                      </div>
                      <input type="number" name="availability" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
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
                        $cat_stmt = $pdo->query("SELECT * FROM categories WHERE type = 'tour'");
                        while ($cat = $cat_stmt->fetch()) {
                          echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Location</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                      </div>
                      <input type="text" name="location" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Images (multiple allowed)</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-images"></i></span>
                  </div>
                  <input type="file" name="images[]" multiple class="form-control">
                </div>
                <div id="currentImages"></div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="$('#tourModal').modal('hide')">Cancel</button>
            <button type="submit" form="tourForm" class="btn btn-success">Save Tour</button>
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
            $('#tourForm')[0].reset();
            $('#tourId').val('');
            $('#currentImages').html('');
            $('#tourModalLabel').text('Add New Tour');
            $('#tourModal').modal('show');
        }

        function openEditModal(id) {
            $.get('get_tour.php?id=' + id, function(data) {
                var tour = JSON.parse(data);
                $('#tourId').val(tour.id);
                $('input[name="title"]').val(tour.title);
                $('input[name="slug"]').val(tour.slug);
                $('textarea[name="description"]').val(tour.description);
                $('textarea[name="itinerary"]').val(tour.itinerary);
                $('input[name="pricing"]').val(tour.pricing);
                $('input[name="duration"]').val(tour.duration);
                $('input[name="availability"]').val(tour.availability);
                $('select[name="category_id"]').val(tour.category_id);
                $('input[name="location"]').val(tour.location);
                // images
                var imgs = JSON.parse(tour.images || '[]');
                var html = '';
                imgs.forEach(function(img) {
                    html += '<img src="../assets/img/tours/' + img + '" width="100" class="mr-2">';
                });
                $('#currentImages').html(html);
                $('#tourModalLabel').text('Edit Tour');
                $('#tourModal').modal('show');
            });
        }

        $('#tourForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: 'tours.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var res = JSON.parse(response);
                    alert(res.message);
                    if (res.success) {
                        $('#tourModal').modal('hide');
                        location.reload();
                    }
                },
                error: function() {
                    alert('Error occurred');
                }
            });
        });

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