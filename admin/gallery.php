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
            $description = trim($_POST['description']);
            $alt_text = trim($_POST['alt_text']);
            $tags = array_map('trim', explode(',', $_POST['tags'] ?? ''));
            $tags_json = json_encode(array_filter($tags));
            $filename = '';
            if (!empty($_FILES['image']['name'])) {
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($_FILES['image']['type'], $allowed_types)) {
                    throw new Exception('Invalid file type. Only JPEG, PNG, GIF, WEBP allowed.');
                }
                $max_size = 5 * 1024 * 1024; // 5MB
                if ($_FILES['image']['size'] > $max_size) {
                    throw new Exception('File too large. Max 5MB.');
                }
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = time() . '_' . uniqid() . '.' . $ext;
                $target = "../assets/img/gallery/" . $filename;
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    throw new Exception('Failed to upload image');
                }
            }
            if ($id) {
                $query = "UPDATE gallery_images SET title = ?, description = ?, alt_text = ?, tags = ?";
                $params = [$title, $description, $alt_text, $tags_json];
                if ($filename) {
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
                $stmt = $pdo->prepare("INSERT INTO gallery_images (filename, title, description, alt_text, tags) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$filename, $title, $description, $alt_text, $tags_json]);
                $message = 'Image added successfully!';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <style>
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
        #dropZone {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            margin-bottom: 10px;
        }
        #dropZone.dragover {
            border-color: #007bff;
        }
        #cropperContainer {
            margin-top: 10px;
        }
        #cropperImage {
            max-width: 100%;
            max-height: 400px;
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
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM gallery_images ORDER BY created_at DESC");
                    while ($row = $stmt->fetch()) {
                        echo "<tr>
                            <td><input type='checkbox' class='bulk-check' data-id='{$row['id']}'></td>
                            <td><img src='../assets/img/gallery/{$row['filename']}' width='100' alt='{$row['alt_text']}'></td>
                            <td>{$row['title']}</td>
                            <td>" . substr($row['description'], 0, 50) . "...</td>
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
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="galleryForm" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="id" id="imageId">
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
                <label>Description</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                  </div>
                  <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label>Alt Text</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-text"></i></span>
                  </div>
                  <input type="text" name="alt_text" class="form-control">
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
                <label>Image *</label>
                <div id="dropZone">
                    Drag and drop image here or click to select
                    <input type="file" name="image" accept="image/*" style="display:none;">
                </div>
                <div id="currentImage"></div>
                <div id="cropperContainer" style="display:none;">
                    <img id="cropperImage">
                    <div style="margin-top:10px;">
                        <button type="button" class="btn btn-sm btn-secondary" onclick="setAspectRatio(1)">Square (1:1)</button>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="setAspectRatio(16/9)">Banner (16:9)</button>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="setAspectRatio(4/3)">Standard (4:3)</button>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="setAspectRatio(NaN)">Free</button>
                    </div>
                </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        var cropper;
        function openAddModal() {
            $('#galleryForm')[0].reset();
            $('#imageId').val('');
            $('#currentImage').html('');
            $('#cropperContainer').hide();
            if (cropper) cropper.destroy();
            $('#galleryModalLabel').text('Add New Image');
            $('#galleryModal').modal('show');
        }

        function openEditModal(id) {
            $.get('get_gallery.php?id=' + id, function(data) {
                var image = JSON.parse(data);
                $('#imageId').val(image.id);
                $('input[name="title"]').val(image.title);
                $('textarea[name="description"]').val(image.description);
                $('input[name="alt_text"]').val(image.alt_text);
                $('input[name="tags"]').val(JSON.parse(image.tags || '[]').join(', '));
                $('#currentImage').html('<img src="../assets/img/gallery/' + image.filename + '" width="100">');
                $('#cropperContainer').hide();
                if (cropper) cropper.destroy();
                $('#galleryModalLabel').text('Edit Image');
                $('#galleryModal').modal('show');
            });
        }

        $('#galleryForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            if (cropper && cropper.getCroppedCanvas()) {
                cropper.getCroppedCanvas().toBlob(function(blob) {
                    var file = new File([blob], 'cropped.jpg', {type: 'image/jpeg'});
                    formData.set('image', file);
                    sendForm(formData);
                });
            } else {
                sendForm(formData);
            }
        });
        function sendForm(formData) {
            $.ajax({
                url: 'gallery.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var res = JSON.parse(response);
                    alert(res.message);
                    if (res.success) {
                        $('#galleryModal').modal('hide');
                        location.reload();
                    }
                },
                error: function() {
                    alert('Error occurred');
                }
            });
        }

        $(document).ready(function() {
            $('input[name="image"]').change(function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#cropperImage').attr('src', e.target.result);
                        $('#cropperContainer').show();
                        if (cropper) cropper.destroy();
                        cropper = new Cropper(document.getElementById('cropperImage'), {
                            aspectRatio: 1,
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
                            autoCropArea: 0.8,
                            movable: true,
                            rotatable: true,
                            scalable: true,
                            zoomable: true,
                            zoomOnTouch: true,
                            zoomOnWheel: true,
                            cropBoxMovable: true,
                            cropBoxResizable: true,
                            minCropBoxWidth: 100,
                            minCropBoxHeight: 100,
                        });
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#cropperContainer').hide();
                    if (cropper) cropper.destroy();
                }
            });

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
                    $('input[name="image"]')[0].files = files;
                    $('input[name="image"]').trigger('change');
                }
            });

            $('#dropZone').click(function() {
                $('input[name="image"]').click();
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

        function setAspectRatio(ratio) {
            if (cropper) {
                cropper.setAspectRatio(ratio);
            }
        }
    </script>
</body>
</html>