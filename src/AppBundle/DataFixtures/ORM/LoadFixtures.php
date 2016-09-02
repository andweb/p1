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
 * Data: ~1080171 records, time load ~3-5 min 
 *
 * @author Andrey Khramov <andronweb@gmail.com>
 */
class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //  отключаем SQL Log чтобы убавить тормоза
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);
        
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
                    //  заносим строки в массив
                    $streets = file(__DIR__."/data/". $city_data[2] .".txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    while (count($streets)) {
                        //  берем и удаляем 1 элемент массива
                        $street = array_shift($streets);

                            //  generate zipcode
                            $zipcode = $city_data[1]*1000 + rand(0,199);
                            //  range 70 homes for each streen
                            foreach(range(1,70) as $home){
                                //  add PostAddress
                                //  выполняем нативный INSERT
                                $manager->getConnection()->insert('postaddress',
                                    array(
                                        'city_id'   => $city->getId(),
                                        'street'    => $street,
                                        'home'      => $home,
                                        'zipcode'   => $zipcode,
                                        'created_at'=> date("Y-m-d H:i:s", mktime(rand(1,23), rand(1,59), rand(1,59), rand(1,12), rand(1,31), rand(2010,2015)))
                                    )
                                );
                                /* участок кода очень сильно тормозил и был заменен на нативный SQL запрос INSERT
                                $postaddress = new PostAddress();
                                $postaddress->setStreet($street);
                                $postaddress->setHome($home);
                                $postaddress->setZipcode($zipcode);
                                $postaddress->setCreatedAt(new \DateTime(rand(2010,2015).'-'.rand(1,12).'-'.rand(1,31).' '.rand(1,23).':'.rand(1,59).':'.rand(1,59)));
                                $postaddress->setCity($city);
                                $manager->persist($postaddress);
                                */
                            }
                            $manager->flush();
                            //  чистим ObjectManager после каждых 70 запросов в базу
                            //  т.к. приводило к тормозам и переполнению памяти скриптом
                            //  исключаем очистку $country, т.к. вызовет ошибку при добавлении в базу следующего города
                            $manager->clear($country);
                    }
                }
            }
        }
        
        $manager->flush();
        $manager->clear();
    }
    
    //  тестовые данные
    private function getData(){
        return 
        [
            ["country"  => "Россия",    "cities" => 
                [
                /*  ["название", первые 3 цифры индекса, "data/{имя файлы с улицами}.txt"]  */ 
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