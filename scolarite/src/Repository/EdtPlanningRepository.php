<?php

namespace App\Repository;

use App\Entity\EdtPlanning;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @extends ServiceEntityRepository<EdtPlanning>
 */
class EdtPlanningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EdtPlanning::class);
    }

    public function getEdtWeek(DateTimeInterface $debut, DateTimeInterface $fin): array
    {
        // récupérer les objets dont les dates sont comprises entre $debut et $fin
        return $this->createQueryBuilder('e')
            ->andWhere('e.date BETWEEN :debut AND :fin')
            ->setParameter('debut', $debut)
            ->setParameter('fin', $fin)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return EdtPlanning[] Returns an array of EdtPlanning objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?EdtPlanning
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
