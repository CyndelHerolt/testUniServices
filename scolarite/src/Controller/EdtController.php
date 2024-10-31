<?php

namespace App\Controller;

use App\Repository\EdtPlanningRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EdtController extends AbstractController
{
    #[Route('/edt/get/week', name: 'app_edt_week')]
    public function index(Request $request, EdtPlanningRepository $edtPlanningRepository): Response
    {
        try {
            $datas = json_decode($request->getContent(), true);
            if (!isset($datas['start']) || !isset($datas['end'])) {
                throw new \InvalidArgumentException('Les paramètres "debut" et "fin" sont requis.');
            }

            $debut = new \DateTime($datas['start']);
            $fin = new \DateTime($datas['end']);

            $edtWeek = $edtPlanningRepository->getEdtWeek($debut, $fin);

            return $this->json($edtWeek);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
