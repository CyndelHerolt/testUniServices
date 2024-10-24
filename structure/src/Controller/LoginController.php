<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route(path: '/api/login', name: 'app_login')]
    public function jsonLogin(AuthenticationUtils      $authenticationUtils,
                              JWTTokenManagerInterface $JWTManager,
                              #[CurrentUser]           $user = null
    ): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        if ($error) {
            return new JsonResponse(['error' => $error], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (!$user) {
            return new JsonResponse(['error' => 'Invalid credentials'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Générez un token JWT pour l'utilisateur authentifié
        $token = $JWTManager->create($user);

        return new JsonResponse([
            'token' => $token
        ]);
    }
}
