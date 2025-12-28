<?php
// API endpoint for gallery images
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once '../config.php';

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    // Get all gallery images
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $stmt = $pdo->query("SELECT * FROM gallery_images ORDER BY created_at DESC");
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Add full URLs to images
        foreach ($images as &$image) {
            $image['url'] = '../assets/img/gallery/' . $image['filename'];
            $image['thumbnail'] = '../assets/img/gallery/' . $image['filename'];
        }
        
        echo json_encode([
            'success' => true,
            'data' => $images,
            'count' => count($images)
        ]);
    }
    
    // Add new gallery image
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        checkAdminLogin();
        
        $alt_text = trim($_POST['alt_text'] ?? '');
        $filename = '';
        
        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($_FILES['image']['type'], $allowed_types)) {
                throw new Exception('Invalid file type. Only JPEG, PNG, GIF, WEBP allowed.');
            }
            $max_size = 100 * 1024; // 100KB limit
            if ($_FILES['image']['size'] > $max_size) {
                throw new Exception('File too large. Max 100KB allowed.');
            }
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . uniqid() . '.' . $ext;
            $target = "../assets/img/gallery/" . $filename;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                throw new Exception('Failed to upload image');
            }
        }
        
        // Handle cropped image data
        $cropped_image_data = $_POST['cropped_image'] ?? null;
        if ($cropped_image_data) {
            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $cropped_image_data));
            $filename = time() . '_' . uniqid() . '.webp';
            $target = "../assets/img/gallery/" . $filename;
            
            $image = imagecreatefromstring($image_data);
            if ($image === false) {
                throw new Exception('Invalid image data.');
            }
            
            // Save as WebP with quality control
            $quality = 80;
            $success = imagewebp($image, $target, $quality);
            imagedestroy($image);
            
            if (!$success) {
                throw new Exception('Failed to save WebP image.');
            }
            
            // Check file size and reduce quality if needed
            $file_size = filesize($target);
            while ($file_size > 100 * 1024 && $quality > 30) {
                $quality -= 10;
                imagewebp($image, $target, $quality);
                $file_size = filesize($target);
            }
        }
        
        if (!$filename) {
            throw new Exception('Image file is required');
        }
        
        $stmt = $pdo->prepare("INSERT INTO gallery_images (filename, alt_text) VALUES (?, ?)");
        $stmt->execute([$filename, $alt_text]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Image added successfully!',
            'data' => [
                'id' => $pdo->lastInsertId(),
                'filename' => $filename,
                'alt_text' => $alt_text,
                'url' => '../assets/img/gallery/' . $filename,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
    
    // Update gallery image
    elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        checkAdminLogin();
        
        parse_str(file_get_contents("php://input"), $put_vars);
        $id = $put_vars['id'] ?? null;
        $alt_text = trim($put_vars['alt_text'] ?? '');
        $filename = '';
        
        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($_FILES['image']['type'], $allowed_types)) {
                throw new Exception('Invalid file type. Only JPEG, PNG, GIF, WEBP allowed.');
            }
            $max_size = 100 * 1024; // 100KB limit
            if ($_FILES['image']['size'] > $max_size) {
                throw new Exception('File too large. Max 100KB allowed.');
            }
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . uniqid() . '.' . $ext;
            $target = "../assets/img/gallery/" . $filename;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                throw new Exception('Failed to upload image');
            }
        }
        
        // Handle cropped image data
        $cropped_image_data = $put_vars['cropped_image'] ?? null;
        if ($cropped_image_data) {
            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $cropped_image_data));
            $filename = time() . '_' . uniqid() . '.webp';
            $target = "../assets/img/gallery/" . $filename;
            
            $image = imagecreatefromstring($image_data);
            if ($image === false) {
                throw new Exception('Invalid image data.');
            }
            
            // Save as WebP with quality control
            $quality = 80;
            $success = imagewebp($image, $target, $quality);
            imagedestroy($image);
            
            if (!$success) {
                throw new Exception('Failed to save WebP image.');
            }
            
            // Check file size and reduce quality if needed
            $file_size = filesize($target);
            while ($file_size > 100 * 1024 && $quality > 30) {
                $quality -= 10;
                imagewebp($image, $target, $quality);
                $file_size = filesize($target);
            }
        }
        
        $query = "UPDATE gallery_images SET alt_text = ?";
        $params = [$alt_text];
        
        if ($filename) {
            $query .= ", filename = ?";
            $params[] = $filename;
        }
        
        $query .= " WHERE id = ?";
        $params[] = $id;
        
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        
        echo json_encode([
            'success' => true,
            'message' => 'Image updated successfully!'
        ]);
    }
    
    // Delete gallery image
    elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        checkAdminLogin();
        
        parse_str(file_get_contents("php://input"), $delete_vars);
        $id = $delete_vars['id'] ?? null;
        
        if (!$id) {
            throw new Exception('Image ID is required');
        }
        
        $stmt = $pdo->prepare("SELECT filename FROM gallery_images WHERE id = ?");
        $stmt->execute([$id]);
        $image = $stmt->fetch();
        
        if ($image) {
            $file_path = "../assets/img/gallery/" . $image['filename'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $stmt = $pdo->prepare("DELETE FROM gallery_images WHERE id = ?");
            $stmt->execute([$id]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Image deleted successfully!'
            ]);
        } else {
            throw new Exception('Image not found');
        }
    }
    
    else {
        throw new Exception('Method not allowed');
    }
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>