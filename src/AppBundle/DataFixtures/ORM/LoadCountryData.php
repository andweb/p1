<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Country;

class LoadCountryData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $country = new Country();
        $country->setName('Россия');
        $manager->persist($country);
        
        $country = new Country();
        $country->setName('Белоруссия');
        $manager->persist($country);
        
        $country = new Country();
        $country->setName('Китай');
        $manager->persist($country);

        $country = new Country();
        $country->setName('Германия');
        $manager->persist($country);
        
        $manager->flush();
    }
}