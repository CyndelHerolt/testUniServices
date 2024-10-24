<?php

namespace App\Controller;

use App\Api\UserApi\RegisterApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    public function __construct(
        private RegisterApi $registerApi
    )
    {

    }

    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function index(Request $request): Response
    {
        $username = $request->request->get('username');
        $email = $request->request->get('email');
        $password = password_hash($request->request->get('password'), PASSWORD_DEFAULT);
        $role = $request->request->get('role');

        switch ($role) {
            case 'Etudiant':
                $role = ['ROLE_ETUDIANT'];
                break;
            case 'Enseignant':
                $role = ['ROLE_ENSEIGNANT'];
                break;
            default:
                $role = ['ROLE_ADMINISTRATIF'];
        }

        $datas = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'roles' => $role
        ];

        $result = $this->registerApi->register($datas);

        return new Response($result);
    }
}
