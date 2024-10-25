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
        $method = $request->getMethod();
        $datas = $method === 'POST' ? $this->convertToOriginalTypes($request->request->all()) : [];
        $token = $request->headers->get('Authorization');
        $result = $this->universalApi->request($method, $token, $endpoint, $serve, $datas);

        return new Response($result, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    private function convertToOriginalTypes(array $datas): array
    {
        foreach ($datas as $key => $value) {
            $decodedValue = json_decode($value, true);
            // si il y a "type":"int" dans le JSON, on convertit en int et on renvoie seulement la valeur (sans le type)
            if (is_array($decodedValue) && array_key_exists('type', $decodedValue) && $decodedValue['type'] === 'int') {
                $datas[$key] = (int)$decodedValue['value'];
            }
        }
        return $datas;
    }
}
