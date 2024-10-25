<?php

namespace App\Controller;

use App\Api\UniversalApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UniversalApiController extends AbstractController
{
    public function __construct(
        private UniversalApi $universalApi
    ) {}

    #[Route('/universal/{method}/{endpoint}/{serve}', name: 'app_universal_get_all', methods: ['GET'])]
    public function index(Request $request, string $method, string $endpoint, string $serve): Response
    {
        $token = $request->headers->get('Authorization');
        $result = $this->universalApi->request($method, $token, $endpoint, $serve);

        return new Response($result, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}