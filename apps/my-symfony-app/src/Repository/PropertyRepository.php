<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Property::class);
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    
    /**
     * Return the unsold property
     * @return Property[] Returns an array of Property objects
     */
    
    public function findAllUnsold() : Array
    {
        return $this->unsold()
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
    
    /**
     * Return the latest unsold property
     * @return Property[] Returns an array of Property objects
     */
    
    public function findLatestUnsold() : Array
    {
        return $this->unsold()
        ->orderBy('p.id', 'DESC')
        ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        }
        
    private function unsold()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sold = false');
    }
}
