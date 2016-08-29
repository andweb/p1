<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="postaddress")
 *
 * @author Andrey Khramov <andronweb@gmail.com>
 */
class PostAddress
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $country;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $city;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $street;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $home;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $zipcode;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
}