<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route(path: '/api/login', name: 'app_login')]
    public function jsonLogin(AuthenticationUtils      $authenticationUtils,
                              JWTTokenManagerInterface $JWTManager,
                              EventDispatcherInterface $dispatcher,
                              #[CurrentUser]           ?UserInterface $user = null,
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
        // ajouter l'ID de l'utilisateur au token
        $dispatcher->dispatch(new JWTCreatedEvent(['token' => $token], $user));
        return new JsonResponse([
            'token' => $token
        ]);
    }
}
