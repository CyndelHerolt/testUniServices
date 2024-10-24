<?php

namespace App\Controller;

use App\Api\UserApi\LoginApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    public function __construct(
        private LoginApi $loginApi
    )
    {

    }

    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function index(Request $request): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $datas = [
            'email' => $email,
            'password' => $password
        ];

        $result = $this->loginApi->login($datas);

        return new Response($result);
    }
}
