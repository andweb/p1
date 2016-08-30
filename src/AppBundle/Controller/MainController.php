<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PostAddress;
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
        $results = $this->getDoctrine()->getRepository(PostAddress::class)->findAll();       

        // replace this example code with whatever you need
        return $this->render('default/homepage.html.twig', array(
            'results' => $results,
        ));
    }
}
