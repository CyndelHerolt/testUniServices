<?php

namespace App\DataTransformer;

use App\Dto\EdtPlanningDto;
use App\Service\UserService;

class EdtPlanningDataTransformer
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function transform(array $edtPlanningData): EdtPlanningDto
    {
        $dto = new EdtPlanningDto();
        $dto->id = $edtPlanningData['id'] ?? null;
        $dto->userId = $edtPlanningData['userId'] ?? null;
        $dto->jour = $edtPlanningData['jour'] ?? null;
        $dto->salle = $edtPlanningData['salle'] ?? null;
        $dto->semaine = $edtPlanningData['semaine'] ?? null;
        $dto->type = $edtPlanningData['type'] ?? null;
        $dto->groupe = $edtPlanningData['groupe'] ?? null;
        $dto->date = isset($edtPlanningData['date']) ? new \DateTime($edtPlanningData['date']) : null;
        $dto->matiere = $edtPlanningData['matiere'] ?? null;
        $dto->debut = $edtPlanningData['debut'] ?? null;
        $dto->fin = $edtPlanningData['fin'] ?? null;

        if (isset($edtPlanningData['userId'])) {
            $userData = $this->userService->getUserData($edtPlanningData['userId']);
            $dto->userPrenom = $userData['prenom'] ?? null;
            $dto->userNom = $userData['nom'] ?? null;
        }

        return $dto;
    }
}
