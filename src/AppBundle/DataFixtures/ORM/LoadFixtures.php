<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Country;
use AppBundle\Entity\City;
use AppBundle\Entity\PostAddress;

/**
 * Defines the sample data to load in the database when running the unit and
 * functional tests. Execute this command to load the data:
 *
 *   $ php app/console doctrine:fixtures:load
 *
 * @author Andrey Khramov <andronweb@gmail.com>
 */
class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = $this->getData();
        foreach($data as $key=>$country_data){
            //  add Country
            $country = new Country();
            $country->setName($country_data["country"]);
            $manager->persist($country);
            $manager->flush();
        
            foreach ($country_data["cities"] as $city_data){
                //  add City
                $city = new City();
                $city->setName($city_data[0]);
                $city->setCountry($country);
                $manager->persist($city);
                $manager->flush();
                
                //  file with street names for this city
                if (file_exists(__DIR__."/data/". $city_data[2] .".txt")){
                    $handle = fopen(__DIR__."/data/". $city_data[2] .".txt", "r");
                    while (!feof($handle)) {
                        $street = fgets($handle, 255);
                        if (!empty($street)) {
                            //  generate zipcode
                            $zipcode = $city_data[1]*1000 + rand(0,199);
                            //  range 70 homes for each streen
                            foreach(range(1,70) as $home){
                                $postaddress = new PostAddress();
                                $postaddress->setStreet($street);
                                $postaddress->setHome($home);
                                $postaddress->setZipcode($zipcode);
                                $postaddress->setCreatedAt(new \DateTime(rand(2010,2015).'-'.rand(1,12).'-'.rand(1,31).' '.rand(1,23).':'.rand(1,59).':'.rand(1,59)));
                                $postaddress->setCity($city);
                                $manager->persist($postaddress);
                            }
                            
                            //  add PostAddress
                            $manager->flush();
                        }
                    }
                    fclose($handle);
                }
            }
        }
    }
    
    
    private function getData(){
        return 
        [
            ["country"  => "Россия",    "cities" => 
                [
                    ["Москва",          101, "moscow"],
                    ["Санкт-Петербург", 197, "spb"],
                    ["Ростов-на-Дону",  344, "rostovondon"],
                    ["Казань",          420, "kazan"],
                    ["Нижний Новгород", 603, "nnovgorod"],
                    ["Ульяновск",       432, "ulyanovsk"],
                    ["Самара",          443, "samara"],
                    ["Екатеринбург",    620, "ekaterinburg"],
                    ["Волгоград",       400, "volgograd"]
                ]
            ],
            ["country"  => "Беларусь",  "cities" => 
                [
                    ["Минск",           220, "minsk"]
                ]
            ],
        ];
    }
}