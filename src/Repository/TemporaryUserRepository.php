<?php

namespace App\Repository;

use App\Entity\TemporaryUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TemporaryUser>
 *
 * @method TemporaryUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method TemporaryUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method TemporaryUser[]    findAll()
 * @method TemporaryUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemporaryUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TemporaryUser::class);
    }

    public function save(TemporaryUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TemporaryUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TemporaryUser[] Returns an array of TemporaryUser objects
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

//    public function findOneBySomeField($value): ?TemporaryUser
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function deleteById($id) 
    {
    return $this->createQueryBuilder('u')
        ->delete()
        ->where('u.id = :id')   
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult();        
    }
}
