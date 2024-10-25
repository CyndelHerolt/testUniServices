<?php

namespace App\Controller;

use App\Api\ScolariteApi\NoteApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NoteController extends AbstractController
{
    public function __construct(
        private NoteApi $noteApi
    )
    {

    }

    #[Route('/note', name: 'app_note', methods: ['POST'])]
    public function index(Request $request): Response
    {
        $libelle = $request->request->get('libelle');
        $coeff = $request->request->get('coeff');
        $note = $request->request->get('note');
        $student = $request->request->get('student');

        $datas = [
            'libelle' => $libelle,
            'coeff' => (int)$coeff,
            'note' => (float)$note,
            'etudiant' => (int)$student,
        ];

        // Appel à l'API de scolarité pour créer une note
        $result = $this->noteApi->create($datas);

        return new Response($result);
    }
}
