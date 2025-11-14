<?php

use App\Helpers\ViewHelper;

$pageTitle = $data['page_title'] ?? 'Create Product';
$categories = $data['categories'] ?? [];
$old = $data['old'] ?? [];
$errors = $data['errors'] ?? [];

ViewHelper::loadAdminHeader($pageTitle);

$selectedCategory = isset($old['category_id']) ? (string) $old['category_id'] : '';
$options = ViewHelper::renderSelectOptions($categories, $selectedCategory, 'id', 'name');
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= hs($pageTitle) ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a class="btn btn-sm btn-outline-secondary" href="<?= hs(APP_ADMIN_URL . '/products') ?>">Back to Products</a>
        </div>
    </div>

    <div class="mb-3">
        <?= App\Helpers\FlashMessage::render() ?>
    </div>

    <form action="<?= hs(APP_ADMIN_URL . '/products') ?>" method="POST" novalidate>
        <div class="mb-3">
            <label for="product-name" class="form-label">Name</label>
            <input
                type="text"
                id="product-name"
                name="name"
                value="<?= hs($old['name'] ?? '') ?>"
                class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                required
            >
            <?php if (!empty($errors['name'])) : ?>
                <div class="invalid-feedback d-block"><?= hs($errors['name']) ?></div>
            <?php endif; ?>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <label for="product-price" class="form-label">Price</label>
                <input
                    type="text"
                    id="product-price"
                    name="price"
                    value="<?= hs($old['price'] ?? '') ?>"
                    class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>"
                    required
                >
                <?php if (!empty($errors['price'])) : ?>
                    <div class="invalid-feedback d-block"><?= hs($errors['price']) ?></div>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <label for="product-stock" class="form-label">Stock Quantity</label>
                <input
                    type="number"
                    id="product-stock"
                    name="stock_quantity"
                    value="<?= hs($old['stock_quantity'] ?? '') ?>"
                    min="0"
                    class="form-control <?= isset($errors['stock_quantity']) ? 'is-invalid' : '' ?>"
                >
                <?php if (!empty($errors['stock_quantity'])) : ?>
                    <div class="invalid-feedback d-block"><?= hs($errors['stock_quantity']) ?></div>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <label for="product-category" class="form-label">Category</label>
                <select
                    id="product-category"
                    name="category_id"
                    class="form-select"
                >
                    <?= $options ?>
                </select>
            </div>
        </div>

        <div class="mb-3 mt-3">
            <label for="product-description" class="form-label">Description</label>
            <textarea
                id="product-description"
                name="description"
                rows="4"
                class="form-control"
            ><?= hs($old['description'] ?? '') ?></textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save Product</button>
            <a class="btn btn-outline-secondary" href="<?= hs(APP_ADMIN_URL . '/products') ?>">Cancel</a>
        </div>
    </form>
</main>
<?php
ViewHelper::loadJsScripts();
ViewHelper::loadAdminFooter();
?>
