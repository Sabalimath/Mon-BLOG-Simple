<?php
require_once 'config.php';

 $errors = [];
 $title = '';
 $content = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    
    // Validation
    if (empty($title)) {
        $errors[] = 'Le titre est requis';
    } elseif (strlen($title) > 255) {
        $errors[] = 'Le titre ne doit pas dépasser 255 caractères';
    }
    
    if (empty($content)) {
        $errors[] = 'Le contenu est requis';
    }
    
    // Upload image
    $imageFilename = null;
    if (!empty($_FILES['image']['name'])) {
        $upload = uploadImage($_FILES['image']);
        if ($upload['success']) {
            $imageFilename = $upload['filename'];
        } else {
            $errors[] = $upload['error'];
        }
    }
    
    // Insertion si pas d'erreurs
    if (empty($errors)) {
        $stmt = $pdo->prepare('INSERT INTO articles (title, content, image) VALUES (?, ?, ?)');
        $stmt->execute([$title, $content, $imageFilename]);
        
        header('Location: index.php?success=added');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvel article - Mon Blog</title>
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
                <a href="index.php" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Articles
                </a>
                <a href="add.php" class="nav-link active">
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
                <div class="form-card">
                    <div class="form-header">
                        <h1 class="form-title">Nouvel article</h1>
                        <p class="form-subtitle">Remplissez le formulaire pour publier un nouvel article</p>
                    </div>

                    <!-- Errors -->
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-error">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <ul style="margin: 0; padding-left: 16px;">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= sanitize($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-label" for="title">Titre de l'article</label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                class="form-input" 
                                placeholder="Un titre accrocheur..."
                                value="<?= sanitize($title) ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="content">Contenu</label>
                            <textarea 
                                id="content" 
                                name="content" 
                                class="form-textarea" 
                                placeholder="Rédigez votre article ici..."
                                required
                            ><?= sanitize($content) ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Image <span>(optionnel)</span>
                            </label>
                            <div class="file-upload">
                                <div class="file-upload-area" id="dropZone">
                                    <svg class="file-upload-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="file-upload-text">Glissez une image ici ou cliquez pour sélectionner</p>
                                    <p class="file-upload-hint">JPG, PNG, GIF ou WEBP - Max 5MB</p>
                                </div>
                                <input type="file" name="image" class="file-input" id="imageInput" accept="image/*">
                                <div class="file-preview" id="filePreview">
                                    <img id="previewImg" src="" alt="Preview">
                                    <p class="file-preview-name" id="fileName"></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="index.php" class="btn-secondary">Annuler</a>
                            <button type="submit" class="btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Publier l'article
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        // File upload preview
        const dropZone = document.getElementById('dropZone');
        const imageInput = document.getElementById('imageInput');
        const filePreview = document.getElementById('filePreview');
        const previewImg = document.getElementById('previewImg');
        const fileName = document.getElementById('fileName');

        // Drag and drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                imageInput.files = e.dataTransfer.files;
                showPreview(e.dataTransfer.files[0]);
            }
        });

        imageInput.addEventListener('change', (e) => {
            if (e.target.files.length) {
                showPreview(e.target.files[0]);
            }
        });

        function showPreview(file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                    fileName.textContent = file.name;
                    filePreview.classList.add('show');
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>