<?php

namespace App\Controller;

use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LiftController extends AbstractController
{

    /**
     * Permet de créer une annonce
     * @Security("is_granted('ROLE_USER')")
     * @Route("/lift/create", name="lift_create")
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager){
        $form = $this->createForm(BookingType::class);

        $form->handleRequest($request);

        return $this->render('lift/lift_create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}