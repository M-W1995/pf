<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('page/index.html.twig',[]);
    }


    /**
     * @Route("/contrat_obseques", name="contrat_obseques")
     */
    public function contratObseques()
    {
        return $this->render('page/contrat_obseques.html.twig', []);
    }
    
}
