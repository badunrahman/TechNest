<?php

declare(strict_types=1);

/**
 * This file contains the routes for the web application.
 */

use App\Controllers\CategoriesController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Controllers\ProductsController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\SessionManager;
use App\Controllers\DemoController;
use App\Controllers\FlashDemoController;


return static function (Slim\App $app): void {

    //ROuting group for the amdin panel

    $app->group('/admin', function ($group) {
        //TODO: add the admin related  routes here
        // Add/register admin routes.
        $group->get(
            '/dashboard',
            [DashboardController::class, 'index']
        )->setName('dashboard.index');

        // Product CRUD routes
        $group->get(
            '/products',
            [ProductsController::class, 'index']
        )->setName('products.index');

        $group->get(
            '/products/create',
            [ProductsController::class, 'create']
        )->setName('products.create');

        $group->post(
            '/products',
            [ProductsController::class, 'store']
        );

        $group->get(
            '/products/{id}/edit',
            [ProductsController::class, 'edit']
        )->setName('products.edit');

        $group->post(
            '/products/{id}',
            [ProductsController::class, 'update']
        );

        $group->get(
            '/products/{id}/delete',
            [ProductsController::class, 'delete']
        )->setName('products.delete');

        // Category CRUD routes
        $group->get(
            '/categories',
            [CategoriesController::class, 'index']
        )->setName('categories.index');

        $group->get(
            '/categories/create',
            [CategoriesController::class, 'create']
        )->setName('categories.create');

        $group->post(
            '/categories',
            [CategoriesController::class, 'store']
        );

        $group->get(
            '/categories/{id}/edit',
            [CategoriesController::class, 'edit']
        )->setName('categories.edit');

        $group->post(
            '/categories/{id}',
            [CategoriesController::class, 'update']
        );

        $group->get(
            '/categories/{id}/delete',
            [CategoriesController::class, 'delete']
        )->setName('categories.delete');
    });

    //* NOTE: Route naming pattern: [controller_name].[method_name]
    $app->get('/', [HomeController::class, 'index'])
        ->setName('home.index');

    $app->get('/home', [HomeController::class, 'index'])
        ->setName('home.index');



    // A route to test runtime error handling and custom exceptions.
    $app->get('/error', function (Request $request, Response $response, $args) {
        throw new \Slim\Exception\HttpNotFoundException($request, "Something went wrong");
    });

    $app->get('/test-session', function ($request, $response) {
        // Get current counter, increment it
        $counter = SessionManager::get('counter', 0) + 1;
        SessionManager::set('counter', $counter);

        $response->getBody()->write("Counter: " . $counter);

        return $response;
    });

    $app->get('/demo/counter', [DemoController::class, 'counter'])->setName('demo.counter');
    $app->post('/demo/reset', [DemoController::class, 'resetCounter'])->setName('demo.reset');


    // Flash message demo routes
    $app->get('/flash-demo', [FlashDemoController::class, 'index'])->setName('flash.demo');
    $app->post('/flash-demo/success', [FlashDemoController::class, 'success'])->setName('flash.success');
    $app->post('/flash-demo/error', [FlashDemoController::class, 'error'])->setName('flash.error');
    $app->post('/flash-demo/info', [FlashDemoController::class, 'info'])->setName('flash.info');
    $app->post('/flash-demo/warning', [FlashDemoController::class, 'warning'])->setName('flash.warning');
    $app->post('/flash-demo/multiple', [FlashDemoController::class, 'multiple'])->setName('flash.multiple');
};
