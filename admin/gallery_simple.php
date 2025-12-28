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
            $alt_text = trim($_POST['alt_text']);
            $filename = '';
            
            // Handle file upload
            if (!empty($_FILES['image']['name'])) {
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($_FILES['image']['type'], $allowed_types)) {
                    throw new Exception('Invalid file type. Only JPEG, PNG, GIF, WEBP allowed.');
                }
                
                // Create directory if it doesn't exist
                $gallery_dir = "../assets/img/gallery/";
                if (!is_dir($gallery_dir)) {
                    mkdir($gallery_dir, 0755, true);
                }
                
                // Generate filename
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = time() . '_' . uniqid() . '.' . $ext;
                $target = $gallery_dir . $filename;
                
                // Move uploaded file
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    throw new Exception('Failed to upload image. Check directory permissions.');
                }
            }
            
            if ($id) {
                $query = "UPDATE gallery_images SET alt_text = ?";
                $params = [$alt_text];
                if ($filename) {
                    // Get old filename to delete it
                    $stmt = $pdo->prepare("SELECT filename FROM gallery_images WHERE id = ?");
                    $stmt->execute([$id]);
                    $old_image = $stmt->fetch();
                    
                    if ($old_image && file_exists("../assets/img/gallery/" . $old_image['filename'])) {
                        unlink("../assets/img/gallery/" . $old_image['filename']);
                    }
                    
                    $query .= ", filename = ?";
                    $params[] = $filename;
                }
                $query .= " WHERE id = ?";
                $params[] = $id;
                $stmt = $pdo->prepare($query);
                $stmt->execute($params);
                $message = 'Image updated successfully!';
            } else {
                if (!$filename) {
                    throw new Exception('Image file is required');
                }
                $stmt = $pdo->prepare("INSERT INTO gallery_images (filename, alt_text) VALUES (?, ?)");
                $stmt->execute([$filename, $alt_text]);
                $message = 'Image added successfully!';
            }
            echo json_encode(['success' => true, 'message' => $message]);
        } catch (Exception $e) {
            error_log('Gallery upload error: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("SELECT filename FROM gallery_images WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $image = $stmt->fetch();
        if ($image) {
            $file_path = "../assets/img/gallery/" . $image['filename'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $stmt = $pdo->prepare("DELETE FROM gallery_images WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $message = 'Image deleted successfully!';
        } else {
            $message = 'Image not found!';
        }
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
    <title>Gallery Management - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .drop-zone {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        .drop-zone:hover {
            border-color: #007bff;
            background-color: rgba(0, 123, 255, 0.05);
        }
        .drop-zone.dragover {
            border-color: #007bff;
            background-color: rgba(0, 123, 255, 0.1);
        }
        .file-input {
            display: none;
        }
        .current-image-container {
            margin-top: 10px;
            text-align: center;
        }
        .current-image-container img {
            max-width: 200px;
            max-height: 150px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <?php include 'header.php'; ?>
    <div class="main-content">
        <div class="content-wrapper">
            <div class="d-flex mb-3 justify-content-between align-items-center">
                <h1 class="page-title">Gallery Management</h1>
                <?php if ($message): ?>
                    <div class="alert alert-info"><?php echo $message; ?></div>
                <?php endif; ?>
                <button type="button" class="btn btn-primary mb-3" onclick="openAddModal()" aria-label="Add new image">Add New Image</button>
            </div>
            <input type="text" id="search" placeholder="Search images..." class="form-control mb-3">
            <button id="bulkDelete" class="btn btn-danger mb-3">Delete Selected</button>
            <table class="table table-striped">
                 <thead>
                     <tr>
                         <th><input type="checkbox" id="selectAll"></th>
                         <th>Image Preview</th>
                         <th>Alt Text</th>
                         <th>Actions</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                     $stmt = $pdo->query("SELECT id, filename, alt_text FROM gallery_images ORDER BY created_at DESC");
                     while ($row = $stmt->fetch()) {
                         echo "<tr>
                             <td><input type='checkbox' class='bulk-check' data-id='{$row['id']}'></td>
                             <td><img src='../assets/img/gallery/{$row['filename']}' width='100' alt='{$row['alt_text']}'></td>
                             <td>" . ($row['alt_text'] ? htmlspecialchars($row['alt_text']) : '<span class="text-muted">No alt text</span>') . "</td>
                             <td>
                                 <a href='#' onclick='openEditModal({$row['id']})' class='btn btn-sm btn-warning'>Edit</a>
                                 <a href='?action=delete&id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Delete this image?\")'>Delete</a>
                             </td>
                         </tr>";
                     }
                     ?>
                 </tbody>
             </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="galleryModalLabel">Add New Image</h5>
            <button type="button" class="close" onclick="$('#galleryModal').modal('hide')" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
             <form id="galleryForm" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="id" id="imageId">
               <div class="form-group">
                 <label>Image Alt Text</label>
                 <div class="input-group">
                   <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fas fa-text"></i></span>
                   </div>
                   <input type="text" name="alt_text" class="form-control" placeholder="Enter alt text for accessibility">
                 </div>
               </div>
               <div class="form-group">
                 <label>Image *</label>
                 <div id="dropZone" class="drop-zone">
                     <input type="file" name="image" accept="image/*" class="file-input" id="imageInput">
                     <div class="drop-zone-content">
                         <i class="fas fa-cloud-upload-alt fa-3x mb-3"></i>
                         <p>Click to select or drag and drop image here</p>
                         <p class="text-muted small">Supported formats: JPEG, PNG, GIF, WebP</p>
                     </div>
                 </div>
                 <div id="currentImage" class="current-image-container"></div>
               </div>
             </form>
           </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="$('#galleryModal').modal('hide')">Cancel</button>
            <button type="submit" form="galleryForm" class="btn btn-success">Save Image</button>
          </div>
        </div>
      </div>
    </div>

    <script src="../assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script>
        function openAddModal() {
            $('#galleryForm')[0].reset();
            $('#imageId').val('');
            $('#currentImage').html('');
            $('#galleryModalLabel').text('Add New Image');
            $('#galleryModal').modal('show');
        }

        function openEditModal(id) {
            $.get('get_gallery.php?id=' + id, function(data) {
                var image = JSON.parse(data);
                $('#imageId').val(image.id);
                $('input[name="alt_text"]').val(image.alt_text || '');
                $('#currentImage').html('<img src="../assets/img/gallery/' + image.filename + '" alt="' + (image.alt_text || '') + '"><p>Current image (select new image to replace)</p>');
                $('#galleryModalLabel').text('Edit Image');
                $('#galleryModal').modal('show');
            });
        }

        $('#galleryForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            
            // Check if file is selected for new images
            if (!$('#imageId').val() && !formData.get('image')) {
                alert('Please select an image to upload');
                return;
            }
            
            sendForm(formData);
        });
        
        function sendForm(formData) {
            // Show loading state
            var submitBtn = $('button[type="submit"][form="galleryForm"]');
            var originalText = submitBtn.text();
            submitBtn.prop('disabled', true).text('Saving...');
            
            $.ajax({
                url: 'gallery_simple.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    try {
                        var res = JSON.parse(response);
                        alert(res.message);
                        if (res.success) {
                            $('#galleryModal').modal('hide');
                            location.reload();
                        }
                    } catch (e) {
                        console.error('Error parsing response:', response);
                        alert('Server returned invalid response. Please check the console for details.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });
                    
                    try {
                        var errorResponse = JSON.parse(xhr.responseText);
                        alert('Error: ' + errorResponse.message);
                    } catch (e) {
                        alert('Error occurred while saving. Please check the console for details.');
                    }
                },
                complete: function() {
                    // Restore button state
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        }

        $(document).ready(function() {
            // File input change handler
            $('#imageInput').change(function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#currentImage').html('<img src="' + e.target.result + '" alt="Selected image"><p>Selected: ' + file.name + '</p>');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Drag and drop functionality
            $('#dropZone').on('dragover', function(e) {
                e.preventDefault();
                $(this).addClass('dragover');
            });

            $('#dropZone').on('dragleave', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');
            });

            $('#dropZone').on('drop', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');
                var files = e.originalEvent.dataTransfer.files;
                if (files.length) {
                    $('#imageInput')[0].files = files;
                    $('#imageInput').trigger('change');
                }
            });

            // Click to select file
            $('#dropZone').click(function() {
                $('#imageInput').click();
            });

            $('#search').on('input', function() {
                var query = $(this).val().toLowerCase();
                $('tbody tr').each(function() {
                    var text = $(this).text().toLowerCase();
                    $(this).toggle(text.includes(query));
                });
            });

            $('#selectAll').change(function() {
                $('.bulk-check').prop('checked', this.checked);
            });

            $('#bulkDelete').click(function() {
                var ids = [];
                $('.bulk-check:checked').each(function() {
                    ids.push($(this).data('id'));
                });
                if (ids.length && confirm('Delete selected images?')) {
                    ids.forEach(id => {
                        window.location = '?action=delete&id=' + id;
                    });
                }
            });
        });
    </script>
</body>
</html>