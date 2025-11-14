<?php

use App\Helpers\ViewHelper;

$pageTitle = $data['page_title'] ?? 'Categories';
$categories = $data['categories'] ?? [];

ViewHelper::loadAdminHeader($pageTitle);
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= hs($pageTitle) ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a class="btn btn-sm btn-primary" href="<?= hs(APP_ADMIN_URL . '/categories/create') ?>">
                <span class="me-1">+</span> Create Category
            </a>
        </div>
    </div>

    <div class="mb-3">
        <?= App\Helpers\FlashMessage::render() ?>
    </div>

    <?php if (empty($categories)) : ?>
        <div class="alert alert-info">No categories found. Start by creating one.</div>
    <?php else : ?>
        <div class="table-responsive small">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Created</th>
                        <th scope="col">Updated</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category) : ?>
                        <tr>
                            <td><?= hs((string) ($category['id'] ?? '')) ?></td>
                            <td><?= hs((string) ($category['name'] ?? '')) ?></td>
                            <td><?= hs((string) ($category['description'] ?? '')) ?></td>
                            <td><?= hs(isset($category['created_at']) ? date_remove_secs((string) $category['created_at']) : '') ?></td>
                            <td><?= hs(isset($category['updated_at']) ? date_remove_secs((string) $category['updated_at']) : '') ?></td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-secondary me-1" href="<?= hs(APP_ADMIN_URL . '/categories/' . ($category['id'] ?? '') . '/edit') ?>">
                                    Edit
                                </a>
                                <a
                                    class="btn btn-sm btn-outline-danger"
                                    href="<?= hs(APP_ADMIN_URL . '/categories/' . ($category['id'] ?? '') . '/delete') ?>"
                                    onclick="return confirm('Are you sure you want to delete this category?');"
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
