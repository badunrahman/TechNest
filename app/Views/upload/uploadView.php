<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Demo</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">File Upload Demo</h1>

        <!-- Flash Messages Display Area -->
        <div class="mb-4">
            <?= App\Helpers\FlashMessage::render() ?>
        </div>

        <!-- Upload Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Upload an Image</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="upload" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="myfile" class="form-label">Choose a file:</label>
                        <input
                            type="file"
                            class="form-control"
                            id="myfile"
                            name="myfile"
                            accept="image/*"
                            required>
                        <div class="form-text">
                            Select an image file to upload (JPEG, PNG, GIF).
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload File</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Uploaded Files Display -->
    <?php if (!empty($_SESSION['uploaded_files'])): ?>
        <div class="card mt-4">
            <div class="card-header">
                <h5>Uploaded Files</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach (array_reverse($_SESSION['uploaded_files']) as $filename): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img
                                    src="<?= APP_BASE_URL ?>/public/uploads/images/<?= htmlspecialchars($filename) ?>"
                                    class="card-img-top"
                                    alt="Uploaded image"
                                    style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <p class="card-text small text-muted">
                                        <?= htmlspecialchars($filename) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>