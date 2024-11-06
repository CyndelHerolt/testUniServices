<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\EdtPlanningRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EdtPlanningRepository::class)]
#[ApiResource(
    operations: [
        new Post(),
        new Get(),
        new GetCollection(),
    ],
    normalizationContext: ['groups' => ['edt_planning:read']],
    denormalizationContext: ['groups' => ['edt_planning:write']]
)]
#[ApiFilter(DateFilter::class, properties: ['date'])]
#[ApiFilter(SearchFilter::class, properties: ['userId' => 'exact'])]
class EdtPlanning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: false)]
    #[Groups(['edt_planning:read'])]
    private ?int $userId = null;

    #[ORM\Column]
    #[Groups(['edt_planning:read'])]
    private ?int $jour = null;

    #[ORM\Column(length: 100)]
    #[Groups(['edt_planning:read'])]
    private ?string $salle = null;

    #[ORM\Column]
    #[Groups(['edt_planning:read'])]
    private ?int $semaine = null;

    #[ORM\Column(length: 2)]
    #[Groups(['edt_planning:read'])]
    private ?string $type = null;

    #[ORM\Column(length: 100)]
    #[Groups(['edt_planning:read'])]
    private ?string $groupe = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['edt_planning:read'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    #[Groups(['edt_planning:read'])]
    private ?string $matiere = null;

    #[ORM\Column]
    #[Groups(['edt_planning:read'])]
    private ?float $debut = null;

    #[ORM\Column]
    #[Groups(['edt_planning:read'])]
    private ?float $fin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getJour(): ?int
    {
        return $this->jour;
    }

    public function setJour(int $jour): static
    {
        $this->jour = $jour;

        return $this;
    }

    public function getSalle(): ?string
    {
        return $this->salle;
    }

    public function setSalle(string $salle): static
    {
        $this->salle = $salle;

        return $this;
    }

    public function getSemaine(): ?int
    {
        return $this->semaine;
    }

    public function setSemaine(int $semaine): static
    {
        $this->semaine = $semaine;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getGroupe(): ?string
    {
        return $this->groupe;
    }

    public function setGroupe(string $groupe): static
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): static
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getDebut(): ?float
    {
        return $this->debut;
    }

    public function setDebut(float $debut): static
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?float
    {
        return $this->fin;
    }

    public function setFin(float $fin): static
    {
        $this->fin = $fin;

        return $this;
    }
}
