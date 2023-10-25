<?php

namespace App\Repository;

use App\Entity\Cars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CarsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cars::class);
    }

    // Ajoutez la méthode save pour persister une entité Car
    public function save(Cars $car, bool $flush = true)
    {
        $this->_em->persist($car);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // Ajoutez également la méthode remove pour supprimer une entité Car
    public function remove(Cars $car, bool $flush = true)
    {
        $this->_em->remove($car);
        if ($flush) {
            $this->_em->flush();
        }
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
