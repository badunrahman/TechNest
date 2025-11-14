<?php

use App\Helpers\ViewHelper;

$pageTitle = $data['page_title'] ?? 'Products';
$products = $data['products'] ?? [];

ViewHelper::loadAdminHeader($pageTitle);
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= hs($pageTitle) ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a class="btn btn-sm btn-primary" href="<?= hs(APP_ADMIN_URL . '/products/create') ?>">
                <span class="me-1">+</span> Create Product
            </a>
        </div>
    </div>

    <div class="mb-3">
        <?= App\Helpers\FlashMessage::render() ?>
    </div>

    <?php if (empty($products)) : ?>
        <div class="alert alert-info">No products found. Create the first one.</div>
    <?php else : ?>
        <div class="table-responsive small">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Price</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Created</th>
                        <th scope="col">Updated</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td><?= hs((string) ($product['id'] ?? '')) ?></td>
                            <td><?= hs((string) ($product['name'] ?? '')) ?></td>
                            <td><?= hs((string) ($product['category_name'] ?? $product['category_id'] ?? '')) ?></td>
                            <td>
                                <?php
                                $price = $product['price'] ?? 0;
                                $priceFormatted = is_numeric($price) ? number_format((float) $price, 2) : (string) $price;
                                ?>
                                $<?= hs($priceFormatted) ?>
                            </td>
                            <td><?= hs((string) ($product['stock_quantity'] ?? '')) ?></td>
                            <td><?= hs(isset($product['created_at']) ? date_remove_secs((string) $product['created_at']) : '') ?></td>
                            <td><?= hs(isset($product['updated_at']) ? date_remove_secs((string) $product['updated_at']) : '') ?></td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-secondary me-1" href="<?= hs(APP_ADMIN_URL . '/products/' . ($product['id'] ?? '') . '/edit') ?>">
                                    Edit
                                </a>
                                <a
                                    class="btn btn-sm btn-outline-danger"
                                    href="<?= hs(APP_ADMIN_URL . '/products/' . ($product['id'] ?? '') . '/delete') ?>"
                                    onclick="return confirm('Are you sure you want to delete this product?');"
                                >
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>
<?php
ViewHelper::loadJsScripts();
ViewHelper::loadAdminFooter();
?>
