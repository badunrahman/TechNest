<?php

use App\Helpers\SessionManager;

use App\Helpers\ViewHelper;
//TODO: set the page title dynamically based on the view being rendered in the controller.
$page_title = 'Products list';

//TODO: We need to load an admin-specific header.
ViewHelper::loadAdminHeader($page_title);
$products = $data['products'];
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    Share
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    Export
                </button>
            </div>
            <button
                type="button"
                class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                <svg class="bi" aria-hidden="true">
                    <use xlink:href="#calendar3"></use>
                </svg>
                This week
            </button>
        </div>
    </div>
    <h2>Product Listing</h2>
    <div class="table-responsive small">
        <h4>The list of products will be rendered here.</h4>
        <div class="mb-4">
            <?= App\Helpers\FlashMessage::render() ?>
        </div>
        <table class="table table-striped">
            <thead>
                <th>ID</th>
                <th>Category ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php foreach ($products as $key => $product) { ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= $product['category_id'] ?></td>
                        <td><?= $product['name'] ?></td>
                        <td> <?= $product['description'] ?></td>
                        <td> <?= $product['price'] ?></td>
                        <td> <?= $product['stock_quantity'] ?></td>
                        <td> <?= $product['created_at'] ?></td>
                        <td> <?= $product['updated_at'] ?></td>
                        <td>
                            <a href="products/edit/<?= $product['id'] ?>" class="btn btn-success">Edit</a>
                        </td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
        <?= SessionManager::get('username'); ?>
    </div>
</main>

<?php

ViewHelper::loadJsScripts();
//TODO: We need to load an admin-specific footer.
ViewHelper::loadAdminFooter();
?>
