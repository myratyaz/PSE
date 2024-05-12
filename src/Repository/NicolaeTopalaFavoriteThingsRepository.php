<?php

namespace App\Repository;

use App\Entity\NicolaeTopalaFavoriteThings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NicolaeTopalaFavoriteThings>
 *
 * @method NicolaeTopalaFavoriteThings|null find($id, $lockMode = null, $lockVersion = null)
 * @method NicolaeTopalaFavoriteThings|null findOneBy(array $criteria, array $orderBy = null)
 * @method NicolaeTopalaFavoriteThings[]    findAll()
 * @method NicolaeTopalaFavoriteThings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NicolaeTopalaFavoriteThingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NicolaeTopalaFavoriteThings::class);
    }

//    /**
//     * @return NicolaeTopalaFavoriteThings[] Returns an array of NicolaeTopalaFavoriteThings objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NicolaeTopalaFavoriteThings
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
