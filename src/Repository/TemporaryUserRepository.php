<?php

namespace App\Repository;

use App\Entity\TemporaryUser;
use DateInterval;
use DateTime;
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


    public function deleteById($id) 
    {
    return $this->createQueryBuilder('tu')
        ->delete()
        ->where('tu.id = :id')   
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult();        
    }

    public function deleteExpiredUsers()
    {
        $dateLimit = new \DateTime();
        $dateLimit->modify('-2 days');

        return $this->createQueryBuilder('tu')
            ->delete()
            ->where('tu.created_at < :dateLimit')
            ->setParameter('dateLimit', $dateLimit)
            ->getQuery()
            ->execute();
    }

   
}
