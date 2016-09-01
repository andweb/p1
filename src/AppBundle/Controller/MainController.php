<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PostAddress;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/main")
 */
class MainController extends Controller
{  
    /**
     * @Route("/", defaults={"page": 1}, name="main_index")
     * @Route("/page/{page}", requirements={"page": "[1-9]\d*"}, name="blog_index_paginated")
     */
    public function indexAction(Request $request, $page)
    {
        $results = $this->getDoctrine()->getRepository('AppBundle:PostAddress')->findLatest($page);
        
        // replace this example code with whatever you need
        return $this->render('main/index.html.twig', array(
            'results' => $results,
        ));
    }
    
    /**
     * @Route("/parser")
     */
    public function parserAction()
    {
        /*
        $name = 'rostovondon';
        $pages = 26;
    
    
        $fp = fopen($name.'.txt', 'w');
        for ($i=1;$i<=$pages;$i++){
            $page = file_get_contents("http://www.street-viewer.ru/$name/street/$i/");
            preg_match_all("|<li[^>]+><a[^>]+>(.*)</a></li>|U", iconv('windows-1251', 'utf-8', $page), $matches);
        
            foreach ($matches[1] as $value){
                fwrite($fp, $value.PHP_EOL);
            }
            echo 'Page '.$i.' completed<br>';
        }
        fclose($fp);
        */
        
        $name = 'minsk';
        $fp = fopen($name.'.txt', 'w');

        $page = file_get_contents("http://minskonline.info/street/");
        preg_match_all("|<li><span[^>]+><a[^>]+>(.*)</a></span></li>|U", $page, $matches);

        foreach ($matches[1] as $value){
            fwrite($fp, $value.PHP_EOL);
        }

        fclose($fp);
        
        /*
        $handle = fopen("rostovondon.txt", "r");
        while (!feof($handle)) {
            $buffer = fgets($handle, 255);
            echo $buffer."!<br/>";
        }
        fclose($handle);
        */
        die();
    }
}
