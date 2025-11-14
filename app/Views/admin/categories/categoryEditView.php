<?php

use App\Helpers\ViewHelper;

$pageTitle = $data['page_title'] ?? 'Edit Category';
$category = $data['category'] ?? [];
$old = $data['old'] ?? [];
$errors = $data['errors'] ?? [];

ViewHelper::loadAdminHeader($pageTitle);

$nameValue = $old['name'] ?? ($category['name'] ?? '');
$descriptionValue = $old['description'] ?? ($category['description'] ?? '');
$categoryId = (string) ($category['id'] ?? '');
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= hs($pageTitle) ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a class="btn btn-sm btn-outline-secondary" href="<?= hs(APP_ADMIN_URL . '/categories') ?>">Back to Categories</a>
        </div>
    </div>

    <div class="mb-3">
        <?= App\Helpers\FlashMessage::render() ?>
    </div>

    <form action="<?= hs(APP_ADMIN_URL . '/categories/' . $categoryId) ?>" method="POST" novalidate>
        <div class="mb-3">
            <label for="category-name" class="form-label">Name</label>
            <input
                type="text"
                id="category-name"
                name="name"
                value="<?= hs($nameValue) ?>"
                class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                required
            >
            <?php if (!empty($errors['name'])) : ?>
                <div class="invalid-feedback d-block"><?= hs($errors['name']) ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="category-description" class="form-label">Description</label>
            <textarea
                id="category-description"
                name="description"
                rows="4"
                class="form-control"
            ><?= hs($descriptionValue) ?></textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Category</button>
            <a class="btn btn-outline-secondary" href="<?= hs(APP_ADMIN_URL . '/categories') ?>">Cancel</a>
        </div>
    </form>
</main>
<?php
ViewHelper::loadJsScripts();
ViewHelper::loadAdminFooter();
?>
