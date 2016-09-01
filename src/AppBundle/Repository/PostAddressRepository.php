<?php

namespace AppBundle\Repository;

use AppBundle\Entity\PostAddress;
use Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * PostAddressRepository
 *
 * @author Andrey Khramov <andronweb@gmail.com>
 */
class PostAddressRepository extends EntityRepository
{
    const NUM_ITEMS = 1;
    /**
     * @return Query
     */
    public function findAll(){
    
        $dql = '    
                SELECT p, c, cn FROM AppBundle:PostAddress p 
                JOIN p.city c
                JOIN c.country cn

                ORDER BY p.zipcode ASC
               ';
    
        $query =  $this->getEntityManager()->createQuery($dql);                       
        return $query;
      
/*
                WHERE
                    cn.name LIKE :country
                AND c.name  LIKE :city
                
            ->setParameter('country', '%рос%')
            ->setParameter('city', '%мос%')
            
                       ->setFirstResult(2)
                       ->setMaxResults(2);
*/

    }
    
    /**
     * @param int $page
     *
     * @return Pagerfanta
     */
    public function findLatest($page = 1)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->findAll(), false));
        $paginator->setMaxPerPage(self::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}
