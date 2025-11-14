<?php

use App\Helpers\ViewHelper;

$pageTitle = $data['page_title'] ?? 'Create Category';
$old = $data['old'] ?? [];
$errors = $data['errors'] ?? [];

ViewHelper::loadAdminHeader($pageTitle);
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

    <form action="<?= hs(APP_ADMIN_URL . '/categories') ?>" method="POST" novalidate>
        <div class="mb-3">
            <label for="category-name" class="form-label">Name</label>
            <input
                type="text"
                id="category-name"
                name="name"
                value="<?= hs($old['name'] ?? '') ?>"
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
            ><?= hs($old['description'] ?? '') ?></textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save Category</button>
            <a class="btn btn-outline-secondary" href="<?= hs(APP_ADMIN_URL . '/categories') ?>">Cancel</a>
        </div>
    </form>
</main>
<?php
ViewHelper::loadJsScripts();
ViewHelper::loadAdminFooter();
?>
