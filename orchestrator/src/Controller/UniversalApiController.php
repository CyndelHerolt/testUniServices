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

    #[Route('/universal/{endpoint}/{serve}', name: 'app_universal_get_all', methods: ['GET', 'POST'])]
    public function index(Request $request, string $endpoint, string $serve): Response
    {
        // si le endpoint contient un "_" on le remplace par un "/"
        $endpoint = str_replace('-', '/', $endpoint);
        $method = $request->getMethod();
        $datas = $method === 'POST' ? json_decode($request->getContent(), true) : null;
        $token = $request->headers->get('Authorization');

        $result = $this->universalApi->request($method, $token, $endpoint, $serve, $datas);
        return new Response($result, Response::HTTP_OK, ['Content-Type' => 'application/json']);

    }
}
