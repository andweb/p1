<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="city")
 *
 * @author Andrey Khramov <andronweb@gmail.com>
 */
class City
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="city")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    private $country;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;
    
    /**
     * @ORM\OneToMany(targetEntity="PostAddress", mappedBy="city")
     */
    private $postadresses;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->postadresses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return City
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set country
     *
     * @param \AppBundle\Entity\Country $country
     * @return City
     */
    public function setCountry(\AppBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \AppBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add postadresses
     *
     * @param \AppBundle\Entity\PostAddress $postadresses
     * @return City
     */
    public function addPostadress(\AppBundle\Entity\PostAddress $postadresses)
    {
        $this->postadresses[] = $postadresses;

        return $this;
    }

    /**
     * Remove postadresses
     *
     * @param \AppBundle\Entity\PostAddress $postadresses
     */
    public function removePostadress(\AppBundle\Entity\PostAddress $postadresses)
    {
        $this->postadresses->removeElement($postadresses);
    }

    /**
     * Get postadresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPostadresses()
    {
        return $this->postadresses;
    }
}
