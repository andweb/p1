<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
    
        $repository = $this->getDoctrine()->getRepository('AppBundle:Country');
    
    
    
        //$results = $repository->findAll();
        $results = $repository->findBy(
            array('name' => "Рос?")
        );
        

        // replace this example code with whatever you need
        return $this->render('default/homepage.html.twig', array(
            'results' => $results,
        ));
    }
}
