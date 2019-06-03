<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Query;
use App\Entity\FilterProperties;

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
     * Return the query unsold property
     * @return Query Returns a query of Property unsold objects
     */
    
    public function findAllUnsoldQuery(FilterProperties $filter) : Query
    {
        $query =  $this->unsold()->orderBy('p.id', 'ASC');
        
        if ($filter->getPrice())
            $query = $query->andWhere("p.price <= :maxPrice")->setParameter("maxPrice", $filter->getPrice());
        if ($filter->getSurface())
            $query = $query->andWhere("p.surface >= :minSurface")->setParameter("minSurface", $filter->getSurface());
        if ($filter->getPostalCode())
            $query = $query->andWhere("p.postal_code = :postal_code")->setParameter("postal_code", $filter->getPostalCode());
        if ($filter->getRooms())
            $query = $query->andWhere("p.rooms >= :minRooms")->setParameter("minRooms", $filter->getRooms());
        if ($filter->getBedrooms())
            $query = $query->andWhere("p.bedrooms >= :minBedrooms")->setParameter("minBedrooms", $filter->getBedrooms());
        if ($filter->getOptions()->count() > 0)
        {
            $k = 0;
            foreach ($filter->getOptions() as $option)
            {
                $query = $query->andWhere(":option$k MEMBER OF p.options")->setParameter("option$k", $option);
                $k++;
            }
        }
        return $query->getQuery();
    }
    
    /**
     * Return the latest unsold property
     * @return Property[] Returns an array of Property objects
     */

    public function findLatestUnsold() : Array
    {
        return $this->unsold()
        ->orderBy('p.id', 'DESC')
        ->setMaxResults(4)
            ->getQuery()
            ->getResult();
        }
        
    private function unsold()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sold = false');
    }
}
