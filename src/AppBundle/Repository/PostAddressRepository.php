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
    const NUM_ITEMS = 100;

    /*
    *   Default parameters
    */
    private $orderby = "p.createdAt";
    private $sort = "ASC";
    
    //  start method
    public function find($request, $page = 1){
        $this->setParamsByRequest($request);
        
        return $this->findLatest($page);
    }

    /*
    *   Строим запрос к базе данных
    */    
    private function bildQuery(){
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('p, c, cn')
            ->from('AppBundle:PostAddress', 'p')
            ->join('p.city','c')
            ->join('c.country', 'cn');
            
        $query->orderBy($this->orderby, $this->sort);
        
        return $query->getQuery();
    }
    
    /*
     * setSort(by, [acs or desc])
     */
    public function setParamsByRequest($request){
        //  ORDER BY
        switch (strtolower($request->query->get('orderby'))){
            case 'country':
                $this->orderby = "cn.name"; break;
            case 'city':
                $this->orderby = "c.name"; break;
            case 'street':
                $this->orderby = "p.street"; break;
            case 'date':
                $this->orderby = "p.createdAt"; break;
        }
        //  ASC or DESK
        switch (strtolower($request->query->get('sort'))){
            case 'asc':
                $this->sort = "ASC"; break;
            case 'desc':
                $this->sort = "DESC"; break;
        }
    }
    
    /**
     * @return Query
     */
    public function findAlls(){
    
        $dql = '    
                SELECT p, c, cn FROM AppBundle:PostAddress  
                JOIN p.city c
                JOIN c.country cn

                ORDER BY p.createdAt ASC
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
        return $this->bildQuery()->setFirstResult(self::NUM_ITEMS*($page-1))->setMaxResults(self::NUM_ITEMS)->getResult();
        /*
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->bildQuery(), false));
        $paginator->setMaxPerPage(self::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
        */
    }
}
