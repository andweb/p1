<?php

namespace AppBundle\Repository;

use AppBundle\Entity\PostAddress;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
//use Doctrine\ORM\Query\ResultSetMapping;


/**
 * PostAddressRepository
 *
 */
class PostAddressRepository extends EntityRepository
{
    public function findAll(){
        $default = [
            ['country'=>'Russia', 'city'=>'Moscow', 'street'=>'Lenina', 'home'=>10],
            ['country'=>'Russia', 'city'=>'St. Peterburg', 'street'=>'Nevsky', 'home'=>20]
        ];
        
        
        return $default;
    }
}
