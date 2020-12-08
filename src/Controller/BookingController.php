<?php

namespace App\Controller;

use App\Entity\Booking;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{

    /**
     * Permets l'affichage d'une reservation en détails
     * @Route("/booking/{id}", name="booking_show")
     */
    public function show(Booking $booking){
        
        return $this->render(
            'booking/show_booking.html.twig', [
                'booking' => $booking
            ]
        );
    }

    /**
     * Permet d'afficher la liste des réservations faites par l'utilisateur
     * @Route("/account/bookings", name="account_bookings")
     * @return Response
     */
    public function list()
    {
        return $this->render('booking/show_booking.html.twig');
    }
}
