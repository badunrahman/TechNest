<?php

namespace App\Controllers;

use App\Domain\Models\CategoriesModel;
use App\Domain\Models\ProductsModel;
use App\Helpers\FlashMessage;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductsController extends BaseController
{
    public function __construct(Container $container, private ProductsModel $products_model, private CategoriesModel $categories_model)
    {
        parent::__construct($container);
    }

    //* GET admin/products --> The list of products.
    public function index(Request $request, Response $response, array $args): Response
    {
        //* 1) Fetch from the DB.
        $products = $this->products_model->getProducts();

        //* 2) Prepare the data to be passed to the view
        //!NOTE: Must be a well-structured associative array.
        $data['data'] = [
            'title' => 'List of Products',
            'message' => 'Welcome to the home page',
            'products' => $products,
        ];
        return $this->render($response, "admin/products/productsIndexView.php", $data);
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        return $response;
        // $productId = (int) $args['id'];
        // $product = $this->productsModel->findById($productId);
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        return $response;
    }
    public function edit(Request $request, Response $response, array $args): Response
    {
        //* Step 1) Get the item id to be edited from the query params
        //* section of the URI
        $product_id = $args["product_id"];
        // dd("Editing product" . $product_id["id"]);

        //* Step 2) Pull the existing item identified by the received ID from the DB.
        $product = $this->products_model->getProductById($product_id);
        //* Step 2.a) Get the list of categories
        $categories = $this->categories_model->getCategories();

        //* Step 3) Pass it to the view where the update/editing from filled with the item info will be rendered.

        $data = [
            'page_title' => "Edit product details",
            'product' => $product,
            'categories' => $categories
        ];
        return $this->render($response, 'admin/products/productsEditView.php', $data);
    }
    //* ROUTE: Post /products/update
    public function update(Request $request, Response $response, array $args): Response
    {
        //! Handle the submission of the edit form.
        //? Save the edited product info.
        //* 1) Get the received form data from the request
        $products_info = $request->getParsedBody();
        // dd($products_info);
        //TODO: Add a flash message to be shown to the user in the master list (products list)
        FlashMessage::success('Successfully updated!');
        //* 2) Ask the model to save the product info.
        $this->products_model->updateProduct($products_info);
        return $this->redirect($request, $response, 'products.index');
    }
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $response;
    }
}
