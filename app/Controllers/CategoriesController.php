<?php

namespace App\Controllers;

use App\Domain\Models\CategoriesModel;
use App\Domain\Services\CategoryService;
use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoriesController extends BaseController
{
    private const FLASH_OLD_KEY = 'categories.old';
    private const FLASH_ERRORS_KEY = 'categories.errors';

    public function __construct(
        Container $container,
        private CategoriesModel $categoriesModel,
        private CategoryService $categoryService
    ) {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $categories = $this->categoriesModel->getAllCategories();

        $data = [
            'page_title' => 'Categories',
            'categories' => $categories,
        ];

        return $this->render($response, 'admin/categories/categoryIndexView.php', $data);
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        $data = [
            'page_title' => 'Create Category',
            'old' => $this->pullOldInput(),
            'errors' => $this->pullErrors(),
        ];

        return $this->render($response, 'admin/categories/categoryCreateView.php', $data);
    }

    public function store(Request $request, Response $response, array $args): Response
    {
        $payload = $request->getParsedBody() ?? [];
        $result = $this->categoryService->validateCategory($payload);

        if (!$result['success']) {
            SessionManager::set(self::FLASH_OLD_KEY, $result['data']);
            SessionManager::set(self::FLASH_ERRORS_KEY, $result['errors']);
            FlashMessage::error('Please fix the validation errors and try again.');

            return $this->redirect($request, $response, 'categories.create');
        }

        $this->categoriesModel->create($result['data']);
        FlashMessage::success('Category created successfully.');

        return $this->redirect($request, $response, 'categories.index');
    }

    public function edit(Request $request, Response $response, array $args): Response
    {
        $categoryId = isset($args['id']) ? (int) $args['id'] : 0;
        if ($categoryId <= 0) {
            FlashMessage::error('Invalid category selected.');
            return $this->redirect($request, $response, 'categories.index');
        }

        $category = $this->categoriesModel->findById($categoryId);
        if ($category === false) {
            FlashMessage::error('Category not found.');
            return $this->redirect($request, $response, 'categories.index');
        }

        $data = [
            'page_title' => 'Edit Category',
            'category' => $category,
            'old' => $this->pullOldInput(),
            'errors' => $this->pullErrors(),
        ];

        return $this->render($response, 'admin/categories/categoryEditView.php', $data);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $categoryId = isset($args['id']) ? (int) $args['id'] : 0;
        if ($categoryId <= 0) {
            FlashMessage::error('Invalid category selected.');
            return $this->redirect($request, $response, 'categories.index');
        }

        $payload = $request->getParsedBody() ?? [];
        $result = $this->categoryService->validateCategory($payload);

        if (!$result['success']) {
            SessionManager::set(self::FLASH_OLD_KEY, $result['data']);
            SessionManager::set(self::FLASH_ERRORS_KEY, $result['errors']);
            FlashMessage::error('Please fix the validation errors and try again.');

            return $this->redirect($request, $response, 'categories.edit', ['id' => $categoryId]);
        }

        $category = $this->categoriesModel->findById($categoryId);
        if ($category === false) {
            FlashMessage::error('Category not found.');
            return $this->redirect($request, $response, 'categories.index');
        }

        $this->categoriesModel->update($categoryId, $result['data']);
        FlashMessage::success('Category updated successfully.');

        return $this->redirect($request, $response, 'categories.index');
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $categoryId = isset($args['id']) ? (int) $args['id'] : 0;
        if ($categoryId <= 0) {
            FlashMessage::error('Invalid category selected.');
            return $this->redirect($request, $response, 'categories.index');
        }

        $category = $this->categoriesModel->findById($categoryId);
        if ($category === false) {
            FlashMessage::error('Category not found.');
            return $this->redirect($request, $response, 'categories.index');
        }

        $this->categoriesModel->delete($categoryId);
        FlashMessage::success('Category deleted successfully.');

        return $this->redirect($request, $response, 'categories.index');
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
