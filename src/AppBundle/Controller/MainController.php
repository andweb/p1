<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PostAddress;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\FormFilter;
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
        $results = $this->getDoctrine()->getRepository('AppBundle:PostAddress')->find($request, $page);
       
        $form = $this->createForm(FormFilter::class);

       
        
        // replace this example code with whatever you need
        return $this->render('main/index.html.twig', array(
            'results' => $results,
            'form' => $form->createView()
        ));
    }
}
