<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'blog_db');
define('DB_USER', 'root'); // Modifie selon ta configuration
define('DB_PASS', '');     // Modifie selon ta configuration

// Connexion PDO
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Dossier d'upload
define('UPLOAD_DIR', 'uploads/');

// Créer le dossier uploads s'il n'existe pas
if (!file_exists(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

// Fonction pour nettoyer les entrées
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Fonction pour uploader une image
function uploadImage($file) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $maxSize = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($file['type'], $allowedTypes)) {
        return ['success' => false, 'error' => 'Type de fichier non autorisé'];
    }
    
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'error' => 'Fichier trop volumineux (max 5MB)'];
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $destination = UPLOAD_DIR . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return ['success' => true, 'filename' => $filename];
    }
    
    return ['success' => false, 'error' => 'Erreur lors de l\'upload'];
}
?>