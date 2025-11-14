<?php

use App\Helpers\SessionManager;

use App\Helpers\ViewHelper;
//TODO: set the page title dynamically based on the view being rendered in the controller.
$page_title = 'Edit Product Details';

//TODO: We need to load an admin-specific header.
ViewHelper::loadAdminHeader($page_title);
$product = $data['product'];
$categories = $data['categories'];
$options = ViewHelper::renderSelectOptions($categories, $product["category_id"], 'id', 'name')
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h2>Edit Product:</h2>
    <form class="row g-3" action="<?= APP_ADMIN_URL ?>/products/update" method="POST">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <div class="col-md-6">
            <label for="inputName" class="form-label">Name</label>
            <input type="text" name="product_name" value="<?= $product['name'] ?>" class="form-control" id="inputName">
        </div>
        <div class="col-md-6">
            <label for="inputDescription" class="form-label">Description</label>
            <input type="text" name="description" value="<?= $product['description'] ?>" class="form-control" id="inputDescription">
        </div>
        <div class="col-md-6">
            <label for="inputPrice" class="form-label">Price</label>
            <input type="text" value="<?= $product['price'] ?>" name="price" class="form-control" id="inputPrice">
        </div>
        <div class="col-md-4">
            <label for="inputCategory" class="form-label">Category:</label>
            <select id="inputCategory" name="category" class="form-select">
                <?= $options ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="inputQuantity" class="form-label">Quantity:</label>
            <input type="text" value="<?= $product['stock_quantity'] ?>" name="quantity" class="form-control" id="inputQuantity">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success">Save</button>
            <a class="btn btn-danger" href="<?= APP_ADMIN_URL ?>/products">Cancel</a>
        </div>
    </form>
</main>

<?php

ViewHelper::loadJsScripts();
//TODO: We need to load an admin-specific footer.
ViewHelper::loadAdminFooter();
?>
