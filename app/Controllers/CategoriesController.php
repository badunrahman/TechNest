<?php

namespace App\Controllers;

use App\Domain\Models\CategoriesModel;
use App\Domain\Models\ProductsModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoriesController extends BaseController
{
    public function __construct(Container $container, private CategoriesModel $categories_model)
    {
        parent::__construct($container);
    }

    //* GET admin/products --> The list of products.
    public function index(Request $request, Response $response, array $args): Response
    {
        //* 1) Fetch from the DB.
        $categories = $this->categories_model->getCategories();

        //* 2) Prepare the data to be passed to the view
        //!NOTE: Must be a well-structured associative array.
        $data['data'] = [
            'title' => 'List of Categories',
            'message' => 'Welcome to the home page',
            'categories' => $categories,
        ];
        // dd($data);
        return $this->render($response, "admin/products/categoriesIndexView.php", $data);
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
        return $response;
    }
    //* ROUTE: Post /products/update
    public function update(Request $request, Response $response, array $args): Response
    {
        // //! Handle the submission of the edit form.
        // //* 1) Get the received form data from the request
        // $products_info = $request->getParsedBody();
        // dd($products_info);

        return $response;
    }
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $response;
    }
}
