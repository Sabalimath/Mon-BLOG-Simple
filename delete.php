<?php
require_once 'config.php';

// Récupérer l'article
 $id = (int)($_GET['id'] ?? 0);
 $stmt = $pdo->prepare('SELECT * FROM articles WHERE id = ?');
 $stmt->execute([$id]);
 $article = $stmt->fetch();

if (!$article) {
    header('Location: index.php');
    exit;
}

// Confirmation de suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Supprimer l'image si elle existe
    if ($article['image'] && file_exists($article['image'])) {
        unlink($article['image']);
    }
    
    // Supprimer l'article
    $stmt = $pdo->prepare('DELETE FROM articles WHERE id = ?');
    $stmt->execute([$id]);
    
    header('Location: index.php?success=deleted');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer l'article - Mon Blog</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <a href="index.php" class="logo">
                <span class="logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </span>
                Mon Blog
            </a>
            <nav class="nav">
                <a href="index.php" class="nav-link active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Articles
                </a>
                <a href="add.php" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouvel article
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main">
        <div class="container">
            <div class="form-container">
                <div class="form-card delete-confirm">
                    <svg class="delete-confirm-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    
                    <h1 class="delete-confirm-title">Supprimer cet article ?</h1>
                    <p class="delete-confirm-text">Cette action est irréversible. L'article et son image seront définitivement supprimés.</p>
                    
                    <div class="delete-preview">
                        <p class="delete-preview-title"><?= sanitize($article['title']) ?></p>
                        <p class="delete-preview-date">Publié le <?= date('d M Y', strtotime($article['created_at'])) ?></p>
                    </div>
                    
                    <form method="POST" class="delete-actions">
                        <a href="index.php" class="btn-secondary">
                            Annuler
                        </a>
                        <button type="submit" class="btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>