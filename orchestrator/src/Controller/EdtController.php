<?php

namespace App\Controller;

use App\Api\ScolariteApi\EdtApi;
use App\Api\UserApi\UserApi;
use App\DataTransformer\EdtPlanningDataTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EdtController extends AbstractController
{
    public function __construct(
        private EdtApi $edtApi,
    )
    {
    }

    #[Route('/edt/week', name: 'app_edt')]
    public function index(Request $request): Response
    {
        $datas = json_decode($request->getContent(), true);
        $token = $request->headers->get('Authorization');

        $result = $this->edtApi->getEdtWeek($token, $datas);

        return $this->json($result);
    }
}
