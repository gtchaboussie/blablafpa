<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
class Booking{

    //=================================================================
    //     ATTRIBUTS
    //=================================================================

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $bookingSeatsBooked;

    /**
     * @ORM\ManyToOne(targetEntity=Lift::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lift;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;



    //=================================================================
    //     SETTERS AND GETTERS
    //=================================================================

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookingSeatsBooked(): ?int
    {
        return $this->bookingSeatsBooked;
    }

    public function setBookingSeatsBooked(int $bookingSeatsBooked): self
    {
        $this->bookingSeatsBooked = $bookingSeatsBooked;

        return $this;
    }

    public function getLift(): ?Lift
    {
        return $this->lift;
    }

    public function setLift(?Lift $lift): self
    {
        $this->lift = $lift;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

}
