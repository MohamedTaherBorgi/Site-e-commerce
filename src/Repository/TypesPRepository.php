<?php

namespace App\Repository;

use App\Entity\TypesP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypesP>
 *
 * @method TypesP|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypesP|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypesP[]    findAll()
 * @method TypesP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypesPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypesP::class);
    }

//    /**
//     * @return TypesP[] Returns an array of TypesP objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypesP
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
