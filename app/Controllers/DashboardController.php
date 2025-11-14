<?php

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DashboardController extends BaseController
{

    public function __construct(Container  $container)
    {
        parent::__construct($container);
    }
    // can add callback for dashBoard logic

    public function index(Request $request, Response $response, array $args): Response
    {
        //$data['flash'] = $this->flash->getFlashMessage();
        //echo $data['message'] ;exit;


        $data['data'] = [
            'title' => 'Home',
            'message' => 'Welcome to the home page',
        ];

        //dd($data);
        //var_dump($this->session); exit;
        return $this->render($response, 'admin/dashboardView.php', $data);
    }
}
