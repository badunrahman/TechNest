<?php

namespace App\Controllers;

use App\Domain\Models\CategoriesModel;
use App\Domain\Models\ProductsModel;
use App\Domain\Services\ProductService;
use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductsController extends BaseController
{
    private const FLASH_OLD_KEY = 'products.old';
    private const FLASH_ERRORS_KEY = 'products.errors';

    public function __construct(
        Container $container,
        private ProductsModel $productsModel,
        private CategoriesModel $categoriesModel,
        private ProductService $productService
    ) {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $products = $this->productsModel->getAllProducts();

        $data = [
            'page_title' => 'Products',
            'products' => $products,
        ];

        return $this->render($response, 'admin/products/productIndexView.php', $data);
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        $categories = $this->categoriesModel->getAllCategories();

        $data = [
            'page_title' => 'Create Product',
            'categories' => $categories,
            'old' => $this->pullOldInput(),
            'errors' => $this->pullErrors(),
        ];

        return $this->render($response, 'admin/products/productCreateView.php', $data);
    }

    public function store(Request $request, Response $response, array $args): Response
    {
        $payload = $request->getParsedBody() ?? [];
        $result = $this->productService->validateProduct($payload);

        if (!$result['success']) {
            SessionManager::set(self::FLASH_OLD_KEY, $result['data']);
            SessionManager::set(self::FLASH_ERRORS_KEY, $result['errors']);
            FlashMessage::error('Please fix the validation errors and try again.');

            return $this->redirect($request, $response, 'products.create');
        }

        $this->productsModel->create($result['data']);
        FlashMessage::success('Product created successfully.');

        return $this->redirect($request, $response, 'products.index');
    }

    public function edit(Request $request, Response $response, array $args): Response
    {
        $productId = isset($args['id']) ? (int) $args['id'] : 0;
        if ($productId <= 0) {
            FlashMessage::error('Invalid product selected.');
            return $this->redirect($request, $response, 'products.index');
        }

        $product = $this->productsModel->findById($productId);
        if ($product === false) {
            FlashMessage::error('Product not found.');
            return $this->redirect($request, $response, 'products.index');
        }

        $categories = $this->categoriesModel->getAllCategories();

        $data = [
            'page_title' => 'Edit Product',
            'product' => $product,
            'categories' => $categories,
            'old' => $this->pullOldInput(),
            'errors' => $this->pullErrors(),
        ];

        return $this->render($response, 'admin/products/productEditView.php', $data);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $productId = isset($args['id']) ? (int) $args['id'] : 0;
        if ($productId <= 0) {
            FlashMessage::error('Invalid product selected.');
            return $this->redirect($request, $response, 'products.index');
        }

        $payload = $request->getParsedBody() ?? [];
        $result = $this->productService->validateProduct($payload);

        if (!$result['success']) {
            SessionManager::set(self::FLASH_OLD_KEY, $result['data']);
            SessionManager::set(self::FLASH_ERRORS_KEY, $result['errors']);
            FlashMessage::error('Please fix the validation errors and try again.');

            return $this->redirect($request, $response, 'products.edit', ['id' => $productId]);
        }

        $product = $this->productsModel->findById($productId);
        if ($product === false) {
            FlashMessage::error('Product not found.');
            return $this->redirect($request, $response, 'products.index');
        }

        $this->productsModel->update($productId, $result['data']);
        FlashMessage::success('Product updated successfully.');

        return $this->redirect($request, $response, 'products.index');
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $productId = isset($args['id']) ? (int) $args['id'] : 0;
        if ($productId <= 0) {
            FlashMessage::error('Invalid product selected.');
            return $this->redirect($request, $response, 'products.index');
        }

        $product = $this->productsModel->findById($productId);
        if ($product === false) {
            FlashMessage::error('Product not found.');
            return $this->redirect($request, $response, 'products.index');
        }

        $this->productsModel->delete($productId);
        FlashMessage::success('Product deleted successfully.');

        return $this->redirect($request, $response, 'products.index');
    }

    private function pullOldInput(): array
    {
        $old = SessionManager::get(self::FLASH_OLD_KEY, []);
        SessionManager::remove(self::FLASH_OLD_KEY);

        return is_array($old) ? $old : [];
    }

    private function pullErrors(): array
    {
        $errors = SessionManager::get(self::FLASH_ERRORS_KEY, []);
        SessionManager::remove(self::FLASH_ERRORS_KEY);

        return is_array($errors) ? $errors : [];
    }
}
