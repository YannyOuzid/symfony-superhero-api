<?php

namespace App\Repository;

use App\Entity\Villain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Villain|null find($id, $lockMode = null, $lockVersion = null)
 * @method Villain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Villain[]    findAll()
 * @method Villain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VillainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Villain::class);
    }

    public function getAllVillains(): array
    {
        return $this->findBy(array('name' => 'ASC'));
    }

    // /**
    //  * @return Villain[] Returns an array of Villain objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Villain
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
