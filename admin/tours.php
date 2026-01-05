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
        $description = trim($_POST['description']);
        $highlights = json_decode($_POST['highlights'] ?? '[]', true) ?: [];
        $included = json_decode($_POST['included'] ?? '[]', true) ?: [];
        $excluded = json_decode($_POST['excluded'] ?? '[]', true) ?: [];
        $itinerary = json_decode($_POST['itinerary'] ?? '[]', true) ?: [];
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
        if (!empty($_POST['current_images'])) {
            $images = json_decode($_POST['current_images'], true) ?: [];
        }
        if (!empty($_FILES['images']['name'][0])) {
            $upload_dir = "../assets/img/tours-image/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $filename = basename($_FILES['images']['name'][$key]);
                $target = $upload_dir . $filename;
                if (move_uploaded_file($tmp_name, $target)) {
                    $images[] = "tours-image/" . $filename;
                } else {
                    error_log("Failed to move uploaded file: " . $filename . " to " . $target);
                }
            }
        }
        $images_json = json_encode($images);

        if ($id) {
            $stmt = $pdo->prepare("UPDATE tours SET title = ?, slug = ?, description = ?, highlights = ?, included = ?, excluded = ?, itinerary = ?, pricing = ?, duration = ?, availability = ?, category_id = ?, location = ?, images = ? WHERE id = ?");
            $stmt->execute([$title, $slug, $description, json_encode($highlights), json_encode($included), json_encode($excluded), json_encode($itinerary), $pricing, $duration, $availability, $category_id, $location, $images_json, $id]);
            $_SESSION['message'] = 'Tour updated successfully!';
        } else {
            $stmt = $pdo->prepare("INSERT INTO tours (title, slug, description, highlights, included, excluded, itinerary, pricing, duration, availability, category_id, location, images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $description, json_encode($highlights), json_encode($included), json_encode($excluded), json_encode($itinerary), $pricing, $duration, $availability, $category_id, $location, $images_json]);
            $_SESSION['message'] = 'Tour added successfully!';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
    header('Location: tours.php');
    exit;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
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

        /* Fix alignment for form elements */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .input-group-text {
            min-width: 40px;
            justify-content: center;
        }

        .form-control {
            border-left: none;
        }

        .input-group .form-control:focus {
            border-color: #ced4da;
            box-shadow: none;
        }

        .input-group .input-group-text {
            border-right: none;
        }

        /* Button alignment */
        .modal-footer {
            justify-content: flex-end;
            gap: 10px;
        }

        .modal-footer .btn {
            min-width: 100px;
        }

        /* Custom file upload */
        .custom-file-upload {
            position: relative;
            display: flex;
            align-items: center;
            min-height: 38px; /* Match form-control height */
        }

        .custom-file-upload label {
            cursor: pointer;
            margin: 0;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-file-upload input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        /* Fixed styles for highlights, included, excluded, and itinerary fields */
        .dynamic-field-list {
            margin-top: 10px;
        }
        
        .dynamic-field-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .dynamic-field-item .form-control {
            flex-grow: 1;
        }
        
        .dynamic-field-item .btn {
            margin-left: 10px;
        }
        
        .itinerary-day {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .itinerary-day-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .itinerary-day-title {
            flex-grow: 1;
        }
        
        .itinerary-point {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .itinerary-point .form-control {
            flex-grow: 1;
        }
        
        .itinerary-point .btn {
            margin-left: 10px;
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
                            <th>Images</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT t.*, c.name as category_name FROM tours t LEFT JOIN categories c ON t.category_id = c.id");
                        while ($row = $stmt->fetch()) {
                            $truncatedTitle = strlen($row['title']) > 50 ? substr($row['title'], 0, 50) . '...' : $row['title'];
                            $truncatedLocation = strlen($row['location']) > 30 ? substr($row['location'], 0, 30) . '...' : $row['location'];
                            echo "<tr>
                                <td>{$truncatedTitle}</td>
                                <td>{$row['category_name']}</td>
                                <td>{$truncatedLocation}</td>
                                <td>";
                            $images = json_decode($row['images'], true);
                            if ($images && is_array($images)) {
                                foreach ($images as $img) {
                                    echo "<img src='../assets/img/{$img}' width='50' height='50' style='margin-right:5px; border-radius:5px;'>";
                                }
                            } else {
                                echo 'No images';
                            }
                            echo "</td>
                                <td>
                                    <a href='#' onclick='openEditModal(" . $row['id'] . "); return false;' class='btn btn-sm btn-warning'>Edit</a>
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
            <form id="tourForm" method="POST" enctype="multipart/form-data" onsubmit="updateHiddenFields()">
              <input type="hidden" name="id" id="tourId">
              <input type="hidden" name="current_images" id="currentImagesInput">
              <input type="hidden" name="cropped_images" id="croppedImagesInput">
              <input type="hidden" name="highlights" id="highlightsInput">
              <input type="hidden" name="included" id="includedInput">
              <input type="hidden" name="excluded" id="excludedInput">
              <input type="hidden" name="itinerary" id="itineraryInput">
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
              
              <!-- Tour Highlights Section -->
              <div class="form-group">
                <label>Tour Highlights</label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-star"></i></span>
                  </div>
                  <input type="text" id="highlightInput" class="form-control" placeholder="Enter highlight">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-outline-primary" onclick="addHighlightFromInput()">Add</button>
                  </div>
                </div>
                <div id="highlightsList" class="dynamic-field-list"></div>
              </div>
              
              <!-- Included Section -->
              <div class="form-group">
                <label>Included</label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                  </div>
                  <input type="text" id="includedItemInput" class="form-control" placeholder="Enter included item">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-outline-primary" onclick="addIncludedFromInput()">Add</button>
                  </div>
                </div>
                <div id="includedList" class="dynamic-field-list"></div>
              </div>
              
              <!-- Excluded Section -->
              <div class="form-group">
                <label>Excluded</label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-times-circle"></i></span>
                  </div>
                  <input type="text" id="excludedItemInput" class="form-control" placeholder="Enter excluded item">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-outline-primary" onclick="addExcludedFromInput()">Add</button>
                  </div>
                </div>
                <div id="excludedList" class="dynamic-field-list"></div>
              </div>
              
              <!-- Itinerary Section -->
              <div class="form-group">
                <label>Itinerary</label>
                <div id="itineraryContainer"></div>
                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addDay()">Add Day</button>
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
                <label>Images (multiple allowed, max 5)</label>
                <div class="custom-file-upload">
                  <input type="file" name="images[]" multiple class="form-control-file d-none" id="imageInput" accept="image/*">
                  <label for="imageInput" class="btn btn-outline-primary btn-block d-flex align-items-center justify-content-center">
                    <i class="fas fa-images mr-2"></i> Choose Images
                  </label>
                </div>
                <div id="cropperContainer" style="display: none; margin-top: 10px;">
                  <img id="cropperImage" style="max-width: 100%; max-height: 400px;">
                  <div class="mt-2">
                    <button type="button" class="btn btn-success btn-sm" id="cropBtn">Crop & Add</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="cancelCropBtn">Cancel</button>
                  </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        function openAddModal() {
            $('#tourForm')[0].reset();
            $('#tourId').val('');
            currentImages = [];
            $('#currentImagesInput').val('[]');
            $('#currentImages').html('');
            $('#imageInput').val('');
            $('#tourModalLabel').text('Add New Tour');
            $('#tourModal').modal('show');
            highlights = [];
            included = [];
            excluded = [];
            itinerary = [];
            renderHighlights();
            renderIncluded();
            renderExcluded();
            renderItinerary();
        }

        // Initialize all arrays to prevent undefined errors
        var currentImages = [];
        var croppedImages = [];
        var highlights = [];
        var included = [];
        var excluded = [];
        var itinerary = [];

        function openEditModal(id) {
            $.get('get_tour.php?id=' + id, function(data) {
                try {
                    var response;
                    // Handle both string and object responses
                    if (typeof data === 'string') {
                        try {
                            response = JSON.parse(data);
                        } catch(e) {
                            alert('Error parsing server response: ' + e.message);
                            return;
                        }
                    } else {
                        response = data;
                    }
                    
                    if (response.success === false) {
                        alert(response.message || 'Tour not found');
                        return;
                    }
                    
                    if (!response.data) {
                        alert('No tour data received');
                        return;
                    }
                    
                    var tour = response.data;
                    
                    // Initialize all arrays to prevent undefined errors
                    highlights = [];
                    included = [];
                    excluded = [];
                    itinerary = [];
                    currentImages = [];
                    
                    // Set form values
                    $('#tourId').val(tour.id || '');
                    $('input[name="title"]').val(tour.title || '');
                    $('input[name="slug"]').val(tour.slug || '');
                    $('textarea[name="description"]').val(tour.description || '');
                    $('input[name="pricing"]').val(tour.pricing || '');
                    $('input[name="duration"]').val(tour.duration || '');
                    $('input[name="availability"]').val(tour.availability || '');
                    $('select[name="category_id"]').val(tour.category_id || '');
                    $('input[name="location"]').val(tour.location || '');
                    
                    // Safely parse JSON fields with fallbacks
                    try {
                        highlights = JSON.parse(tour.highlights || '[]');
                        if (!Array.isArray(highlights)) highlights = [];
                    } catch(e) {
                        highlights = [];
                        console.warn('Failed to parse highlights:', e.message);
                    }
                    
                    try {
                        included = JSON.parse(tour.included || '[]');
                        if (!Array.isArray(included)) included = [];
                    } catch(e) {
                        included = [];
                        console.warn('Failed to parse included:', e.message);
                    }
                    
                    try {
                        excluded = JSON.parse(tour.excluded || '[]');
                        if (!Array.isArray(excluded)) excluded = [];
                    } catch(e) {
                        excluded = [];
                        console.warn('Failed to parse excluded:', e.message);
                    }
                    
                    try {
                        itinerary = JSON.parse(tour.itinerary || '[]');
                        if (!Array.isArray(itinerary)) itinerary = [];
                        // Normalize itinerary to array of objects
                        itinerary = itinerary.map(function(day) {
                            if (typeof day === 'string') {
                                return {title: day, points: []};
                            } else if (day && typeof day === 'object' && day.title) {
                                return day;
                            } else {
                                return {title: 'Day', points: []};
                            }
                        });
                    } catch(e) {
                        itinerary = [];
                        console.warn('Failed to parse itinerary:', e.message);
                    }
                    
                    try {
                        currentImages = JSON.parse(tour.images || '[]');
                        if (!Array.isArray(currentImages)) currentImages = [];
                    } catch(e) {
                        currentImages = [];
                        console.warn('Failed to parse images:', e.message);
                    }
                    
                    // Render all sections
                    renderHighlights();
                    renderIncluded();
                    renderExcluded();
                    renderItinerary();
                    
                    // Reset cropped images
                    croppedImages = [];
                    $('#currentImagesInput').val(JSON.stringify(currentImages));
                    $('#croppedImagesInput').val('[]');
                    renderCurrentImages();
                    
                    $('#tourModalLabel').text('Edit Tour');
                    $('#tourModal').modal('show');
                } catch(e) {
                    console.error('Error in openEditModal:', e);
                    alert('Error processing tour data: ' + e.message);
                }
            }).fail(function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Error loading tour data. Please try again.');
            });
        }

        function renderCurrentImages() {
            var html = '';
            currentImages.forEach(function(img, index) {
                html += '<div class="d-inline-block mr-2 mb-2 position-relative">';
                html += '<img src="' + (img.startsWith('data:') ? img : '../assets/img/' + img) + '" width="100" height="100" style="object-fit: cover;" class="border rounded">';
                html += '<button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 0; right: 0;" onclick="deleteImage(' + index + ')">&times;</button>';
                html += '</div>';
            });
            $('#currentImages').html(html);
        }

        function deleteImage(index) {
            currentImages.splice(index, 1);
            $('#currentImagesInput').val(JSON.stringify(currentImages));
            renderCurrentImages();
        }

        // Highlights
        function renderHighlights() {
            var html = '';
            highlights.forEach(function(item, index) {
                html += '<div class="dynamic-field-item">';
                html += '<div class="input-group">';
                html += '<div class="input-group-prepend">';
                html += '<span class="input-group-text"><i class="fas fa-star"></i></span>';
                html += '</div>';
                html += '<input type="text" class="form-control" value="' + (item || '').replace(/"/g, '"') + '" onchange="updateHighlight(' + index + ', this.value)">';
                html += '<div class="input-group-append">';
                html += '<button type="button" class="btn btn-outline-danger" onclick="deleteHighlight(' + index + ')"><i class="fas fa-trash"></i></button>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            });
            $('#highlightsList').html(html);
            $('#highlightsInput').val(JSON.stringify(highlights));
        }

        function addHighlightFromInput() {
            var value = $('#highlightInput').val().trim();
            if (value) {
                highlights.push(value);
                $('#highlightInput').val('');
                renderHighlights();
            }
        }
        
        function updateHighlight(index, value) {
            highlights[index] = value;
            $('#highlightsInput').val(JSON.stringify(highlights));
        }

        function deleteHighlight(index) {
            highlights.splice(index, 1);
            renderHighlights();
        }

        // Included
        function renderIncluded() {
            var html = '';
            included.forEach(function(item, index) {
                html += '<div class="dynamic-field-item">';
                html += '<div class="input-group">';
                html += '<div class="input-group-prepend">';
                html += '<span class="input-group-text"><i class="fas fa-check-circle"></i></span>';
                html += '</div>';
                html += '<input type="text" class="form-control" value="' + (item || '').replace(/"/g, '"') + '" onchange="updateIncluded(' + index + ', this.value)">';
                html += '<div class="input-group-append">';
                html += '<button type="button" class="btn btn-outline-danger" onclick="deleteIncluded(' + index + ')"><i class="fas fa-trash"></i></button>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            });
            $('#includedList').html(html);
            $('#includedInput').val(JSON.stringify(included));
        }

        function addIncludedFromInput() {
            var value = $('#includedItemInput').val().trim();
            if (value) {
                included.push(value);
                $('#includedItemInput').val('');
                renderIncluded();
            }
        }
        
        function updateIncluded(index, value) {
            included[index] = value;
            $('#includedInput').val(JSON.stringify(included));
        }

        function deleteIncluded(index) {
            included.splice(index, 1);
            renderIncluded();
        }

        // Excluded
        function renderExcluded() {
            var html = '';
            excluded.forEach(function(item, index) {
                html += '<div class="dynamic-field-item">';
                html += '<div class="input-group">';
                html += '<div class="input-group-prepend">';
                html += '<span class="input-group-text"><i class="fas fa-times-circle"></i></span>';
                html += '</div>';
                html += '<input type="text" class="form-control" value="' + (item || '').replace(/"/g, '"') + '" onchange="updateExcluded(' + index + ', this.value)">';
                html += '<div class="input-group-append">';
                html += '<button type="button" class="btn btn-outline-danger" onclick="deleteExcluded(' + index + ')"><i class="fas fa-trash"></i></button>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            });
            $('#excludedList').html(html);
            $('#excludedInput').val(JSON.stringify(excluded));
        }

        function addExcludedFromInput() {
            var value = $('#excludedItemInput').val().trim();
            if (value) {
                excluded.push(value);
                $('#excludedItemInput').val('');
                renderExcluded();
            }
        }
        
        function updateExcluded(index, value) {
            excluded[index] = value;
            $('#excludedInput').val(JSON.stringify(excluded));
        }

        function deleteExcluded(index) {
            excluded.splice(index, 1);
            renderExcluded();
        }

        // Itinerary
        function renderItinerary() {
            var html = '';
            itinerary.forEach(function(day, dayIndex) {
                html += '<div class="itinerary-day">';
                html += '<div class="itinerary-day-header">';
                html += '<div class="input-group itinerary-day-title">';
                html += '<div class="input-group-prepend">';
                html += '<span class="input-group-text"><i class="fas fa-calendar-day"></i></span>';
                html += '</div>';
                html += '<input type="text" class="form-control" placeholder="Day Title" value="' + (day.title || '').replace(/"/g, '"') + '" onchange="updateDayTitle(' + dayIndex + ', this.value)">';
                html += '<div class="input-group-append">';
                html += '<button type="button" class="btn btn-outline-danger" onclick="deleteDay(' + dayIndex + ')"><i class="fas fa-trash"></i></button>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '<div class="itinerary-points">';
                day.points.forEach(function(point, pointIndex) {
                    html += '<div class="itinerary-point">';
                    html += '<div class="input-group">';
                    html += '<div class="input-group-prepend">';
                    html += '<span class="input-group-text"><i class="fas fa-map-pin"></i></span>';
                    html += '</div>';
                    html += '<input type="text" class="form-control" value="' + (point || '').replace(/"/g, '"') + '" onchange="updatePoint(' + dayIndex + ', ' + pointIndex + ', this.value)">';
                    html += '<div class="input-group-append">';
                    html += '<button type="button" class="btn btn-outline-danger" onclick="deletePoint(' + dayIndex + ', ' + pointIndex + ')"><i class="fas fa-trash"></i></button>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                });
                html += '<button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addPoint(' + dayIndex + ')">Add Point</button>';
                html += '</div>';
                html += '</div>';
            });
            $('#itineraryContainer').html(html);
            $('#itineraryInput').val(JSON.stringify(itinerary));
        }

        function addDay() {
            itinerary.push({title: 'Day ' + (itinerary.length + 1), points: []});
            renderItinerary();
        }

        function updateDayTitle(dayIndex, value) {
            itinerary[dayIndex].title = value;
            $('#itineraryInput').val(JSON.stringify(itinerary));
        }

        function deleteDay(dayIndex) {
            itinerary.splice(dayIndex, 1);
            renderItinerary();
        }

        function addPoint(dayIndex) {
            itinerary[dayIndex].points.push('');
            renderItinerary();
        }

        function updatePoint(dayIndex, pointIndex, value) {
            itinerary[dayIndex].points[pointIndex] = value;
            $('#itineraryInput').val(JSON.stringify(itinerary));
        }

        function deletePoint(dayIndex, pointIndex) {
            itinerary[dayIndex].points.splice(pointIndex, 1);
            renderItinerary();
        }

        let cropper;
        let currentFile;

        $('#imageInput').on('change', function(e) {
            const files = Array.from(e.target.files);
            if (files.length > 0) {
                if (currentImages.length + files.length > 5) {
                    alert('Maximum 5 images allowed per tour.');
                    $('#imageInput').val('');
                    return;
                }
                // Add previews for all selected files
                files.forEach(function(file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        currentImages.push(e.target.result);
                        renderCurrentImages();
                    };
                    reader.readAsDataURL(file);
                });
                // Crop the first file
                currentFile = files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#cropperImage').attr('src', e.target.result);
                    $('#cropperContainer').show();
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper($('#cropperImage')[0], {
                        aspectRatio: 16 / 9, // Adjust as needed for tour cards
                        viewMode: 1,
                        responsive: true,
                        restore: false,
                        checkCrossOrigin: false,
                        checkOrientation: false,
                        modal: true,
                        guides: true,
                        center: true,
                        highlight: false,
                        background: false,
                        autoCrop: true,
                        autoCropArea: 0.8
                    });
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $('#cropBtn').on('click', function() {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas({
                    width: 600, // Reduced size for smaller file
                    height: 342 // Maintain aspect ratio
                });
                const dataURL = canvas.toDataURL('image/webp', 0.7);
                canvas.toBlob(function(blob) {
                    const timestamp = Date.now();
                    const croppedFile = new File([blob], 'cropped_' + timestamp + '_' + currentFile.name, { type: 'image/webp' });
                    const files = Array.from($('#imageInput')[0].files);
                    files[0] = croppedFile;
                    $('#imageInput')[0].files = new FileListItems(files);
                    // Replace the first preview with cropped
                    if (currentImages.length > 0) {
                        currentImages[0] = dataURL;
                    }
                    renderCurrentImages();
                    $('#cropperContainer').hide();
                    cropper.destroy();
                    cropper = null;
                }, 'image/webp', 0.7); // Quality 0.7 for smaller file size
            }
        });

        $('#cancelCropBtn').on('click', function() {
            $('#cropperContainer').hide();
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });

        // Helper for FileList
        function FileListItems(files) {
            const b = new ClipboardEvent("").clipboardData || new DataTransfer();
            for (let i = 0, len = files.length; i < len; i++) b.items.add(files[i]);
            return b.files;
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

        function updateHiddenFields() {
            $('#highlightsInput').val(JSON.stringify(highlights));
            $('#includedInput').val(JSON.stringify(included));
            $('#excludedInput').val(JSON.stringify(excluded));
            $('#itineraryInput').val(JSON.stringify(itinerary));
            return true;
        }
    </script>
</body>
</html>