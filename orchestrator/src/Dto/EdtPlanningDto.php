<?php

namespace App\Dto;

class EdtPlanningDto
{
    public ?int $id = null;
    public ?int $userId = null;
    public ?string $userPrenom = null;
    public ?string $userNom = null;
    public ?int $jour = null;
    public ?string $salle = null;
    public ?int $semaine = null;
    public ?string $type = null;
    public ?string $groupe = null;
    public ?\DateTimeInterface $date = null;
    public ?string $matiere = null;
    public ?float $debut = null;
    public ?float $fin = null;
}
