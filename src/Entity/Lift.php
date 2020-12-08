<?php

namespace App\Entity;

use App\Repository\LiftRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LiftRepository::class)
 */
class Lift{

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
     * @ORM\Column(type="string", length=255)
     */
    private $liftCityStart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $liftCityGoal;

    /**
     * @ORM\Column(type="datetime")
     */
    private $liftDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $liftSeats;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="lifts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="lift", orphanRemoval=true)
     */
    private $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }




    //=================================================================
    //     SETTERS AND GETTERS
    //=================================================================

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLiftCityStart(): ?string
    {
        return $this->liftCityStart;
    }

    public function setLiftCityStart(string $liftCityStart): self
    {
        $this->liftCityStart = $liftCityStart;

        return $this;
    }

    public function getLiftCityGoal(): ?string
    {
        return $this->liftCityGoal;
    }

    public function setLiftCityGoal(string $liftCityGoal): self
    {
        $this->liftCityGoal = $liftCityGoal;

        return $this;
    }

    public function getLiftDate(): ?\DateTimeInterface
    {
        return $this->liftDate;
    }

    public function setLiftDate(\DateTimeInterface $liftDate): self
    {
        $this->liftDate = $liftDate;

        return $this;
    }

    public function getLiftSeats(): ?int
    {
        return $this->liftSeats;
    }

    public function setLiftSeats(int $liftSeats): self
    {
        $this->liftSeats = $liftSeats;

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

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setLift($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getLift() === $this) {
                $booking->setLift(null);
            }
        }
        return $this;
    }

    //=================================================================
    //     METHODS
    //=================================================================

    /**
     * Renvoie le nombre total de sièges reservés sur le trajet
     */
    public function getBookedSeats(){
        $seatsBooked = 0;
        foreach ($this->bookings as $booking){
            $seatsBooked += $booking->getBookingSeatsBooked();
        }
        return $seatsBooked;
    }
}
