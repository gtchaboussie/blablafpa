<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController{
    
    /**
     * Permet d'afficher la page d'acceuil
     * @Route("/", name="homepage")
     * @return Response
     */
    public function home(){
        return $this->render('home.html.twig');
    }
}

?>
