<?php
require_once 'config.php';

// Check if slug columns exist and add them if not
$tables = ['tours', 'blogs'];

foreach ($tables as $table) {
    try {
        // Check if slug column exists
        $stmt = $pdo->query("SHOW COLUMNS FROM $table LIKE 'slug'");
        $columnExists = $stmt->fetch();

        if (!$columnExists) {
            // Add slug column
            $pdo->exec("ALTER TABLE $table ADD COLUMN slug VARCHAR(255) UNIQUE NOT NULL AFTER title");
            $pdo->exec("ALTER TABLE $table ADD INDEX idx_slug (slug)");
            echo "Added slug column to $table table.\n";
        } else {
            echo "Slug column already exists in $table table.\n";
        }
    } catch (Exception $e) {
        echo "Error with $table table: " . $e->getMessage() . "\n";
    }
}

// Generate slugs for existing tours
try {
    $stmt = $pdo->query("SELECT id, title FROM tours WHERE slug IS NULL OR slug = ''");
    $tours = $stmt->fetchAll();

    foreach ($tours as $tour) {
        $slug = generateSlug($tour['title'], 'tours', $tour['id']);
        $updateStmt = $pdo->prepare("UPDATE tours SET slug = ? WHERE id = ?");
        $updateStmt->execute([$slug, $tour['id']]);
        echo "Updated tour ID {$tour['id']} with slug: {$slug}\n";
    }
} catch (Exception $e) {
    echo "Error updating tours: " . $e->getMessage() . "\n";
}

// Generate slugs for existing blogs
try {
    $stmt = $pdo->query("SELECT id, title FROM blogs WHERE slug IS NULL OR slug = ''");
    $blogs = $stmt->fetchAll();

    foreach ($blogs as $blog) {
        $slug = generateSlug($blog['title'], 'blogs', $blog['id']);
        $updateStmt = $pdo->prepare("UPDATE blogs SET slug = ? WHERE id = ?");
        $updateStmt->execute([$slug, $blog['id']]);
        echo "Updated blog ID {$blog['id']} with slug: {$slug}\n";
    }
} catch (Exception $e) {
    echo "Error updating blogs: " . $e->getMessage() . "\n";
}

echo "Migration completed!\n";

// Add new columns to tours table
try {
    $columnsToAdd = [
        'internal_items' => 'JSON',
        'included_points' => 'JSON',
        'excluded_points' => 'JSON',
        'faq' => 'JSON',
        'schema' => 'TEXT',
        'show_price' => 'TINYINT(1) DEFAULT 1'
    ];

    foreach ($columnsToAdd as $column => $type) {
        $stmt = $pdo->query("SHOW COLUMNS FROM tours LIKE '$column'");
        $columnExists = $stmt->fetch();

        if (!$columnExists) {
            $pdo->exec("ALTER TABLE tours ADD COLUMN $column $type");
            echo "Added $column column to tours table.\n";
        } else {
            echo "$column column already exists in tours table.\n";
        }
    }
} catch (Exception $e) {
    echo "Error adding columns to tours table: " . $e->getMessage() . "\n";
}
?>