<?php



namespace App\Repository;

use App\Entity\Cars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cars>
 */
class CarsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cars::class);
    }

    /**
     * @param array $criteria
     * @return Cars[]
     */
    public function findByCriteria(array $criteria): array
    {
        $qb = $this->createQueryBuilder('c');

        // Filtrer les voitures en fonction des critères
        if (!empty($criteria['Brand'])) {
            $qb->andWhere('c.Brand = :brand')
                ->setParameter('brand', $criteria['Brand']);
        }

        if (!empty($criteria['price'])) {
            $qb->andWhere('c.price <= :price')
                ->setParameter('price', $criteria['price']);
        }

        if (!empty($criteria['year'])) {
            $qb->andWhere('c.year >= :year')
                ->setParameter('year', $criteria['year']);
        }

        if (!empty($criteria['km'])) {
            $qb->andWhere('c.km <= :km')
                ->setParameter('km', $criteria['km']);
        }

        return $qb->getQuery()->getResult();
    }
}

//    /**
//     * @return Cars[] Returns an array of Cars objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cars
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

